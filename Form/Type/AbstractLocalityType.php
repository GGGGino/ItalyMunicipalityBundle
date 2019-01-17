<?php

namespace GGGGino\ItalyMunicipalityBundle\Form\Type;

use GGGGino\ItalyMunicipalityBundle\Service\IstatRetrivier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

abstract class AbstractLocalityType extends AbstractType
{
    /**
     * @var IstatRetrivier
     */
    protected $retrivier;

    public function __construct(IstatRetrivier $retrivier)
    {
        $this->retrivier = $retrivier;
    }

    /**
     * @inheritdoc
     */
    public function getParent()
    {
        return ChoiceType::class;
    }
}