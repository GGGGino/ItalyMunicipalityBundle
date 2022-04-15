<?php

namespace GGGGino\ItalyMunicipalityBundle\Service;

use GGGGino\ItalyMunicipalityBundle\Entity\CsvLine;
use GGGGino\ItalyMunicipalityBundle\Exception\CsvLineNotValidException;
use GGGGino\ItalyMunicipalityBundle\Exception\CsvLinesUnavailableException;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

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

    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(AdapterInterface $cache, HttpClientInterface $client)
    {
        $this->cache = $cache;
        $this->client = $client;
    }

    /**
     * Download the file
     */
    public function download()
    {
        $response = $this->client->request(
            'GET',
            self::ISTAT_COMUNI_
        );
        if( $response->getStatusCode() == 200 )
        {
            /** @var string $responseContent */
            $responseContent = $response->getContent();
            $arrayLines = str_getcsv($responseContent, "\r\n"); //parse the rows
        }
        else
        {
            $fallback = file_get_contents(__DIR__.'/../Elenco-comuni-italiani.csv');
            $arrayLines = str_getcsv($fallback, "\r\n");
        }

        //parse the rows
        $first = true;
        foreach($arrayLines as &$data){
            $data = str_getcsv($data, ";");

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