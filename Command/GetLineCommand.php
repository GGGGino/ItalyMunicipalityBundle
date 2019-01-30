<?php

namespace GGGGino\ItalyMunicipalityBundle\Command;

use GGGGino\ItalyMunicipalityBundle\Entity\CsvLine;
use GGGGino\ItalyMunicipalityBundle\Service\IstatPopulator;
use GGGGino\ItalyMunicipalityBundle\Service\IstatRetrivier;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class GetLineCommand
 * @package GGGGino\ItalyMunicipalityBundle\Command
 */
class GetLineCommand extends Command
{
    /**
     * @var IstatRetrivier
     */
    private $istatRetrivier;

    public function __construct(IstatRetrivier $istatRetrivier)
    {
        parent::__construct();
        $this->istatRetrivier = $istatRetrivier;
    }

    protected function configure()
    {
        $this
            ->setName('ggggino:italy_municipality:get_line')
            ->addOption('province', 'p', InputOption::VALUE_REQUIRED)
            ->addOption('region', 'r', InputOption::VALUE_REQUIRED)
            ->addOption('municipality', 'm', InputOption::VALUE_REQUIRED)
            ->setDescription('Get lines from a specifica keyword');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var CsvLine $lines */
        $lines = array();
        $campo = null;
        $option = null;

        if ( $option = $input->getOption('region') ){
            $lines = $this->istatRetrivier->getRegions();
            $campo = 'denomReg';
        }else if ( $option = $input->getOption('province') ){
            $lines = $this->istatRetrivier->getProvinces();
            $campo = 'denomUnitaTerritoriale';
        }else if ( $option = $input->getOption('municipality') ){
            $lines = $this->istatRetrivier->getMunicipalities();
            $campo = 'denominazione';
        }

        $this->getLinesFiltered($output, $lines, $campo, $option);
    }

    private function getLinesFiltered(OutputInterface $output, $lines, $campo, $option)
    {
        /** @var CsvLine $province */
        foreach ($lines as $line) {
            if ( strpos(strtolower($line->{$campo}), $option) !== false ) {
                $output->writeln($line->{$campo});
            }
        }
    }
}