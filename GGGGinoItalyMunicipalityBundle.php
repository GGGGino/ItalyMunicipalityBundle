<?php

namespace GGGGino\ItalyMunicipalityBundle;

use GGGGino\ItalyMunicipalityBundle\DependencyInjection\GGGGinoItalyMunicipalityExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class GGGGinoItalyMunicipalityBundle extends Bundle
{

    /**
     * @inheritdoc
     */
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new GGGGinoItalyMunicipalityExtension();
        }
        return $this->extension;
    }
}