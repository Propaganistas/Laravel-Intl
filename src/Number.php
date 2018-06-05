<?php namespace Propaganistas\LaravelIntl;

use CommerceGuys\Intl\Formatter\NumberFormatter;
use CommerceGuys\Intl\NumberFormat\NumberFormat;
use CommerceGuys\Intl\NumberFormat\NumberFormatRepository;
use Propaganistas\LaravelIntl\Base\Intl;
use ReflectionClass;

class Number extends Intl
{
    /**
     * @var \CommerceGuys\Intl\NumberFormat\NumberFormatRepository
     */
    protected $data;

    /**
     * Number constructor.
     *
     * @param \CommerceGuys\Intl\NumberFormat\NumberFormatRepository $data
     */
    public function __construct(NumberFormatRepository $data)
    {
        $this->data = $data;
    }

    /**
     * Format an value in the given locale (or app locale if not specified).
     *
     * @param string|int|float $value
     * @return string
     */
    public function format($value)
    {
        $format = $this->get();
        $formatter = new NumberFormatter($format);

        return $formatter->format($value);
    }

    /**
     * Format an value as percents in the given locale (or app locale if not specified).
     *
     * @param string|int|float $value
     * @return string
     */
    public function percent($value)
    {
        $format = $this->get();
        $formatter = new NumberFormatter($format, NumberFormatter::PERCENT);

        return $formatter->format($value);
    }

    /**
     * Parse a localized number into native PHP format.
     *
     * @param string|int|float $value
     * @return string|false
     */
    public function parse($value)
    {
        $format = $this->get(null);
        $formatter = new NumberFormatter($format);

        // At time of writing, commerceguys/intl has number parsing still coupled to a currency. Parsing does
        // succeed however,even though a value is provided without any currency. So let's just pass in
        // a very rare currency to avoid unwanted formatting behavior. Sorry Cape Verdean Escudo!
        return $formatter->parseCurrency($value, $currency = currency()->get('CVE'));
    }

    /**
     * Get a localized entry.
     *
     * @param string|null $code
     * @return mixed
     */
    public function get($code = null)
    {
        return $this->data->get(null);
    }

    /**
     * Get a localized list of entries, keyed by their code.
     *
     * @return array
     */
    public function all()
    {
        // Unsupported.
        return [];
    }
}
