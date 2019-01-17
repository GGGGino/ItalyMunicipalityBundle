<?php

namespace GGGGino\ItalyMunicipalityBundle\Form\Type;

use GGGGino\ItalyMunicipalityBundle\Entity\CsvLine;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProvinceType extends AbstractLocalityType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $choices = $this->parseProvinces();

        $resolver->setDefaults([
            'choices' => $choices,
        ]);
    }

    /**
     * @return array
     */
    private function parseProvinces()
    {
        /** @var CsvLine[] $lines */
        $lines = $this->retrivier->getProvinces();
        $choices = array();

        /**
         * @var int $key
         * @var CsvLine $value
         */
        foreach ($lines as $key => $value) {
            $choices[$value->denominazioneIta] = $key;
        }

        return $choices;
    }
}