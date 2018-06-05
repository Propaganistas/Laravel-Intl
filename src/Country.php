<?php

namespace Propaganistas\LaravelIntl;

use Illuminate\Support\Arr;
use Propaganistas\LaravelIntl\Contracts\Intl;

class Country extends Intl
{
    /**
     * Loaded localized country data.
     *
     * @var array
     */
    protected $data;

    /**
     * The current locale.
     *
     * @var string $locale
     */
    protected $locale;

    /**
     * The current locale.
     *
     * @var string $locale
     */
    protected $fallbackLocale;

    /**
     * Get a localized record by key.
     *
     * @param string $key
     * @return string
     */
    public function get($key)
    {
        return Arr::get($this->all(), $key);
    }

    /**
     * Alias of get().
     *
     * @param string $key
     * @return string
     */
    public function name($key)
    {
        return $this->get($key);
    }

    /**
     * Get all localized records.
     *
     * @return array
     */
    public function all()
    {
        return $this->data[$this->getLocale()] + $this->data[$this->getFallbackLocale()];
    }

    /**
     * Get the current locale.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set the current locale.
     *
     * @param $locale
     * @return $this
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        $this->load($locale);

        return $this;
    }

    /**
     * Get the fallback locale.
     *
     * @return string
     */
    public function getFallbackLocale()
    {
        return $this->fallbackLocale;
    }

    /**
     * Set the fallback locale.
     *
     * @param $locale
     * @return $this
     */
    public function setFallbackLocale($locale)
    {
        $this->fallbackLocale = $locale;

        $this->load($locale);

        return $this;
    }

    /**
     * Load the data for the given locale.
     *
     * @param string $locale
     * @return void
     */
    protected function load($locale)
    {
        if (! isset($this->data[$locale])) {
            $path = base_path('vendor/umpirsky/country-list/data/'.$locale.'/country.php');

            $this->data[$locale] = is_file($path) ? require $path : [];
        }
    }
}