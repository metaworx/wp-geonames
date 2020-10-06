<?php

namespace WPGeonames\Entities;

use ErrorException;
use WPGeonames\Core;
use WPGeonames\Helpers\FlexibleObjectTrait;

/**
 * Class Country
 *
 * @property string $iso2      Country Code as ISO2
 * @property string $iso3      Country Code as ISO3
 * @property int    $isoN      Country ID as ISO
 * @property string $capital
 * @property string $tld
 * @property string $currencyCode
 * @property string $currencyName
 * @property string $phone
 * @property string $postalCodeFormat
 * @property string $postalCodeRegex
 * @property string $languages
 * @property int    $area
 * @property string $neighbours
 * @property string $fipsCode
 */
class Country
    extends
    Location
{

    use FlexibleObjectTrait
    {
        FlexibleObjectTrait::__construct as private _FlexibleObjectTrait__construct;
    }

// protected properties

    /**
     * Is required here to separate it from the parent class
     *
     * @var string[]
     */
    protected static $_aliases;

    /**
     * @var \WPGeonames\Entities\Country[]
     */
    protected static $_countries = [];

    /**
     * @var integer GeonameId of the wp_geonames_countries table
     */
    protected $_idCountry;

    /**
     * @var integer GeonameId of the wp_geonames_locations_cache table
     */
    protected $_idLocation;

    /**
     * @var string
     */
    protected $iso2;

    /**
     * @var string
     */
    protected $iso3;

    /**
     * @var int
     */
    protected $isoN;

    /**
     * @var string|null
     */
    protected $fipsCode;

    /**
     * @var string
     */
    protected $capital;

    /**
     * @var int|null (in sq km)
     */
    protected $area;

    /**
     * @var string|null
     */
    protected $tld;

    /**
     * @var string|null
     */
    protected $currencyCode;

    /**
     * @var string|null
     */
    protected $currencyName;

    /**
     * @var string|null
     */
    protected $phone;

    /**
     * @var string|null
     */
    protected $postalCodeFormat;

    /**
     * @var string|null
     */
    protected $postalCodeRegex;

    /**
     * @var string|null
     */
    protected $languages;

    /**
     * @var string|null
     */
    protected $neighbours;

    /**
     * @var string|null
     */
    protected $country;


    /**
     * Country constructor is required to avoid jumping directly to FlexibleObjectTrait::__construct
     *
     * @param         $values
     * @param  array  $defaults
     *
     * @throws \ErrorException
     */
    public function __construct(
        $values,
        $defaults = []
    ) {

        parent::__construct( $values, $defaults );
    }


    /**
     * @return string[]
     */
    protected function getAliases(): array
    {

        static $_aliases
            = [
            'id'                   => 'geonameId',
            'country_id'           => 'geonameId',
            'countryName'          => 'country',
            'currency_code'        => 'currencyCode',
            'currencyCode'         => 'currencyCode',
            'country_code'         => 'iso2',
            'countryCode'          => 'iso2',
            'isoAlpha3'            => 'iso3',
            'isoNumeric'           => 'isoN',
            'areaInSqKm'           => 'area',
            'currency_name'        => 'currencyName',
            'postal_code_format'   => 'postalCodeFormat',
            'postal_code_regex'    => 'postalCodeRegex',
            'fips'                 => 'fipsCode',
            'equivalentFipsCode'   => 'fipsCode',
            'equivalent_fips_code' => 'fipsCode',
        ];

        /** @noinspection AdditionOperationOnArraysInspection */
        return $_aliases + parent::getAliases();
    }


    /**
     * @return int
     */
    public function getArea(): int
    {

        return $this->area;
    }


    /**
     * @param  int  $area
     *
     * @return Country
     */
    public function setArea( int $area ): Country
    {

        $this->area = $area;

        return $this;
    }


    /**
     * @return string
     */
    public function getCapital(): string
    {

        return $this->capital;
    }


    /**
     * @param  string  $capital
     *
     * @return Country
     */
    public function setCapital( string $capital ): Country
    {

        $this->capital = $capital;

        return $this;
    }


    public function getCountryCode(
        ?string $format = 'iso2',
        bool $autoload = true
    ): ?string {

        return $this->__get( $format );
    }


    public function getCountryId( bool $autoload = true ): ?int
    {

        return $this->getGeonameId();
    }


    /**
     * @return string
     */
    public function getCurrencyCode(): string
    {

        return $this->currencyCode;
    }


    /**
     * @param  string  $currencyCode
     *
     * @return Country
     */
    public function setCurrencyCode( string $currencyCode ): Country
    {

        $this->currencyCode = $currencyCode;

        return $this;
    }


    /**
     * @return string
     */
    public function getCurrencyName(): string
    {

        return $this->currencyName;
    }


    /**
     * @param  string  $currencyName
     *
     * @return Country
     */
    public function setCurrencyName( string $currencyName ): Country
    {

        $this->currencyName = $currencyName;

        return $this;
    }


    /**
     * @return string
     */
    public function getFipsCode(): string
    {

        return $this->fipsCode;
    }


    /**
     * @param  string  $fipsCode
     *
     * @return Country
     */
    public function setFipsCode( string $fipsCode ): Country
    {

        $this->fipsCode = $fipsCode;

        return $this;
    }


    /**
     * @return string
     */
    public function getIso2(): string
    {

        return $this->iso2;
    }


    /**
     * @param  string  $iso2
     *
     * @return Country
     * @throws \ErrorException
     */
    public function setIso2( string $iso2 ): Country
    {

        // ignore if they're the same
        if ( $this->iso2 === $iso2 )
        {
            return $this;
        }

        // fail, if already set
        if ( ! empty( $this->iso2 ) )
        {
            throw new ErrorException(
                sprintf( 'ISO2 country code of an object cannot be changed. Old: %s, New: %s', $this->iso2, $iso2 )
            );
        }

        // fail, if already set
        if ( array_key_exists( $iso2, static::$_countries ) )
        {
            throw new ErrorException(
                sprintf( 'An instance with this country code already exists. Id: %s', $iso2 )
            );
        }

        $this->iso2 = $iso2;

        static::$_countries[ $iso2 ] = $this;

        return $this;
    }


    /**
     * @return string
     */
    public function getIso3(): string
    {

        return $this->iso3;
    }


    /**
     * @param  string  $iso3
     *
     * @return Country
     */
    public function setIso3( string $iso3 ): Country
    {

        $this->iso3 = $iso3;

        return $this;
    }


    /**
     * @return int
     */
    public function getIsoN(): int
    {

        return $this->isoN;
    }


    /**
     * @param  int  $isoN
     *
     * @return Country
     */
    public function setIsoN( int $isoN ): Country
    {

        $this->isoN = $isoN;

        return $this;
    }


    /**
     * @return string
     */
    public function getLanguages(): string
    {

        return $this->languages;
    }


    /**
     * @param  string  $languages
     *
     * @return Country
     */
    public function setLanguages( string $languages ): Country
    {

        $this->languages = $languages;

        return $this;
    }


    /**
     * @return string
     */
    public function getNeighbours(): ?string
    {

        return $this->neighbours;
    }


    /**
     * @param  string  $neighbours
     *
     * @return Country
     */
    public function setNeighbours( string $neighbours ): Country
    {

        $this->neighbours = $neighbours;

        return $this;
    }


    /**
     * @return string
     */
    public function getPhone(): string
    {

        return $this->phone;
    }


    /**
     * @param  string  $phone
     *
     * @return Country
     */
    public function setPhone( string $phone ): Country
    {

        $this->phone = $phone;

        return $this;
    }


    /**
     * @return string
     */
    public function getPostalCodeFormat(): ?string
    {

        return $this->postalCodeFormat
            ?: null;
    }


    /**
     * @param  string  $postalCodeFormat
     *
     * @return Country
     */
    public function setPostalCodeFormat( ?string $postalCodeFormat ): Country
    {

        $this->postalCodeFormat = $postalCodeFormat;

        return $this;
    }


    /**
     * @return string
     */
    public function getPostalCodeRegex(): ?string
    {

        return $this->postalCodeRegex
            ?: null;
    }


    /**
     * @param  string  $postalCodeRegex
     *
     * @return Country
     */
    public function setPostalCodeRegex( ?string $postalCodeRegex ): Country
    {

        $this->postalCodeRegex = $postalCodeRegex;

        return $this;
    }


    /**
     * @return string
     */
    public function getTld(): string
    {

        return $this->tld;
    }


    /**
     * @param  string  $tld
     *
     * @return Country
     */
    public function setTld( string $tld ): self
    {

        $this->tld = $tld;

        return $this;
    }


    public function setCountryCode( $countryCode ): Location
    {

        return $this->setIso2( $countryCode );
    }


    public function setCountryId( ?int $countryId ): Location
    {

        return $this->setGeonameId( $countryId );
    }


    /**
     * @param  int  $geonameId
     *
     * @return $this|\WPGeonames\Entities\Location
     * @throws \ErrorException
     */
    public function setGeonameId( int $geonameId ): Location
    {

        // ignore if they're the same
        if ( $this->geonameId === $geonameId )
        {
            return $this;
        }

        // fail, if already set
        if ( ( $this->geonameId ?? 0 ) > 0 )
        {
            throw new ErrorException(
                sprintf( 'GeonameId of an object cannot be changed. Old: %d, New: %d', $this->geonameId, $geonameId )
            );
        }

        // fail, if already set
        if ( array_key_exists( "_$geonameId", static::$_countries ) )
        {
            throw new ErrorException(
                sprintf( 'An instance of GeonameId already exists. Id: %d', $geonameId )
            );
        }

        parent::setGeonameId( $geonameId );

        static::$_countries["_$geonameId"] = $this;

        return $this;

    }


    /**
     * @param  int  $idAPI
     *
     * @return Country
     */
    public function setIdAPI( int $idAPI ): self
    {

        $this->_idAPI = $idAPI;

        return $this;
    }


    /**
     * @param  int  $cId
     *
     * @return Country
     */
    protected function setIdCountry( int $cId ): Country
    {

        $this->setGeonameId( $cId );
        $this->_idCountry = $cId;

        return $this;
    }


    /**
     * @param  int  $lId
     *
     * @return Country
     */
    protected function setIdLocation( int $lId ): Country
    {

        $this->setGeonameId( $lId );

        $this->_idLocation = $lId;

        return $this;
    }


    public function save(): void
    {

        // load location if it has not been loaded nor from the database nor the API
        if ( $this->_idLocation === null && $this->_idAPI === null )
        {
            // load location

            $item = Core::getGeoNameClient()
                        ->get(
                            [
                                'geonameId' => $this->geonameId,
                                'style'     => 'full',
                            ]
                        )
            ;

            $this->loadValues( $item );
        }

        // load country
        if ( $this->_idCountry === null && $this->iso2 !== null )
        {
            // load country

            $item = Core::getGeoNameClient()
                        ->countryInfo(
                            [
                                'country' => $this->iso2,
                            ]
                        )
            ;

            $this->loadValues( $item );
        }

        // save country info

        $sql = Core::$wpdb->prepareAndReplaceTablePrefix(
            <<<SQL
INSERT INTO
    `wp_geonames_countries`
(
      `geoname_id`
    , `iso2`
    , `iso3`
    , `isoN`
    , `fips`
    , `country`
    , `capital`
    , `languages`
    , `continent`
    , `neighbours`
    , `area`
    , `population`
    , `tld`
    , `currency_code`
    , `currency_name`
    , `phone`
    , `postal_code_format`
    , `postal_code_regex`
)
VALUES
(
      %d -- `geoname_id`
    , %s -- `iso2`
    , %s -- `iso3`
    , %d -- `isoN`
    , %s -- `fips`
    , %s -- `country`
    , %s -- `capital`
    , %s -- `languages`
    , %s -- `continent`
    , %s -- `neighbours`
    , %d -- `area`
    , %d -- `population`
    , %s -- `tld`
    , %s -- `currency_code`
    , %s -- `currency_name`
    , %d -- `phone`
    , %s -- `postal_code_format`
    , %s -- `postal_code_regex`
)

ON DUPLICATE KEY UPDATE 
      `db_update`                   = CURRENT_TIMESTAMP
    , `iso2`                        = COALESCE(NULLIF(%s, ''), `iso2`                )
    , `iso3`                        = COALESCE(NULLIF(%s, ''), `iso3`                )
    , `isoN`                        = COALESCE(NULLIF(%s, 0 ), `isoN`                )
    , `fips`                        = COALESCE(NULLIF(%s, ''), `fips`                )
    , `country`                     = COALESCE(NULLIF(%s, ''), `country`             )
    , `capital`                     = COALESCE(NULLIF(%s, ''), `capital`             )
    , `languages`                   = COALESCE(NULLIF(%s, ''), `languages`           )
    , `continent`                   = COALESCE(NULLIF(%s, ''), `continent`           )
    , `neighbours`                  = COALESCE(NULLIF(%s, ''), `neighbours`          )
    , `area`                        = COALESCE(NULLIF(%s, 0 ), `area`                )
    , `population`                  = COALESCE(NULLIF(%s, 0 ), `population`          )
    , `tld`                         = COALESCE(NULLIF(%s, ''), `tld`                 )
    , `currency_code`               = COALESCE(NULLIF(%s, ''), `currency_code`       )
    , `currency_name`               = COALESCE(NULLIF(%s, ''), `currency_name`       )
    , `phone`                       = COALESCE(NULLIF(%s, 0 ), `phone`               )
    , `postal_code_format`          = COALESCE(NULLIF(%s, ''), `postal_code_format`  )
    , `postal_code_regex`           = COALESCE(NULLIF(%s, ''), `postal_code_regex`   )
    
SQL,
            // insert
            $this->getGeonameId(),
            $this->getIso2(),
            $this->getIso3(),
            $this->getIsoN(),
            $this->getFipsCode(),
            $this->getAsciiName(),
            $this->getCapital(),
            $this->getLanguages(),
            $this->getContinentCode(),
            $this->getNeighbours(),
            $this->getArea(),
            $this->getPopulation(),
            $this->getTld(),
            $this->getCurrencyCode(),
            $this->getCurrencyName(),
            $this->getPhone(),
            $this->getPostalCodeFormat(),
            $this->getPostalCodeRegex(),
            // update
            $this->getIso2(),
            $this->getIso3(),
            $this->getIsoN(),
            $this->getFipsCode(),
            $this->getAsciiName(),
            $this->getCapital(),
            $this->getLanguages(),
            $this->getContinentCode(),
            $this->getNeighbours(),
            $this->getArea(),
            $this->getPopulation(),
            $this->getTld(),
            $this->getCurrencyCode(),
            $this->getCurrencyName(),
            $this->getPhone(),
            $this->getPostalCodeFormat(),
            $this->getPostalCodeRegex(),

        );

        if ( Core::$wpdb->query( $sql ) === false )
        {
            throw new ErrorException( Core::$wpdb->last_error );
        }

        parent::save();
    }


    /**
     * @param  string|int|string[]|int[]|\WPGeonames\Entities\Location|\WPGeonames\Entities\Location[]  $ids
     *
     * @return static
     * @throws \ErrorException
     */
    public static function loadRecords( $ids ): ?array
    {

        $ids = is_object( $ids )
            ? [ $ids ]
            : (array) $ids;

        array_walk(
            $ids,
            static function ( &$id )
            {

                if ( $id instanceof Country )
                {

                    $id = $id = [ 'o' => $id ];

                    return;
                }

                if ( $id instanceof Location )
                {
                    if ( $id->getGeonameId() > 0 )
                    {
                        $id = $id->getGeonameId();
                    }
                    elseif ( $id->getCountryCode( 'iso2', false ) !== null )
                    {
                        $id = $id->getCountryCode();
                    }

                    /** @noinspection ForgottenDebugOutputInspection */
                    error_log( 'Received invalid Location object while loading a country object', E_USER_WARNING );

                    $id = null;

                    return;
                }

                if ( is_object( $id ) )
                {

                    if ( ( ( property_exists( $id, 'geonameId' ) && ( $_id = $id->geonameId ) )
                            || ( property_exists( $id, 'geoname_id' ) && ( $_id = $id->geoname_id ) )
                        )
                        && array_key_exists( "_$_id", static::$_countries ) )
                    {
                        $o = static::$_countries["_$_id"];

                        $o->loadValues( $id );

                        $id = [ 'o' => $o ];

                        return;
                    }

                    /** @noinspection ForgottenDebugOutputInspection */
                    error_log( 'Received invalid Location object while loading a country object', E_USER_WARNING );

                    $id = null;

                    return;
                }

                if ( is_numeric( $id ) )
                {
                    if ( array_key_exists( "_$id", static::$_countries ) )
                    {
                        $id = [ 'o' => static::$_countries["_$id"] ];

                        return;
                    }

                    $id = [
                        'i'          => $id,
                        'geoname_id' => (int) $id,
                    ];

                    return;
                }

                if ( is_string( $id ) )
                {

                    if ( array_key_exists( $id, static::$_countries ) )
                    {
                        $id = [ 'o' => static::$_countries[ $id ] ];

                        return;
                    }

                    $id = [
                        's'    => $id,
                        'iso2' => Core::$wpdb->prepare( "%s", $id ),
                    ];

                    return;
                }

                /** @noinspection ForgottenDebugOutputInspection */
                error_log( 'Received invalid input while loading a country object', E_USER_WARNING );

                $id = null;
            }
        );

        $sqlGeonameIds = implode( ',', array_filter( array_column( $ids, 'geoname_id' ) ) );
        $sqlGeonameIds = $sqlGeonameIds
            ?: '-1';

        $sqlCountryCodes = implode( "','", array_filter( array_column( $ids, 'iso2' ) ) );
        $sqlCountryCodes = $sqlCountryCodes
            ? "'$sqlCountryCodes'"
            : "'--'";

        $sqlCountryFeatures = Core::FEATURE_FILTERS['countriesOnly'];

        array_walk($sqlCountryFeatures, static function(&$array, $featureClass) {
            $array = sprintf( "(feature_class = '%s' AND feature_code IN ('%s'))", $featureClass, implode( "','", $array ) );
        });

        $sqlCountryFeatures = implode(' OR ', $sqlCountryFeatures);

        $sql = Core::$wpdb::replaceTablePrefix(
            <<<SQL
SELECT
     COALESCE(l.geoname_id ,c.geoname_id)   AS ID
    ,l.geoname_id                           as idLocation
    ,c.geoname_id                           as idCountry
    ,c.*
    ,l.*

FROM
    `wp_geonames_countries`             c
LEFT JOIN
    `wp_geonames_locations_cache`       l   ON c.geoname_id = l.geoname_id

WHERE
	0
    OR c.geoname_id     IN ($sqlGeonameIds)
    OR c.iso2           IN ($sqlCountryCodes)

UNION

SELECT
     COALESCE(c.geoname_id ,l.geoname_id)   AS ID
    ,l.geoname_id                           as idLocation
    ,c.geoname_id                           as idCountry
    ,c.*
    ,l.*

FROM
    `wp_geonames_locations_cache`       l
LEFT JOIN
    `wp_geonames_countries`             c   ON c.geoname_id = l.geoname_id

WHERE
	0
    OR   c.geoname_id     IN ($sqlGeonameIds)
    OR ( l.country_code   IN ($sqlCountryCodes) AND ($sqlCountryFeatures) )
;
SQL
        );

        $countries = Core::$wpdb->get_results( $sql );

        if ( Core::$wpdb->last_error_no )
        {
            throw new ErrorException( Core::$wpdb->last_error, Core::$wpdb->last_error_no );
        }

        parent::parseArray( $countries );

        $ids = array_filter( array_column( $ids, 'o' ) );

        /** @noinspection AdditionOperationOnArraysInspection */
        return $countries + $ids;
    }

}
