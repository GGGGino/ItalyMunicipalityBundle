<?php

namespace GGGGino\ItalyMunicipalityBundle\Form\Type;

use GGGGino\ItalyMunicipalityBundle\Entity\CsvLine;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegionType extends AbstractLocalityType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $choices = $this->parseRegions();

        $resolver->setDefaults([
            'choices' => $choices,
        ]);
    }

    /**
     * @return array
     */
    private function parseRegions()
    {
        /** @var CsvLine[] $lines */
        $lines = $this->retrivier->getRegions();
        $choices = array();

        /**
         * @var int $key
         * @var CsvLine $value
         */
        foreach ($lines as $key => $value) {
            $choices[$value->denomReg] = $key;
        }

        return $choices;
    }
}