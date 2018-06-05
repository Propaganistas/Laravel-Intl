<?php namespace Propaganistas\LaravelIntl\Tests;

use Orchestra\Testbench\TestCase;
use Propaganistas\LaravelIntl\Facades\Language;
use Propaganistas\LaravelIntl\IntlServiceProvider;

class TestLanguage extends TestCase
{
    /**
     * @param \Illuminate\Foundation\Application $application
     * @return array
     */
    protected function getPackageProviders($application)
    {
        return [IntlServiceProvider::class];
    }

    public function setUp()
    {
        require_once __DIR__.'/../src/helpers.php';

        parent::setUp();
    }

    protected function getEnvironmentSetUp($app)
    {
        $app->setBasePath(__DIR__ . '/..');
    }

    public function testHelper()
    {
        $this->assertEquals('Dutch', language('nl'));
        $this->assertEquals('Propaganistas\LaravelIntl\Language', get_class(language()));
    }

    public function testHelperIsInSyncWithFacade()
    {
        Language::setLocale('foo');
        $this->assertEquals('foo', language()->getLocale());
    }

    public function testLocaleCanBeChanged()
    {
        $this->app->setLocale('nl');
        $this->assertEquals('Nederlands', Language::name('nl'));

        Language::setLocale('en');
        $this->assertEquals('Dutch', Language::name('nl'));
    }

    public function testFallbackLocaleIsUsed()
    {
        Language::setLocale('foo');
        Language::setFallbackLocale('fr');
        $this->assertEquals('néerlandais', Language::name('nl'));
    }

    public function testLocaleCanBeTemporarilyChanged()
    {
        $this->app->setLocale('nl');
        $name = Language::usingLocale('en', function($language) {
            return Language::name('nl');
        });

        $this->assertEquals('nl', Language::getLocale());
        $this->assertEquals('Dutch', $name);
    }

    public function testGet()
    {
        $language = Language::get('nl');
        $this->assertEquals('Dutch', $language);
    }

    public function testAll()
    {
        $languages = Language::all();
        $this->assertArraySubset(['nl' => 'Dutch', 'fr' => 'French'], $languages);

        $languages = Language::setLocale('nl')->all();
        $this->assertArraySubset(['nl' => 'Nederlands', 'fr' => 'Frans'], $languages);
    }

    public function testName()
    {
        $language = Language::name('nl');
        $this->assertEquals('Dutch', $language);
    }
}
