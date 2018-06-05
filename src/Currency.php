<?php

namespace Propaganistas\LaravelIntl;

use CommerceGuys\Intl\Formatter\CurrencyFormatter;
use CommerceGuys\Intl\Currency\CurrencyRepository;
use CommerceGuys\Intl\NumberFormat\NumberFormatRepository;
use Illuminate\Support\Arr;
use Propaganistas\LaravelIntl\Contracts\Intl;

class Currency extends Intl
{
    /**
     * Loaded localized currency data.
     *
     * @var array
     */
    protected $data;

    /**
     * Array of localized currency formatters.
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
     * Get a localized record by key.
     *
     * @param string $currencyCode
     * @return string
     */
    public function get($currencyCode)
    {
        return $this->data()->get($currencyCode)->getName();
    }

    /**
     * Alias of get().
     *
     * @param string $currencyCode
     * @return string
     */
    public function name($currencyCode)
    {
        return $this->get($currencyCode);
    }

    /**
     * Get the symbol of the given currency.
     *
     * @param string $currencyCode
     * @return string
     */
    public function symbol($currencyCode)
    {
        return $this->data()->get($currencyCode)->getSymbol();
    }

    /**
     * Format a number.
     *
     * @param string|int|float $number
     * @param string $currencyCode
     * @param array $options
     * @return mixed|string
     */
    public function format($number, $currencyCode, $options = [])
    {
        return $this->formatter()->format($number, $currencyCode,
            $this->mergeOptions($options)
        );
    }

    /**
     * Format a number.
     *
     * @param string|int|float $number
     * @param string $currencyCode
     * @param array $options
     * @return mixed|string
     */
    public function formatAccounting($number, $currencyCode, $options = [])
    {
        return $this->formatter()->format($number, $currencyCode,
            $this->mergeOptions($options, ['style' => 'accounting'])
        );
    }

    /**
     * Parse a localized currency string into a number.
     *
     * @param string $number
     * @param string $currencyCode
     * @param array $options
     * @return mixed|string
     */
    public function parse($number, $currencyCode, $options = [])
    {
        return $this->formatter()->parse($number, $currencyCode,
            $this->mergeOptions($options)
        );
    }

    /**
     * Get all localized records.
     *
     * @return array
     */
    public function all()
    {
        return $this->data()->getList();
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

        if (! isset($this->data[$key])) {
            $this->data[$key] = new CurrencyRepository($locale, $fallbackLocale);
        }

        if (! isset($this->formatters[$key])) {
            $this->formatters[$key] = new CurrencyFormatter(
                new NumberFormatRepository($fallbackLocale),
                $this->data[$key],
                ['locale' => $locale]
            );
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
     * @return \CommerceGuys\Intl\Currency\CurrencyRepository
     */
    protected function data()
    {
        return $this->data[$this->getLocalesKey()];
    }

    /**
     * The current number formatter.
     *
     * @return \CommerceGuys\Intl\Formatter\CurrencyFormatter
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