<?php

declare(strict_types=1);

namespace Papposilene\Geodata\Tests;

use Illuminate\Support\Facades\DB;
use Orchestra\Testbench\TestCase as Orchestra;
use Papposilene\Geodata\Models\Continent;
use Papposilene\Geodata\Models\Subcontinent;
use Papposilene\Geodata\Models\Country;
use Papposilene\Geodata\Models\City;
use Papposilene\Geodata\Models\Region;
use Papposilene\Geodata\GeodataServiceProvider;

abstract class TestCase extends Orchestra
{
    /** @var \Papposilene\Geodata\Models\Continent */
    protected $testContinent;

    /** @var \Papposilene\Geodata\Models\Subcontinent */
    protected $testSubcontinent;

    /** @var \Papposilene\Geodata\Models\Country */
    protected $testCountry;

    /** @var \Papposilene\Geodata\Models\Region */
    protected $testRegion;

    /** @var \Papposilene\Geodata\Models\City */
    protected $testCity;

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase($this->app);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            GeodataServiceProvider::class,
        ];
    }

    /**
     * Set up the environment.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('geodata.testing', true); //fix sqlite
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            //'database' => 'tmp/tests/testing.sqlite',
            'prefix' => '',
        ]);
    }

    /**
     * Set up the database.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function setUpDatabase($app)
    {
        include_once __DIR__ . '/../database/migrations/create_continents_tables.php.stub';
        include_once __DIR__ . '/../database/migrations/create_countries_tables.php.stub';

        (new \CreateContinentsTables())->up();
        (new \CreateCountriesTables())->up();

        DB::table('geodata__continents')->insert([
            'slug' => 'europe',
            'name' => 'Europe',
        ]);
        $this->testContinent = Continent::find(1);

        DB::table('geodata__subcontinents')->insert([
            'slug' => 'western-europe',
            'name' => 'Western Europe',
            'continent_id' => $this->testContinent,
        ]);
        $this->testSubcontinent = Subcontinent::find(1);

        DB::table('geodata__countries')->insert([
            'continent_id' => $this->testContinent->id,
            'subcontinent_id' => $this->testSubcontinent->id,
            'cca2' => 'FR',
            'cca3' => 'FRA',
            'ccn3' => 250,
            'cioc' => 'FRA',
            'name_eng_common' => 'France',
            'name_eng_formal' => 'French Republic',
            'lat' => 46.63727951049805,
            'lon' => 2.3382623195648193,
            'landlocked' => false,
            'neighbourhood' => json_encode([
                'AND',
                'BEL',
                'DEU',
                'ITA',
                'LUX',
                'MCO',
                'ESP',
                'CHE'
            ], JSON_FORCE_OBJECT),
            'status' => 'officially-assigned',
            'independent' => true,
            'un_member' => true,
            'flag' => '\ud83c\uddeb\ud83c\uddf7',
            'capital' => json_encode(['Paris'], JSON_FORCE_OBJECT),
            'currencies' => json_encode(['EUR'], JSON_FORCE_OBJECT),
            'demonyms' => json_encode([
                'eng' => [
                    'f' => 'French',
                    'm' => 'French',
                ],
                'fra' => [
                    'f' => 'Fran\u00e7aise',
                    'm' => 'Fran\u00e7ais',
                ]
            ], JSON_FORCE_OBJECT),
            'dialling_codes' => json_encode([
                'calling_code' => ['33'],
                'international_prefix' => '00',
                'national_destination_code_lengths' => [1],
                'national_number_lengths' => [9, 10],
                'national_prefix' => '0',
            ], JSON_FORCE_OBJECT),
            'languages' => json_encode(['fra' => 'French']),
            'name_native' => json_encode([
                'fra' => [
                    'common' => 'France',
                    'official' => 'R\u00e9publique fran\u00e7aise'
                ]
            ], JSON_FORCE_OBJECT),
            'name_translations' => json_encode([
                'ces' => [
                    'common' => 'Francie',
                    'official' => 'Francouzsk\u00e1 republika',
                ],
                'deu' => [
                    'common' => 'Frankreich',
                    'official' => 'Franz\u00f6sische Republik',
                ],
                'est' => [
                    'common' => 'Prantsusmaa',
                    'official' => 'Prantsuse Vabariik',
                ],
                'fin' => [
                    'common' => 'Ranska',
                    'official' => 'Ranskan tasavalta',
                ],
                'fra' => [
                    'common' => 'France',
                    'official' => 'R\u00e9publique fran\u00e7aise',
                ],
                'hrv' => [
                    'common' => 'Francuska',
                    'official' => 'Francuska Republika',
                ],
                'hun' => [
                    'common' => 'Franciaorsz\u00e1g',
                    'official' => 'Francia K\u00f6zt\u00e1rsas\u00e1g',
                ],
                'ita' => [
                    'common' => 'Francia',
                    'official' => 'Repubblica francese',
                ],
                'jpn' => [
                    'common' => '\u30d5\u30e9\u30f3\u30b9',
                    'official' => '\u30d5\u30e9\u30f3\u30b9\u5171\u548c\u56fd',
                ],
                'kor' => [
                    'common' => '\ud504\ub791\uc2a4',
                    'official' => '\ud504\ub791\uc2a4 \uacf5\ud654\uad6d',
                ],
                'nld' => [
                    'common' => 'Frankrijk',
                    'official' => 'Franse Republiek',
                ],
                'per' => [
                    'common' => '\u0641\u0631\u0627\u0646\u0633\u0647',
                    'official' => '\u062c\u0645\u0647\u0648\u0631\u06cc \u0641\u0631\u0627\u0646\u0633\u0647',
                ],
                'pol' => [
                    'common' => 'Francja',
                    'official' => 'Republika Francuska',
                ],
                'por' => [
                    'common' => 'Fran\u00e7a',
                    'official' => 'Rep\u00fablica Francesa',
                ],
                'rus' => [
                    'common' => '\u0424\u0440\u0430\u043d\u0446\u0438\u044f',
                    'official' => '\u0424\u0440\u0430\u043d\u0446\u0443\u0437\u0441\u043a\u0430\u044f \u0420\u0435\u0441\u043f\u0443\u0431\u043b\u0438\u043a\u0430',
                ],
                'slk' => [
                    'common' => 'Franc\u00fazsko',
                    'official' => 'Franc\u00fazska republika',
                ],
                'spa' => [
                    'common' => 'Francia',
                    'official' => 'Rep\u00fablica franc\u00e9s',
                ],
                'swe' => [
                    'common' => 'Frankrike',
                    'official' => 'Republiken Frankrike',
                ],
                'urd' => [
                    'common' => '\u0641\u0631\u0627\u0646\u0633',
                    'official' => '\u062c\u0645\u06c1\u0648\u0631\u06cc\u06c1 \u0641\u0631\u0627\u0646\u0633',
                ],
                'zho' => [
                    'common' => '\u6cd5\u56fd',
                    'official' => '\u6cd5\u5170\u897f\u5171\u548c\u56fd',
                ]
            ], JSON_FORCE_OBJECT),
            'extra' => json_encode([
                'wikidata' => 'Q142',
                'woe_id_eh' => 23424819,
            ], JSON_FORCE_OBJECT),
        ]);
        $this->testCountry = Country::find(1);

        DB::table('geodata__regions')->insert([
            'country_cca2' => $this->testCountry->cca2,
            'country_cca3' => $this->testCountry->cca3,
            'region_cca2' => 'FR-IDF',
            'osm_id' => -8649,
            'admin_level' => 4,
            'boundary' => 'administrative',
            'name_loc' => 'Île-de-France',
            'name_eng' => 'Ile-de-France',
            'name_translations' => json_encode([
                'en' => 'Île-de-France',
                'fr' => 'Ile-de-France',
                'es' => 'Isla de Francia',
                'it' => 'Isola di Francia',
            ], JSON_FORCE_OBJECT),
            'extra' => json_encode([
                'wikidata' => 'Q13917',
            ], JSON_FORCE_OBJECT),
        ]);
        $this->testRegion = Region::find(1);

        DB::table('geodata__cities')->insert([
            'country_cca3' => $this->testCountry->cca3,
            'region_uuid' => $this->testRegion->uuid,
            'osm_id' => 20727,
            'osm_admin_level' => 9,
            'osm_type' => 'administrative',
            'state' => '\u00c3\u008ele-de-France',
            'name' => 'Paris',
            'lat' => 48.86669293120,
            'lon' => 2.33333532574,
            'postcodes' => json_encode([
                75000, 75001, 75002, 75003, 75004, 75005, 75006,
                75007, 75008, 75009, 75010, 75011, 75012, 75013,
                75014, 75015, 75016, 75116, 75017, 75018, 75019,
                75020,
            ], JSON_FORCE_OBJECT),
            'extra' => json_encode([
                'ne_id' => 1159151613,
                'wikidata' => 'Q90',
                'wof_id' => 101751119,
            ]),
        ]);
        $this->testCity = City::find(1);

    }
}
