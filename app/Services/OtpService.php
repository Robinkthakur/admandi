<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class OtpService
{
    public function generate(User $user): string
    {
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $user->update([
            'otp_code'       =>  $otp,//Hash::make($otp),
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        return $otp;
    }

    public function verify(User $user, string $otp, string $verifiedField = 'email'): bool
    {
        if (!$user->otp_expires_at || now()->gt($user->otp_expires_at)) {
            return false;
        }

        if($otp !== $user->otp_code){
            return false;
        }
        // if (!Hash::check($otp, $user->otp_code)) {
        //     return false;
        // }

        $updateData = [
            'otp_code'        => null,
            'otp_expires_at'  => null,
        ];

        if ($verifiedField === 'phone') {
            $updateData['phone_verified_at'] = $user->phone_verified_at ?? now();
        } else {
            $updateData['email_verified_at'] = $user->email_verified_at ?? now();
        }

        $user->update($updateData);

        return true;
    }

    public function sendEmail(User $user, string $otp): void
    {
        Mail::raw("Your OTP for adMandi is: $otp. Valid for 10 minutes.", function ($m) use ($user) {
            $m->to($user->email)->subject('Your Verification OTP');
        });
    }

    public function sendSms(User $user, string $otp): void
    {
        $phone = $user->phone;
        $phoneCleaned = preg_replace('/[^0-9]/', '', $phone);
        
        // Prepend country code 91 for Indian numbers if it's 10 digits
        if (strlen($phoneCleaned) === 10) {
            $phoneCleaned = '91' . $phoneCleaned;
        }

        $authkey = config('services.apitxt.authkey');

        \Log::info("Sending OTP via APITXT to {$phoneCleaned}: {$otp}");

        try {
            $response = \Illuminate\Support\Facades\Http::get('https://apitxt.com/api/sendOTP', [
                'authkey' => $authkey,
                'mobile'  => $phoneCleaned,
                'otp'     => $otp,
            ]);

            \Log::info("APITXT Response status: " . $response->status() . " body: " . $response->body());
        } catch (\Exception $e) {
            \Log::error("Failed to send OTP via APITXT: " . $e->getMessage());
        }
    }
}