<?php

namespace App\Filament\Console\Pages;

use App\Models\Setting;
use Filament\Pages\Page;
use Filament\Notifications\Notification;

class NotificationSettings extends Page
{
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-bell';

    protected static \UnitEnum|string|null $navigationGroup = 'Settings';

    protected static ?string $navigationLabel = 'Notification Settings';

    protected static ?string $title = 'Notification Settings';

    protected string $view = 'filament.console.pages.notification-settings';

    // Properties for binding
    // First Message Notification settings
    public $first_message_email_enabled;
    public $first_message_email_subject;
    public $first_message_email_body;
    public $first_message_whatsapp_enabled;
    public $first_message_whatsapp_body;

    // Inactive User Notification settings (24 Hours)
    public $inactive_email_enabled;
    public $inactive_email_subject;
    public $inactive_email_body;
    public $inactive_whatsapp_enabled;
    public $inactive_whatsapp_body;

    // WhatsApp Gateway Config
    public $whatsapp_enabled;
    public $whatsapp_api_url;
    public $whatsapp_auth_key;
    public $whatsapp_request_method;
    public $whatsapp_phone_param;
    public $whatsapp_message_param;
    public $whatsapp_headers;

    public function mount()
    {
        $this->first_message_email_enabled = (bool) Setting::get('first_message_email_enabled', false);
        $this->first_message_email_subject = Setting::get('first_message_email_subject', 'New enquiry for your listing: {listing_title}');
        $this->first_message_email_body = Setting::get('first_message_email_body', "Hello {seller_name},\n\nYou received a new message from {buyer_name} for '{listing_title}':\n\n\"{message_text}\"\n\nReply here: {chat_url}");
        $this->first_message_whatsapp_enabled = (bool) Setting::get('first_message_whatsapp_enabled', false);
        $this->first_message_whatsapp_body = Setting::get('first_message_whatsapp_body', "Hello {seller_name}, you have a new message from {buyer_name} for '{listing_title}': \"{message_text}\". Reply: {chat_url}");

        $this->inactive_email_enabled = (bool) Setting::get('inactive_email_enabled', false);
        $this->inactive_email_subject = Setting::get('inactive_email_subject', 'We miss you on AdMandi!');
        $this->inactive_email_body = Setting::get('inactive_email_body', "Hello {user_name},\n\nWe noticed you haven't been active on AdMandi in the last 24 hours. Come back and see what's new!\n\nCheck out latest listings here: {site_url}");
        $this->inactive_whatsapp_enabled = (bool) Setting::get('inactive_whatsapp_enabled', false);
        $this->inactive_whatsapp_body = Setting::get('inactive_whatsapp_body', "Hello {user_name}, we miss you on AdMandi! Check out the latest deals today: {site_url}");

        $this->whatsapp_enabled = (bool) Setting::get('whatsapp_enabled', false);
        $this->whatsapp_api_url = Setting::get('whatsapp_api_url', 'https://apitxt.com/api/sendWhatsApp');
        $this->whatsapp_auth_key = Setting::get('whatsapp_auth_key', '');
        $this->whatsapp_request_method = Setting::get('whatsapp_request_method', 'GET');
        $this->whatsapp_phone_param = Setting::get('whatsapp_phone_param', 'mobile');
        $this->whatsapp_message_param = Setting::get('whatsapp_message_param', 'message');
        $this->whatsapp_headers = Setting::get('whatsapp_headers', "{\n  \"Content-Type\": \"application/json\"\n}");
    }

    public function save()
    {
        Setting::set('first_message_email_enabled', $this->first_message_email_enabled);
        Setting::set('first_message_email_subject', $this->first_message_email_subject);
        Setting::set('first_message_email_body', $this->first_message_email_body);
        Setting::set('first_message_whatsapp_enabled', $this->first_message_whatsapp_enabled);
        Setting::set('first_message_whatsapp_body', $this->first_message_whatsapp_body);

        Setting::set('inactive_email_enabled', $this->inactive_email_enabled);
        Setting::set('inactive_email_subject', $this->inactive_email_subject);
        Setting::set('inactive_email_body', $this->inactive_email_body);
        Setting::set('inactive_whatsapp_enabled', $this->inactive_whatsapp_enabled);
        Setting::set('inactive_whatsapp_body', $this->inactive_whatsapp_body);

        Setting::set('whatsapp_enabled', $this->whatsapp_enabled);
        Setting::set('whatsapp_api_url', $this->whatsapp_api_url);
        Setting::set('whatsapp_auth_key', $this->whatsapp_auth_key);
        Setting::set('whatsapp_request_method', $this->whatsapp_request_method);
        Setting::set('whatsapp_phone_param', $this->whatsapp_phone_param);
        Setting::set('whatsapp_message_param', $this->whatsapp_message_param);
        Setting::set('whatsapp_headers', $this->whatsapp_headers);

        Notification::make()
            ->title('Notification settings saved successfully!')
            ->success()
            ->send();
    }
}
