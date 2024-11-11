<?php

if (!function_exists('getBaseUrl')) {
    function getBaseUrl()
    {
        $base_url = '';
        if (env('APP_ENV') == 'local') {
            $base_url = asset('assets/');
        } elseif (env('APP_ENV') == 'production') {
            $base_url = asset('public/assets/');
        }
        return $base_url;
    }
}