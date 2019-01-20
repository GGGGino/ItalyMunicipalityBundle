<?php

namespace GGGGino\ItalyMunicipalityBundle\Service;

use GGGGino\ItalyMunicipalityBundle\Entity\CsvLine;
use Symfony\Component\Cache\Adapter\AdapterInterface;

/**
 * Class used to retrieve the specified type regions/provinces/municipalities
 *
 * Class IstatRetrivier
 * @package GGGGino\ItalyMunicipalityBundle\Service
 */
class IstatRetrivier
{
    const CACHE_REGIONS_KEY = "ggggino.italy_municipality.regions";

    const CACHE_PROVINCES_KEY = "ggggino.italy_municipality.province";

    const CACHE_MUNICIPALITIES_KEY = "ggggino.italy_municipality.municipality";

    /**
     * @var AdapterInterface
     */
    private $cache;

    /**
     * @var IstatPopulator
     */
    private $populator;

    /**
     * IstatRetrivier constructor.
     * @param AdapterInterface $cache
     * @param IstatPopulator $populator
     */
    public function __construct(AdapterInterface $cache, IstatPopulator $populator)
    {
        $this->cache = $cache;
        $this->populator = $populator;
    }

    /**
     * Get the interested line given from the callback function
     *
     * @param callable $callback Callback used for retrieve the right lines
     * @param string $cacheString name of the cache if not present not use the cache
     * @return \GGGGino\ItalyMunicipalityBundle\Entity\CsvLine[]|mixed
     */
    public function getBy($callback, $cacheString = null)
    {
        if( $cacheString && $this->cache->hasItem($cacheString) )
            return $this->cache->getItem($cacheString)->get();

        /** @var CsvLine[] $csvLines */
        $csvLines = $this->populator->getLines();

        /** @var CsvLine[] $regions */
        $resultLines = call_user_func_array($callback, array($csvLines));

        if( $cacheString ){
            $linesInCache = $this->cache->getItem($cacheString);
            $linesInCache->set($resultLines);
            $this->cache->save($linesInCache);
        }

        return $resultLines;
    }

    /**
     * @return CsvLine[]
     */
    public function getMunicipalities()
    {
        return $this->getBy(function($csvLines) {
            /** @var CsvLine[] $regions */
            $regions = array();

            /** @var CsvLine $line */
            foreach($csvLines as $line) {
                if( !array_key_exists($line->codiceComuneNum, $regions) ){
                    $regions[$line->codiceComuneNum] = $line;
                }
            }

            return $regions;
        }, self::CACHE_MUNICIPALITIES_KEY);
    }

    /**
     * @return CsvLine[]
     */
    public function getProvinces()
    {
        return $this->getBy(function($csvLines) {
            /** @var CsvLine[] $regions */
            $regions = array();

            /** @var CsvLine $line */
            foreach($csvLines as $line) {
                if( !array_key_exists($line->codiceProvincia, $regions) ){
                    $regions[$line->codiceProvincia] = $line;
                }
            }

            return $regions;
        }, self::CACHE_PROVINCES_KEY);
    }

    /**
     * @return CsvLine[]
     */
    public function getRegions()
    {
        return $this->getBy(function($csvLines) {
            /** @var CsvLine[] $regions */
            $regions = array();

            /** @var CsvLine $line */
            foreach($csvLines as $line) {
                if( !array_key_exists($line->codiceRegione, $regions) ){
                    $regions[$line->codiceRegione] = $line;
                }
            }

            return $regions;
        }, self::CACHE_REGIONS_KEY);
    }
}