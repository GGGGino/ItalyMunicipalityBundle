<?php

namespace GGGGino\ItalyMunicipalityBundle\Exception;

use GGGGino\ItalyMunicipalityBundle\Entity\CsvLine;

/**
 * Exception launched when is building the CsvLine but something went wrong
 *
 * Class CsvLineNotValidException
 * @package GGGGino\ItalyMunicipalityBundle\Exception
 */
class CsvLineNotValidException extends \Exception
{
    /**
     * @var array
     */
    private $csvLine;

    public function __construct($csvLine , $message, $code = 0, \Exception $previous = null)
    {
        $this->csvLine = $csvLine;

        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }
}