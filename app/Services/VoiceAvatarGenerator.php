<?php

namespace App\Services;

use App\Models\Voice;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VoiceAvatarGenerator
{
    private const SIZE = 512;

    /**
     * Generate a simple branded avatar (colored gradient + initial) for a voice.
     * Only generated when none exists — manually uploaded avatars are respected.
     *
     * @return string|null relative path (voice-avatars/xxx.png)
     */
    public function generate(Voice $voice, string $hexColor): ?string
    {
        if (!function_exists('imagecreatetruecolor')) {
            return null;
        }

        $hex = ltrim($hexColor, '#');
        $r = (int) hexdec(substr($hex, 0, 2));
        $g = (int) hexdec(substr($hex, 2, 2));
        $b = (int) hexdec(substr($hex, 4, 2));

        $size = self::SIZE;
        $img = imagecreatetruecolor($size, $size);

        // Vertical gradient: brighter at top → deeper at bottom
        for ($y = 0; $y < $size; $y++) {
            $f = 1 - ($y / $size) * 0.45;
            $col = imagecolorallocate($img, (int) ($r * $f), (int) ($g * $f), (int) ($b * $f));
            imageline($img, 0, $y, $size, $y, $col);
        }

        // White inner ring for a polished profile look
        $ring = imagecolorallocate($img, 255, 255, 255);
        imagesetthickness($img, 10);
        imageellipse($img, intdiv($size, 2), intdiv($size, 2), (int) ($size * 0.72), (int) ($size * 0.72), $ring);

        // Initial letter, centered
        $initial = strtoupper(substr($voice->name ?: '?', 0, 1));
        $white = imagecolorallocate($img, 255, 255, 255);
        $w = strlen($initial) * imagefontwidth(5);
        $h = imagefontheight(5);
        imagestring($img, 5, (int) (intdiv($size, 2) - $w / 2), (int) (intdiv($size, 2) - $h / 2), $initial, $white);

        ob_start();
        imagepng($img);
        $png = ob_get_clean();
        imagedestroy($img);

        $path = 'voice-avatars/' . Str::slug($voice->name) . '-' . Str::lower(Str::random(5)) . '.png';
        Storage::disk('public')->put($path, $png);

        return $path;
    }
}