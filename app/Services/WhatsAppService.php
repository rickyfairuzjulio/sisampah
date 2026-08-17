<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Format phone number to international Indonesian format (e.g. 6281234567890).
     */
    public static function formatPhoneNumber($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (str_starts_with($phone, '8')) {
            $phone = '62' . $phone;
        }
        return $phone;
    }

    /**
     * Generate direct WhatsApp web click-to-chat URL.
     */
    public static function getWaUrl($phone, $message)
    {
        $formattedPhone = self::formatPhoneNumber($phone);
        return 'https://wa.me/' . $formattedPhone . '?text=' . urlencode($message);
    }

    /**
     * Send automated WhatsApp notification using Fonnte API or log fallback.
     */
    public static function sendNotification($phone, $message)
    {
        $formattedPhone = self::formatPhoneNumber($phone);
        $token = env('FONNTE_TOKEN', env('WA_API_KEY'));

        if ($token) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => $token,
                ])->post('https://api.fonnte.com/send', [
                    'target' => $formattedPhone,
                    'message' => $message,
                ]);

                if ($response->successful()) {
                    Log::info("WhatsApp notification sent via Fonnte to {$formattedPhone}");
                    return true;
                } else {
                    Log::warning("Fonnte WA API error: " . $response->body());
                }
            } catch (\Exception $e) {
                Log::warning("WhatsApp API exception: " . $e->getMessage());
            }
        }

        // Log WhatsApp message for local development & tracking
        Log::info("WhatsApp Message Logged for {$formattedPhone}:\n{$message}");
        return false;
    }
}
