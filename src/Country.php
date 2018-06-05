<?php namespace Propaganistas\LaravelIntl;

use CommerceGuys\Addressing\Country\CountryRepository;
use Propaganistas\LaravelIntl\Base\Intl;

class Country extends Intl
{
    /**
     * @var \CommerceGuys\Addressing\Country\CountryRepository
     */
    protected $data;

    /**
     * Country constructor.
     *
     * @param \CommerceGuys\Addressing\Country\CountryRepository $data
     */
    public function __construct(CountryRepository $data)
    {
        $this->data = $data;
    }

    /**
     * Get the localized name for the specified country.
     *
     * @param string $countryCode
     * @return string
     */
    public function name($countryCode)
    {
        return $this->get($countryCode)->getName();
    }

    /**
     * Get the currency code for the specified country.
     *
     * @param string $countryCode
     * @return string
     */
    public function currency($countryCode)
    {
        return $this->get($countryCode)->getCurrencyCode();
    }
}
