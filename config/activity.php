<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Log Listing Views
    |--------------------------------------------------------------------------
    |
    | When set to true, each view on a listing is stored in the database.
    | Set to false to disable database logging for listing views.
    |
    */
    'log_listing_views' => env('LOG_LISTING_VIEWS', true),

    /*
    |--------------------------------------------------------------------------
    | Log User Activities
    |--------------------------------------------------------------------------
    |
    | When set to true, user activity logs (e.g. login, logout, listing creations,
    | profile updates) will be stored in the database.
    | Set to false to disable database logging for user activities.
    |
    */
    'log_user_activities' => env('LOG_USER_ACTIVITIES', true),

];
