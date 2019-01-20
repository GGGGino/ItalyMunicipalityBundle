<?php

namespace GGGGino\ItalyMunicipalityBundle\Tests\Service;

use GGGGino\ItalyMunicipalityBundle\Service\IstatPopulator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\SimpleCacheAdapter;
use Symfony\Component\Cache\Simple\FilesystemCache;

class IstatPopulatorTest extends TestCase
{
    /**
     * @var SimpleCacheAdapter
     */
    private $cacheAdapter;

    /**
     * @var IstatPopulator
     */
    private $populator;

    public function setUp()
    {
        $fileSystemCache = new FilesystemCache();
        $this->cacheAdapter = new SimpleCacheAdapter($fileSystemCache);
        $this->populator = new IstatPopulator($this->cacheAdapter);

        $this->cacheAdapter->delete('ggggino.italy_municipality.all');
    }

    /**
     * Check that before the first call the cache is empty
     */
    private function inCacheBefore()
    {
        /** @var bool $inCache */
        $inCache = $this->cacheAdapter->hasItem('ggggino.italy_municipality.all');

        $this->assertFalse($inCache);
    }

    /**
     * Check that after the first call the data exists in cache
     */
    private function inCacheAfter()
    {
        /** @var bool $inCache */
        $inCache = $this->cacheAdapter->hasItem('ggggino.italy_municipality.all');

        $this->assertTrue($inCache);
    }

    /**
     * Test the download/getter of the lines
     */
    public function testDownload()
    {
        $this->inCacheBefore();

        $lines = $this->populator->getLines();

        $this->assertEquals(7926, count($lines));

        $this->inCacheAfter();
    }
}