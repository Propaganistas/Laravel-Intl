<?php

namespace Propaganistas\LaravelIntl;

use Jenssegers\Date\Date as BaseDate;
use Propaganistas\LaravelIntl\Contracts\Intl;

class Date extends Intl
{
    /**
     * Handle dynamic calls to the object.
     *
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        return BaseDate::{$method}(...$arguments);
    }

    /**
     * Get the current locale.
     *
     * @return string
     */
    public function getLocale()
    {
        return BaseDate::getLocale();
    }

    /**
     * Set the current locale.
     *
     * @param $locale
     * @return $this
     */
    public function setLocale($locale)
    {
        BaseDate::setLocale($locale);

        return $this;
    }

    /**
     * Get the fallback locale.
     *
     * @return string
     */
    public function getFallbackLocale()
    {
        return BaseDate::getFallbackLocale();
    }

    /**
     * Set the fallback locale.
     *
     * @param $locale
     * @return $this
     */
    public function setFallbackLocale($locale)
    {
        BaseDate::setFallbackLocale($locale);

        return $this;
    }
}