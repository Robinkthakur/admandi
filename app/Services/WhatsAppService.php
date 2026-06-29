<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Send a WhatsApp message to a phone number.
     *
     * @param string $to
     * @param string $message
     * @return bool
     */
    public function send(string $to, string $message): bool
    {
        $enabled = Setting::get('whatsapp_enabled', false);
        if (!$enabled) {
            Log::info("WhatsApp sending is disabled. Target: {$to}, Message: {$message}");
            return false;
        }

        $apiUrl = Setting::get('whatsapp_api_url');
        if (!$apiUrl) {
            Log::error("WhatsApp API URL is not configured.");
            return false;
        }

        $authKey = Setting::get('whatsapp_auth_key');
        $method = Setting::get('whatsapp_request_method', 'GET');
        $phoneParam = Setting::get('whatsapp_phone_param', 'mobile');
        $msgParam = Setting::get('whatsapp_message_param', 'message');
        $headersJson = Setting::get('whatsapp_headers');

        // Clean phone number: remove non-digits
        $toCleaned = preg_replace('/[^0-9]/', '', $to);
        if (strlen($toCleaned) === 10) {
            $toCleaned = '91' . $toCleaned; // default country code for India
        }

        $headers = [];
        if ($headersJson) {
            $headers = json_decode($headersJson, true) ?? [];
        }

        $params = [
            $phoneParam => $toCleaned,
            $msgParam => $message,
        ];

        if ($authKey) {
            $params['authkey'] = $authKey;
            $params['token'] = $authKey;
            $params['apikey'] = $authKey;
        }

        Log::info("Sending WhatsApp notification to {$toCleaned} via {$apiUrl}...");

        try {
            $request = Http::withHeaders($headers);
            
            if (strtoupper($method) === 'POST') {
                $response = $request->post($apiUrl, $params);
            } else {
                $response = $request->get($apiUrl, $params);
            }

            Log::info("WhatsApp API Response: Status: " . $response->status() . " Body: " . $response->body());
            return $response->successful();
        } catch (\Exception $e) {
            Log::error("Failed to send WhatsApp message: " . $e->getMessage());
            return false;
        }
    }
}
