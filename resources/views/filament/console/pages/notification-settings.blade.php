<x-filament-panels::page>
    <form wire:submit.prevent="save" class="space-y-6">
        
        <!-- Grid layout for the configuration panels -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            
            <!-- CARD 1: First Message Notification -->
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-6 shadow-sm space-y-6">
                <div class="border-b border-gray-100 dark:border-gray-800 pb-4">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 0 .077.014.23.014h.006a3 3 0 0 0 2.22-.99l.012-.015.005-.006c.427-.478.83-.97 1.137-1.506a16.29 16.29 0 0 0 1.258-3.003L7.5 3H6.75A2.25 2.25 0 0 0 4.5 5.25v10.5A2.25 2.25 0 0 0 6.75 18h.618a.75.75 0 0 1 .56.25L9.75 20.5a.75.75 0 0 0 1.25-.56v-1.69a.75.75 0 0 1 .75-.75h1.38a2.25 2.25 0 0 0 2.25-2.25v-.38A2.25 2.25 0 0 0 13.13 12.75H12.75v.003l-.004-.003H7.5Z" />
                        </svg>
                        First Message Notification
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">Sent when a buyer contacts the seller about a listing for the first time.</p>
                </div>

                <div class="space-y-4">
                    <!-- Email Settings -->
                    <div class="bg-gray-50 dark:bg-gray-800/40 p-4 rounded-lg border border-gray-100 dark:border-gray-800/80 space-y-4">
                        <div class="flex items-center justify-between">
                            <label for="first_message_email_enabled" class="text-sm font-semibold text-gray-800 dark:text-gray-200">Email Alerts</label>
                            <input type="checkbox" id="first_message_email_enabled" wire:model.live="first_message_email_enabled" class="w-4 h-4 rounded text-primary-600 focus:ring-primary-500 border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900">
                        </div>
                        
                        @if($first_message_email_enabled)
                            <div class="space-y-3">
                                <div>
                                    <label class="text-xs font-semibold text-gray-600 dark:text-gray-400">Email Subject</label>
                                    <input type="text" wire:model="first_message_email_subject" class="w-full mt-1 px-3 py-2 text-sm border border-gray-300 dark:border-gray-700 rounded bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500">
                                </div>
                                <div>
                                    <label class="text-xs font-semibold text-gray-600 dark:text-gray-400">Email Body</label>
                                    <textarea rows="4" wire:model="first_message_email_body" class="w-full mt-1 px-3 py-2 text-sm border border-gray-300 dark:border-gray-700 rounded bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 font-mono"></textarea>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- WhatsApp Settings -->
                    <div class="bg-gray-50 dark:bg-gray-800/40 p-4 rounded-lg border border-gray-100 dark:border-gray-800/80 space-y-4">
                        <div class="flex items-center justify-between">
                            <label for="first_message_whatsapp_enabled" class="text-sm font-semibold text-gray-800 dark:text-gray-200">WhatsApp Alerts</label>
                            <input type="checkbox" id="first_message_whatsapp_enabled" wire:model.live="first_message_whatsapp_enabled" class="w-4 h-4 rounded text-primary-600 focus:ring-primary-500 border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900">
                        </div>
                        
                        @if($first_message_whatsapp_enabled)
                            <div>
                                <label class="text-xs font-semibold text-gray-600 dark:text-gray-400">WhatsApp Message Body</label>
                                <textarea rows="4" wire:model="first_message_whatsapp_body" class="w-full mt-1 px-3 py-2 text-sm border border-gray-300 dark:border-gray-700 rounded bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 font-mono"></textarea>
                            </div>
                        @endif
                    </div>

                    <!-- Placeholders Info -->
                    <div class="text-xs bg-blue-50 dark:bg-blue-900/20 text-blue-800 dark:text-blue-300 p-3 rounded-lg border border-blue-100 dark:border-blue-900/30">
                        <span class="font-bold">Available Placeholders:</span>
                        <div class="grid grid-cols-2 gap-1 mt-1 font-mono">
                            <div>{buyer_name}</div>
                            <div>{seller_name}</div>
                            <div>{listing_title}</div>
                            <div>{message_text}</div>
                            <div>{chat_url}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD 2: User Inactivity Notification -->
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-6 shadow-sm space-y-6">
                <div class="border-b border-gray-100 dark:border-gray-800 pb-4">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        24-Hour Inactivity Notification
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">Sent when a user has been inactive for 24 hours.</p>
                </div>

                <div class="space-y-4">
                    <!-- Email Settings -->
                    <div class="bg-gray-50 dark:bg-gray-800/40 p-4 rounded-lg border border-gray-100 dark:border-gray-800/80 space-y-4">
                        <div class="flex items-center justify-between">
                            <label for="inactive_email_enabled" class="text-sm font-semibold text-gray-800 dark:text-gray-200">Email Alerts</label>
                            <input type="checkbox" id="inactive_email_enabled" wire:model.live="inactive_email_enabled" class="w-4 h-4 rounded text-primary-600 focus:ring-primary-500 border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900">
                        </div>
                        
                        @if($inactive_email_enabled)
                            <div class="space-y-3">
                                <div>
                                    <label class="text-xs font-semibold text-gray-600 dark:text-gray-400">Email Subject</label>
                                    <input type="text" wire:model="inactive_email_subject" class="w-full mt-1 px-3 py-2 text-sm border border-gray-300 dark:border-gray-700 rounded bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500">
                                </div>
                                <div>
                                    <label class="text-xs font-semibold text-gray-600 dark:text-gray-400">Email Body</label>
                                    <textarea rows="4" wire:model="inactive_email_body" class="w-full mt-1 px-3 py-2 text-sm border border-gray-300 dark:border-gray-700 rounded bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 font-mono"></textarea>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- WhatsApp Settings -->
                    <div class="bg-gray-50 dark:bg-gray-800/40 p-4 rounded-lg border border-gray-100 dark:border-gray-800/80 space-y-4">
                        <div class="flex items-center justify-between">
                            <label for="inactive_whatsapp_enabled" class="text-sm font-semibold text-gray-800 dark:text-gray-200">WhatsApp Alerts</label>
                            <input type="checkbox" id="inactive_whatsapp_enabled" wire:model.live="inactive_whatsapp_enabled" class="w-4 h-4 rounded text-primary-600 focus:ring-primary-500 border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900">
                        </div>
                        
                        @if($inactive_whatsapp_enabled)
                            <div>
                                <label class="text-xs font-semibold text-gray-600 dark:text-gray-400">WhatsApp Message Body</label>
                                <textarea rows="4" wire:model="inactive_whatsapp_body" class="w-full mt-1 px-3 py-2 text-sm border border-gray-300 dark:border-gray-700 rounded bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 font-mono"></textarea>
                            </div>
                        @endif
                    </div>

                    <!-- Placeholders Info -->
                    <div class="text-xs bg-blue-50 dark:bg-blue-900/20 text-blue-800 dark:text-blue-300 p-3 rounded-lg border border-blue-100 dark:border-blue-900/30">
                        <span class="font-bold">Available Placeholders:</span>
                        <div class="grid grid-cols-2 gap-1 mt-1 font-mono">
                            <div>{user_name}</div>
                            <div>{site_url}</div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        <!-- CARD 3: WhatsApp Gateway Integration -->
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-6 shadow-sm space-y-6">
            <div class="border-b border-gray-100 dark:border-gray-800 pb-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025 4.479 4.479 0 0 0-.685-1.9c-1.162-1.96-1.729-4.116-1.729-6.23 0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                    </svg>
                    WhatsApp Gateway Configuration
                </h3>
                <p class="text-sm text-gray-500 mt-1">Configure your third-party WhatsApp sending API gateway.</p>
            </div>

            <div class="space-y-4">
                <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-800/40 p-4 rounded-lg border border-gray-100 dark:border-gray-800/80">
                    <label for="whatsapp_enabled" class="text-sm font-semibold text-gray-800 dark:text-gray-200">Global WhatsApp Service Status</label>
                    <input type="checkbox" id="whatsapp_enabled" wire:model.live="whatsapp_enabled" class="w-4 h-4 rounded text-primary-600 focus:ring-primary-500 border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900">
                </div>

                @if($whatsapp_enabled)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-semibold text-gray-600 dark:text-gray-400">Gateway API URL</label>
                            <input type="text" wire:model="whatsapp_api_url" class="w-full mt-1 px-3 py-2 text-sm border border-gray-300 dark:border-gray-700 rounded bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500">
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-600 dark:text-gray-400">Auth Key / Token / API Key</label>
                            <input type="password" wire:model="whatsapp_auth_key" class="w-full mt-1 px-3 py-2 text-sm border border-gray-300 dark:border-gray-700 rounded bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500">
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-600 dark:text-gray-400">HTTP Request Method</label>
                            <select wire:model="whatsapp_request_method" class="w-full mt-1 px-3 py-2 text-sm border border-gray-300 dark:border-gray-700 rounded bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500">
                                <option value="GET">GET</option>
                                <option value="POST">POST</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-600 dark:text-gray-400">Recipient Phone Parameter Name</label>
                            <input type="text" wire:model="whatsapp_phone_param" placeholder="e.g. mobile, to, phone" class="w-full mt-1 px-3 py-2 text-sm border border-gray-300 dark:border-gray-700 rounded bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500">
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-600 dark:text-gray-400">Message Text Parameter Name</label>
                            <input type="text" wire:model="whatsapp_message_param" placeholder="e.g. message, text, body" class="w-full mt-1 px-3 py-2 text-sm border border-gray-300 dark:border-gray-700 rounded bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500">
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-600 dark:text-gray-400">API Headers (JSON format)</label>
                            <textarea rows="3" wire:model="whatsapp_headers" class="w-full mt-1 px-3 py-2 text-sm border border-gray-300 dark:border-gray-700 rounded bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 font-mono"></textarea>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Form Submit Action -->
        <div class="flex justify-end pt-4">
            <button type="submit" class="px-6 py-2.5 bg-[#1a1532] hover:bg-[#2c2452] text-white text-sm font-semibold rounded-lg shadow transition duration-200">
                Save Notification Settings
            </button>
        </div>

    </form>
</x-filament-panels::page>
