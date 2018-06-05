<?php namespace Propaganistas\LaravelIntl;

use CommerceGuys\Intl\Currency\CurrencyRepository;
use CommerceGuys\Intl\Formatter\CurrencyFormatter;
use CommerceGuys\Intl\NumberFormat\NumberFormatRepository;
use Propaganistas\LaravelIntl\Base\Intl;

class Currency extends Intl
{
    /**
     * @var \CommerceGuys\Intl\Currency\CurrencyRepository
     */
    protected $data;

    /**
     * @var \CommerceGuys\Intl\NumberFormat\NumberFormatRepository
     */
    protected $formatData;

    /**
     * Currency constructor.
     *
     * @param \CommerceGuys\Intl\Currency\CurrencyRepository         $data
     * @param \CommerceGuys\Intl\NumberFormat\NumberFormatRepository $formatData
     */
    public function __construct(CurrencyRepository $data, NumberFormatRepository $formatData)
    {
        $this->data = $data;
        $this->formatData = $formatData;
    }

    /**
     * Get the localized name for the specified currency.
     *
     * @param string $currencyCode
     * @return string
     */
    public function name($currencyCode)
    {
        return $this->get($currencyCode)->getName();
    }

    /**
     * Get the symbol for the specified currency.
     *
     * @param string $currencyCode
     * @return string
     */
    public function symbol($currencyCode)
    {
        return $this->get($currencyCode)->getSymbol();
    }

    /**
     * Format an value for the given currency.
     *
     * @param int|float $value
     * @param string    $currencyCode
     * @return string
     */
    public function format($value, $currencyCode)
    {
        $formatter = new CurrencyFormatter($this->formatData, $this->data);

        return $formatter->format($value, $currencyCode);
    }

    /**
     * Format an value for the given currency in accounting
     * format.
     *
     * @param int|float $value
     * @param string    $currencyCode
     * @return string
     */
    public function formatAccounting($value, $currencyCode)
    {
        $formatter = new CurrencyFormatter($this->formatData, $this->data);

        return $formatter->format($value, $currencyCode, ['style' => 'accounting']);
    }

    /**
     * Parse a localized value into native PHP format.
     *
     * @param string|int|float $value
     * @param string $currencyCode
     * @return string|false
     */
    public function parse($value, $currencyCode)
    {
        $formatter = new CurrencyFormatter($this->formatData, $this->data);

        return $formatter->parse($value, $currencyCode);
    }

    /**
     * Set the default locale.
     *
     * @param $locale
     * @return $this
     */
    public function setLocale($locale)
    {
        parent::setLocale($locale);

        $this->formatData->setDefaultLocale($locale);

        return $this;
    }

    /**
     * Set the desired locale.
     *
     * @param $locale
     * @return $this
     */
    public function setFallbackLocale($locale)
    {
        parent::setFallbackLocale($locale);

        $this->formatData->setFallbackLocale($locale);

        return $this;
    }
}
