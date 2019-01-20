<?php

namespace GGGGino\ItalyMunicipalityBundle\Tests\Service;

use GGGGino\ItalyMunicipalityBundle\Service\IstatPopulator;
use GGGGino\ItalyMunicipalityBundle\Service\IstatRetrivier;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\SimpleCacheAdapter;
use Symfony\Component\Cache\Simple\FilesystemCache;

class IstatRetrivierTest extends TestCase
{
    /**
     * @var SimpleCacheAdapter
     */
    private $cacheAdapter;

    /**
     * @var IstatRetrivier
     */
    private $istatRetrivier;

    public function setUp()
    {
        $fileSystemCache = new FilesystemCache();
        $this->cacheAdapter = new SimpleCacheAdapter($fileSystemCache);

        $clientInterface = new \Http\Adapter\Guzzle6\Client();

        $populator = new IstatPopulator($this->cacheAdapter, $clientInterface);
        $this->istatRetrivier = new IstatRetrivier($this->cacheAdapter, $populator);
    }

    public function testRegions()
    {
        $regions = $this->istatRetrivier->getRegions();

        $this->assertEquals(20, count($regions));
    }

    public function testProvince()
    {
        $provinces = $this->istatRetrivier->getProvinces();

        $this->assertEquals(107, count($provinces));
    }

    public function testMunicipality()
    {
        $municipalities = $this->istatRetrivier->getMunicipalities();

        $this->assertEquals(7926, count($municipalities));
    }
}