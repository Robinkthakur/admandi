<?php

return [
    'free_limit' => (int) env('FREE_AD_LIMIT_PER_CATEGORY', 5),
    'verified_limit' => (int) env('VERIFIED_AD_LIMIT_PER_CATEGORY', 25),
];
