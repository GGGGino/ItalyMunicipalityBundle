<?php

namespace GGGGino\ItalyMunicipalityBundle\Service;

use GGGGino\ItalyMunicipalityBundle\Entity\CsvLine;
use GGGGino\ItalyMunicipalityBundle\Exception\CsvLineNotValidException;
use Symfony\Component\Cache\Adapter\AdapterInterface;

/**
 * Class used to retrieve from cache/CDN all the municipalities
 *
 * Class IstatPopulator
 * @package GGGGino\ItalyMunicipalityBundle\Service
 */
class IstatPopulator
{
    const ISTAT_COMUNI_ = "https://www.istat.it/storage/codici-unita-amministrative/Elenco-comuni-italiani.csv";

    const CACHE_LIST_KEY = "ggggino.italy_municipality.all";

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
        // @todo: temporary store file locally, after download from CDN

        $first = true;
        if (($handle = fopen(__DIR__ . "/../comuni.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if( $first ){
                    $first = false;
                    continue;
                }

                try{
                    $this->csvLines[] = CsvLine::createCsvLine($data);
                }catch(CsvLineNotValidException $e) {
                    continue;
                }
            }
            fclose($handle);
        }
    }

    /**
     * Take all the lines of the parsed CSV and put them in cache for future usage
     *
     * @return CsvLine[]
     */
    public function getLines()
    {
        if( $this->cache->hasItem(self::CACHE_LIST_KEY) ){
            $this->csvLines = $this->cache->getItem(self::CACHE_LIST_KEY)->get();
            return $this->csvLines;
        }

        $this->download();

        $linesInCache = $this->cache->getItem(self::CACHE_LIST_KEY);
        $linesInCache->set($this->csvLines);
        $this->cache->save($linesInCache);

        return $this->csvLines;
    }
}