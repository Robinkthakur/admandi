<?php

if (!function_exists('format_inr')) {

    function price($amount)
    {
        $amount = (int) round($amount);

        return '₹' . number_format_indian($amount);
    }
}

if (!function_exists('number_format_indian')) {

    function number_format_indian($number)
    {
        $number = (string) $number;

        $lastThree = substr($number, -3);

        $restUnits = substr($number, 0, -3);

        if ($restUnits != '') {

            $restUnits = preg_replace(
                "/\B(?=(\d{2})+(?!\d))/",
                ",",
                $restUnits
            );

            return $restUnits . "," . $lastThree;
        }

        return $lastThree;
    }
}