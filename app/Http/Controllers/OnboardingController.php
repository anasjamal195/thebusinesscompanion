<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessTaskJob;
use App\Models\AiCharacter;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class OnboardingController extends Controller
{
    // Step 1: Role Selection (Guest)
    public function role()
    {
        $role = Auth::check() ? Auth::user()->role : Session::get('onboarding.role');
        return view('onboarding.role', compact('role'));
    }

    public function saveRole(Request $request)
    {
        $validated = $request->validate([
            'role' => ['required', 'string', 'max:255'],
        ]);

        if (Auth::check()) {
            Auth::user()->update(['role' => $validated['role']]);
        }
        
        Session::put('onboarding.role', $validated['role']);

        return redirect()->route('onboarding.companion');
    }

    // Step 2: Companion Selection (Guest)
    public function companion()
    {
        $role = Auth::check() ? Auth::user()->role : Session::get('onboarding.role', 'Founder');
        $companions = AiCharacter::where('occupation', $role)->get();
        
        $selectedCompanionId = Auth::check() ? Auth::user()->companion_id : Session::get('onboarding.companion_id');

        // Fallback if no companions for role
        if ($companions->isEmpty()) {
            $companions = AiCharacter::all();
        }

        return view('onboarding.companion', compact('companions', 'selectedCompanionId', 'role'));
    }

    public function saveCompanion(Request $request)
    {
        $validated = $request->validate([
            'companion_id' => ['required', 'exists:ai_characters,id'],
        ]);

        if (Auth::check()) {
            Auth::user()->update(['companion_id' => $validated['companion_id']]);
        }
        
        Session::put('onboarding.companion_id', $validated['companion_id']);

        if (Auth::check()) {
            return redirect()->route('onboarding.business');
        }

        return redirect()->route('onboarding.checkout');
    }

    // Step 3: Checkout & Registration (Guest)
    public function checkout()
    {
        $companionId = Session::get('onboarding.companion_id');
        if (!$companionId)
            return redirect()->route('onboarding.role');

        $companion = AiCharacter::find($companionId);
        return view('onboarding.checkout', compact('companion'));
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => Session::get('onboarding.role'),
            'companion_id' => Session::get('onboarding.companion_id'),
        ]);

        Auth::login($user);

        $companion = AiCharacter::find($user->companion_id);

        /** @var User $user */
        $amountInCents = (int)round($companion->monthly_price * 100);
        $productName = $companion->name . ' - Business Companion Subscription';

        // Use Cashier's checkout with price_data to create price on the fly
        return $user->checkout([
            [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $productName,
                    ],
                    'unit_amount' => $amountInCents,
                    'recurring' => [
                        'interval' => 'month',
                    ]
                ],
                'quantity' => 1,
            ]
        ], [
            'success_url' => route('onboarding.business'),
            'cancel_url' => route('onboarding.checkout'),
            'mode' => 'subscription',
            'subscription_data' => [
                'metadata' => [
                    'user_id' => $user->id,
                    'companion_id' => $companion->id,
                    'type' => 'subscription'
                ]
            ]
        ]);
    }

    // Step 4: Business Information (Auth)
    public function business()
    {
        $user = Auth::user();
        $profile = $user->profile;
        return view('onboarding.business', compact('profile'));
    }

    public function saveBusiness(Request $request)
    {
        $validated = $request->validate([
            'business_name' => ['required', 'string', 'max:255'],
            'business_url' => ['nullable', 'url', 'max:255'],
            'business_description' => ['required', 'string'],
        ]);

        $user = Auth::user();
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return redirect()->route('onboarding.calling');
    }

    // Step 5: Calling Setup (Auth)
    public function calling()
    {
        $profile = Auth::user()->profile;
        return view('onboarding.calling', compact('profile'));
    }

    public function saveCalling(Request $request)
    {
        $validated = $request->validate([
            'phone_number' => ['required', 'string', 'max:20'],
            'availability_hours' => ['required', 'array'],
            'max_call_duration' => ['required', 'integer', 'min:1', 'max:60'],
            'daily_calling_limit' => ['required', 'integer', 'min:1', 'max:20'],
        ]);

        Auth::user()->profile()->updateOrCreate(
            ['user_id' => Auth::id()],
            $validated
        );

        return redirect()->route('onboarding.method');
    }

    // Step 6: Onboarding Method Choice (Auth)
    public function method()
    {
        return view('onboarding.method');
    }

    public function saveMethod(Request $request)
    {
        $method = $request->input('method');

        if ($method === 'call') {
            // Outbound phone call
            \App\Jobs\InitiateOnboardingCallJob::dispatch(Auth::id())->delay(now()->addSeconds(5));
            return redirect()->route('onboarding.waiting_call', ['type' => 'phone']);
        }

        if ($method === 'web-call') {
            // In-browser web call
            return redirect()->route('onboarding.waiting_call', ['type' => 'web']);
        }

        return redirect()->route('onboarding.details');
    }

    public function waitingCall(Request $request, \App\Services\VapiService $vapiService)
    {
        $user = Auth::user();
        $companion = $user->companion;
        $type = $request->query('type', 'phone');
        
        $vapiPublicKey = config('services.vapi.public_key');
        $callData = $vapiService->getWebCallData($user, 'onboarding');
        
        // Reuse existing initiated call if it exists (within last 30 mins) to prevent duplicates on refresh
        $localCall = \App\Models\Call::where('user_id', $user->id)
            ->where('ai_character_id', $companion->id)
            ->where('status', 'initiated')
            ->where('created_at', '>', now()->subMinutes(30))
            ->first();

        if (!$localCall) {
            $localCall = \App\Models\Call::create([
                'user_id' => $user->id,
                'ai_character_id' => $companion->id,
                'status' => 'initiated',
                'direction' => 'outbound',
            ]);
        }
        
        $localCallId = $localCall->id;
        
        $assistantId = $callData['assistantId'];
        $systemPromptTemplate = $callData['systemPromptTemplate'];
        $fullSystemPrompt = $callData['fullSystemPrompt'];
        $firstMessage = $callData['firstMessage'];

        return view('onboarding.waiting_call', compact('companion', 'type', 'vapiPublicKey', 'assistantId', 'systemPromptTemplate', 'fullSystemPrompt', 'firstMessage', 'localCallId'));
    }

    public function retryCall()
    {
        \App\Jobs\InitiateOnboardingCallJob::dispatch(Auth::id());
        return redirect()->back()->with('success', 'Call re-initiated. Please wait.');
    }

    // Step 7: Platform Onboarding Details (Auth)
    public function details()
    {
        $profile = Auth::user()->profile;
        return view('onboarding.details', compact('profile'));
    }

    public function saveDetails(Request $request)
    {
        $validated = $request->validate([
            'business_type' => ['required', 'string', 'max:255'],
            'industry' => ['required', 'string', 'max:255'],
            'target_audience' => ['nullable', 'string'],
            'experience_level' => ['required', 'in:beginner,intermediate,expert'],
        ]);

        Auth::user()->profile()->updateOrCreate(
            ['user_id' => Auth::id()],
            $validated
        );

        return redirect()->route('onboarding.task');
    }

    // Step 8: Optional Problem/Task (Auth)
    public function task()
    {
        return view('onboarding.task');
    }

    public function complete(Request $request)
    {
        $validated = $request->validate([
            'project_name' => ['required', 'string', 'max:255'],
            'project_url' => ['nullable', 'url', 'max:255'],
            'project_description' => ['nullable', 'string'],
            'success_metric' => ['nullable', 'string', 'max:255'],
            'current_problems' => ['nullable', 'string'],
            'urgent_tasks' => ['nullable', 'string'],
        ]);

        $user = Auth::user();
        $profile = $user->profile;

        return DB::transaction(function () use ($user, $profile, $validated) {
            $profile->update([
                'current_problems' => $validated['current_problems'],
                'urgent_tasks' => $validated['urgent_tasks'],
            ]);

            // Create initial project with the provided name and details
            $project = Project::create([
                'user_id' => $user->id,
                'name' => $validated['project_name'],
                'domain' => $validated['project_url'],
                'description' => $validated['project_description'] ?? 'Initial project based on onboarding input.',
                'success_metric' => $validated['success_metric'],
            ]);

            if ($validated['current_problems'] || $validated['urgent_tasks']) {
                $task = Task::create([
                    'project_id' => $project->id,
                    'user_id' => $user->id,
                    'title' => 'Initial Assessment',
                    'input_text' => "Current Problems: " . ($validated['current_problems'] ?? 'None') . "\nUrgent Tasks: " . ($validated['urgent_tasks'] ?? 'None'),
                    'priority' => 'high',
                    'status' => 'pending',
                ]);

                ProcessTaskJob::dispatch($task->id);
            }

            $user->update(['onboarding_completed' => true]);

            return redirect()->route('projects.show', $project);
        });
    }
    public static function getNextOnboardingRoute(User $user)
    {
        if ($user->onboarding_completed) {
            return route('dashboard');
        }

        if (!$user->role) {
            return route('onboarding.role');
        }

        if (!$user->companion_id) {
            return route('onboarding.companion');
        }

        $profile = $user->profile;

        if (!$profile || !$profile->business_name) {
            return route('onboarding.business');
        }

        if (!$profile->phone_number) {
            return route('onboarding.calling');
        }

        // If they have a phone number but haven't completed onboarding, 
        // they probably need to do the call or finalize details.
        if (!$profile->business_type || !$profile->industry) {
            return route('onboarding.details');
        }

        return route('onboarding.task');
    }
}
