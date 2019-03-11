<?php namespace Propaganistas\LaravelIntl\Tests;

use Orchestra\Testbench\TestCase;
use Propaganistas\LaravelIntl\Facades\Number;
use Propaganistas\LaravelIntl\IntlServiceProvider;

class TestNumber extends TestCase
{
    /**
     * @param \Illuminate\Foundation\Application $application
     * @return array
     */
    protected function getPackageProviders($application)
    {
        return [IntlServiceProvider::class];
    }

    public function setUp(): void
    {
        require_once __DIR__.'/../src/helpers.php';

        parent::setUp();
    }

    public function testHelper()
    {
        $this->assertEquals('1,234', number(1234));
        $this->assertEquals('Propaganistas\LaravelIntl\Number', get_class(number()));
    }

    public function testHelperIsInSyncWithFacade()
    {
        Number::setLocale('foo');
        $this->assertEquals('foo', number()->getLocale());
    }

    public function testLocaleCanBeChanged()
    {
        $this->app->setLocale('nl');
        $this->assertEquals('1.234', Number::format(1234));

        Number::setLocale('en');
        $this->assertEquals('1,234', Number::format(1234));
    }

    public function testFallbackLocaleIsUsed()
    {
        Number::setLocale('foo');
        Number::setFallbackLocale('fr');
        $number = Number::format(1234);

        $this->assertEquals('1 234', $number);
    }

    public function testLocaleCanBeTemporarilyChanged()
    {
        $this->app->setLocale('nl');
        $number = Number::usingLocale('en', function($country) {
            return Number::format(1234);
        });

        $this->assertEquals('nl', Number::getLocale());
        $this->assertEquals('1,234', $number);
    }

    public function testFormat()
    {
        $number = Number::format(1234);
        $this->assertEquals('1,234', $number);
    }

    public function testPercent()
    {
        $number = Number::percent(0.75);
        $this->assertEquals('75%', $number);
    }

    public function testParse()
    {
        $this->app->setLocale('nl');
        $number = Number::parse('1,2');
        $this->assertEquals(1.2, $number);
    }
}
