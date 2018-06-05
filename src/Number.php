<?php

namespace Propaganistas\LaravelIntl;

use CommerceGuys\Intl\Formatter\NumberFormatter;
use CommerceGuys\Intl\NumberFormat\NumberFormatRepository;
use Illuminate\Support\Arr;
use Propaganistas\LaravelIntl\Contracts\Intl;

class Number extends Intl
{
    /**
     * Array of localized number formatters.
     *
     * @var array
     */
    protected $formatters;

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
     * Format a number.
     *
     * @param string|int|float $number
     * @param array $options
     * @return string
     */
    public function format($number, $options = [])
    {
        return $this->formatter()->format($number,
            $this->mergeOptions($options)
        );
    }

    /**
     * Format as percentage.
     *
     * @param string|int|float $number
     * @param array $options
     * @return string
     */
    public function percent($number, $options = [])
    {
        return $this->formatter()->format($number,
            $this->mergeOptions($options, ['style' => 'percent'])
        );
    }

    /**
     * Parse a localized number into native PHP format.
     *
     * @param string|int|float $number
     * @param array $options
     * @return string|false
     */
    public function parse($number, $options = [])
    {
        return $this->formatter()->parse($number,
            $this->mergeOptions($options)
        );
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

        $this->load($locale, $this->getFallbackLocale());

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

        $this->load($this->getLocale(), $locale);

        return $this;
    }

    /**
     * Load the format repository for the given locale.
     *
     * @param string $locale
     * @return void
     */
    protected function load($locale, $fallbackLocale)
    {
        $key = $this->getLocalesKey($locale, $fallbackLocale);

        if (! isset($this->repositories[$key])) {
            $this->formatters[$key] = new NumberFormatter(new NumberFormatRepository($fallbackLocale), ['locale' => $locale]);
        }
    }

    /**
     * Get the formatter's key.
     *
     * @param string|null $locale
     * @param string|null $fallbackLocale
     * @return string
     */
    protected function getLocalesKey($locale = null, $fallbackLocale = null)
    {
        return implode('|', [
            $locale ?: $this->getLocale(),
            $fallbackLocale ?: $this->getFallbackLocale(),
        ]);
    }

    /**
     * The current number formatter.
     *
     * @return \CommerceGuys\Intl\Formatter\NumberFormatter
     */
    protected function formatter()
    {
        return $this->formatters[$this->getLocalesKey()];
    }

    /**
     * Merges the options array.
     *
     * @param array $options
     * @param array $defaults
     * @return array
     */
    protected function mergeOptions(array $options, array $defaults = [])
    {
        Arr::forget($options, 'locale');

        return $defaults + $options;
    }
}