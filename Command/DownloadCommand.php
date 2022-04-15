<?php

namespace GGGGino\ItalyMunicipalityBundle\Command;

use GGGGino\ItalyMunicipalityBundle\Service\IstatPopulator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class DownloadCommand
 * @package GGGGino\ItalyMunicipalityBundle\Command
 */
class DownloadCommand extends Command
{
    /**
     * @var IstatPopulator
     */
    private $istatPopulator;

    public function __construct(IstatPopulator $istatPopulator)
    {
        $this->istatPopulator = $istatPopulator;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('ggggino:italy_municipality:download')
            ->setDescription('Command to download the list from ISTAT');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $lines = $this->istatPopulator->getLines();

        $output->writeln("Trovati " . count($lines) . " comuni");
        return 0;
    }
}