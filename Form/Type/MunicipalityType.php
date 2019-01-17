<?php

namespace GGGGino\ItalyMunicipalityBundle\Form\Type;

use GGGGino\ItalyMunicipalityBundle\Entity\CsvLine;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MunicipalityType extends AbstractLocalityType
{
    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $choices = $this->parseMunicipality();

        $resolver->setDefaults([
            'choices' => $choices,
        ]);
    }

    /**
     * @return array
     */
    private function parseMunicipality()
    {
        /** @var CsvLine[] $lines */
        $lines = $this->retrivier->getMunicipalities();
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