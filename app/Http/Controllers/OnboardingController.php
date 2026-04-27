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
        return view('onboarding.role');
    }

    public function saveRole(Request $request)
    {
        $validated = $request->validate([
            'role' => ['required', 'string', 'max:255'],
        ]);

        Session::put('onboarding.role', $validated['role']);

        return redirect()->route('onboarding.companion');
    }

    // Step 2: Companion Selection (Guest)
    public function companion()
    {
        $role = Session::get('onboarding.role', 'Founder');
        $companions = AiCharacter::where('occupation', $role)->get();

        // Fallback if no companions for role
        if ($companions->isEmpty()) {
            $companions = AiCharacter::all();
        }

        return view('onboarding.companion', compact('companions'));
    }

    public function saveCompanion(Request $request)
    {
        $validated = $request->validate([
            'companion_id' => ['required', 'exists:ai_characters,id'],
        ]);

        Session::put('onboarding.companion_id', $validated['companion_id']);

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
        return view('onboarding.business');
    }

    public function saveBusiness(Request $request)
    {
        $validated = $request->validate([
            'business_name' => ['required', 'string', 'max:255'],
            'business_url' => ['nullable', 'url', 'max:255'],
            'business_description' => ['required', 'string'],
        ]);

        UserProfile::updateOrCreate(
            ['user_id' => Auth::id()],
            $validated
        );

        return redirect()->route('onboarding.calling');
    }

    // Step 5: Calling Setup (Auth)
    public function calling()
    {
        return view('onboarding.calling');
    }

    public function saveCalling(Request $request)
    {
        $validated = $request->validate([
            'phone_number' => ['required', 'string', 'max:20'],
            'availability_hours' => ['required', 'array'],
            'max_call_duration' => ['required', 'integer', 'min:1', 'max:60'],
            'daily_calling_limit' => ['required', 'integer', 'min:1', 'max:20'],
        ]);

        UserProfile::updateOrCreate(
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
            // Dispatch call initiation with 5 second delay
            \App\Jobs\InitiateOnboardingCallJob::dispatch(Auth::id())->delay(now()->addSeconds(5));
            return redirect()->route('onboarding.waiting_call');
        }

        return redirect()->route('onboarding.details');
    }

    public function waitingCall()
    {
        $user = Auth::user();
        $companion = $user->companion;
        return view('onboarding.waiting_call', compact('companion'));
    }

    // Step 7: Platform Onboarding Details (Auth)
    public function details()
    {
        return view('onboarding.details');
    }

    public function saveDetails(Request $request)
    {
        $validated = $request->validate([
            'business_type' => ['required', 'string', 'max:255'],
            'industry' => ['required', 'string', 'max:255'],
            'target_audience' => ['nullable', 'string'],
            'experience_level' => ['required', 'in:beginner,intermediate,expert'],
        ]);

        UserProfile::updateOrCreate(
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
}
