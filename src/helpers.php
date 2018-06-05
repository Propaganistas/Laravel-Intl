<?php

if (!function_exists('country')) {
    /**
     * Get a localized country name.
     *
     * @param string|null $countryCode
     * @return \CommerceGuys\Addressing\Country\Country|string
     */
    function country($countryCode = null)
    {
        if (is_null($countryCode)) {
            return app('intl.country');
        }

        return app('intl.country')->name($countryCode);
    }
}

if (!function_exists('currency')) {
    /**
     * Get a localized currency or currency amount.
     *
     * @return \CommerceGuys\Intl\Currency\Currency|string
     */
    function currency()
    {
        $arguments = func_get_args();

        if (count($arguments) === 0) {
            return app('intl.currency');
        }

        if (count($arguments) > 0 && is_numeric($arguments[0])) {
            return call_user_func_array([app('intl.currency'), 'format'], $arguments);
        }

        return call_user_func_array([app('intl.currency'), 'name'], $arguments);
    }
}

if (!function_exists('carbon')) {
    /**
     * Get a localized Carbon instance.
     *
     * @param  string              $time
     * @param  string|DateTimeZone $timezone
     * @return \Jenssegers\Date\Date|string
     */
    function carbon($time = null, $timezone = null)
    {
        return app('intl.date')->make($time, $timezone);
    }
}

if (!function_exists('language')) {
    /**
     * Get a localized language name.
     *
     * @param string|null $langCode
     * @return \CommerceGuys\Intl\Language\Language|string
     */
    function language($langCode = null)
    {
        if (is_null($langCode)) {
            return app('intl.language');
        }

        return app('intl.language')->name($langCode);
    }
}

if (!function_exists('number')) {
    /**
     * Get a localized value.
     *
     * @param int|float|string|null $amount
     * @return \CommerceGuys\Intl\NumberFormat\NumberFormat|string
     */
    function number($amount = null)
    {
        if (is_null($amount)) {
            return app('intl.number');
        }

        if (!is_numeric($amount)) {
            return app('intl.number')->get($amount);
        }

        return app('intl.number')->format($amount);
    }
}
