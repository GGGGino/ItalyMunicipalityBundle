<?php

namespace GGGGino\ItalyMunicipalityBundle\Service;

use GGGGino\ItalyMunicipalityBundle\Entity\CsvLine;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class IstatPopulator
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

    public function __construct(AdapterInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Download the file
     */
    public function download()
    {
        // @todo: temporary stora file locally, after download from CDN

        $first = true;
        if (($handle = fopen(__DIR__ . "/../comuni.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if( $first ){
                    $first = false;
                    continue;
                }

                $this->csvLines[] = CsvLine::createCsvLine($data);
            }
            fclose($handle);
        }
    }

    /**
     * @return CsvLine[]
     */
    public function getLines()
    {
        if( !$this->csvLines )
            $this->download();

        return $this->csvLines;
    }

    public function getMunicipality()
    {
        if( $this->cache->hasItem('ggggino.italy_municipality.municipality') )
            return $this->cache->getItem('ggggino.italy_municipality.municipality')->get();

        $csvLines = $this->getLines();
        /** @var CsvLine[] $regions */
        $regions = array();

        /** @var CsvLine $line */
        foreach($csvLines as $line) {
            if( !array_key_exists($line->codiceComuneNum, $regions) ){
                $regions[$line->codiceComuneNum] = $line;
            }
        }

        $regionsInCache = $this->cache->getItem('ggggino.italy_municipality.municipality');
        $regionsInCache->set($regions);
        $this->cache->save($regionsInCache);

        return $regions;
    }

    /**
     * @return CsvLine[]
     */
    public function getProvince()
    {
        if( $this->cache->hasItem('ggggino.italy_municipality.province') )
            return $this->cache->getItem('ggggino.italy_municipality.province')->get();

        $csvLines = $this->getLines();
        /** @var CsvLine[] $regions */
        $regions = array();

        /** @var CsvLine $line */
        foreach($csvLines as $line) {
            if( !array_key_exists($line->codiceProvincia, $regions) ){
                $regions[$line->codiceProvincia] = $line;
            }
        }

        $regionsInCache = $this->cache->getItem('ggggino.italy_municipality.province');
        $regionsInCache->set($regions);
        $this->cache->save($regionsInCache);

        return $regions;
    }

    /**
     * @return CsvLine[]
     */
    public function getRegions()
    {
        if( $this->cache->hasItem('ggggino.italy_municipality.city') )
            return $this->cache->getItem('ggggino.italy_municipality.city')->get();

        $csvLines = $this->getLines();
        /** @var CsvLine[] $regions */
        $regions = array();

        /** @var CsvLine $line */
        foreach($csvLines as $line) {
            if( !array_key_exists($line->codiceRegione, $regions) ){
                $regions[$line->codiceRegione] = $line;
            }
        }

        $regionsInCache = $this->cache->getItem('ggggino.italy_municipality.city');
        $regionsInCache->set($regions);
        $this->cache->save($regionsInCache);

        return $regions;
    }
}