<?php

namespace GGGGino\ItalyMunicipalityBundle\Service;

use GGGGino\ItalyMunicipalityBundle\Entity\CsvLine;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class IstatRetrivier
{
    const ISTAT_COMUNI_ = "https://www.istat.it/storage/codici-unita-amministrative/Elenco-comuni-italiani.csv";

    /**
     * @var AdapterInterface
     */
    private $cache;

    /**
     * @var CsvLine[]
     */
    private $csvLines;

    /**
     * @var IstatPopulator
     */
    private $populator;

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
    public function getByCallback($callback, $cacheString = null)
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

    public function getMunicipality()
    {
        return $this->getByCallback(function($csvLines) {
            /** @var CsvLine[] $regions */
            $regions = array();

            /** @var CsvLine $line */
            foreach($csvLines as $line) {
                if( !array_key_exists($line->codiceComuneNum, $regions) ){
                    $regions[$line->codiceComuneNum] = $line;
                }
            }

            return $regions;
        }, 'ggggino.italy_municipality.municipality');
    }

    /**
     * @return CsvLine[]
     */
    public function getProvince()
    {
        return $this->getByCallback(function($csvLines) {
            /** @var CsvLine[] $regions */
            $regions = array();

            /** @var CsvLine $line */
            foreach($csvLines as $line) {
                if( !array_key_exists($line->codiceProvincia, $regions) ){
                    $regions[$line->codiceProvincia] = $line;
                }
            }

            return $regions;
        }, 'ggggino.italy_municipality.province');
    }

    /**
     * @return CsvLine[]
     */
    public function getRegions()
    {
        return $this->getByCallback(function($csvLines) {
            /** @var CsvLine[] $regions */
            $regions = array();

            /** @var CsvLine $line */
            foreach($csvLines as $line) {
                if( !array_key_exists($line->codiceRegione, $regions) ){
                    $regions[$line->codiceRegione] = $line;
                }
            }

            return $regions;
        }, 'ggggino.italy_municipality.regions');
    }
}