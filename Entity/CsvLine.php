<?php

namespace GGGGino\ItalyMunicipalityBundle\Entity;

use GGGGino\ItalyMunicipalityBundle\Exception\CsvLineNotValidException;

class CsvLine
{
    /** @var int Codice Regione */
    public $codiceRegione;
    public $codiceUnitaTerritoriale;
    public $codiceProvincia;
    public $progressivoDelComune;
    public $codiceComuneAlfaumerico;
    public $denominazione;
    public $denominazioneIta;
    public $denominazioneAltraLingua;
    public $codiceRipartizione;
    public $ripartizioneGeo;
    public $denomReg;
    public $denomUnitaTerritoriale;
    public $flagCapoluogo;
    public $siglaAutomob;
    public $codiceComuneNum;
    public $codiceComuneNum110;
    public $codiceComuneNum107;
    public $codiceComuneNum103;
    public $codiceCatastale;
    public $popolazioneLegale;
    public $nuts1;
    public $nuts2;
    public $nuts3;

    /**
     * @param array $line
     * @return CsvLine
     * @throws CsvLineNotValidException
     */
    public static function createCsvLine($line)
    {
        $newSelf = new self();

        if( empty($line[0]) && empty($line[1]) )
            throw new CsvLineNotValidException($line, "Csv line not valid");

        $newSelf->codiceRegione = trim($line[0]);
        $newSelf->codiceUnitaTerritoriale = trim($line[1]);
        $newSelf->codiceProvincia = trim($line[2]);
        $newSelf->progressivoDelComune = trim($line[3]);
        $newSelf->codiceComuneAlfaumerico = trim($line[4]);
        $newSelf->denominazione = utf8_encode(trim($line[5]));
        $newSelf->denominazioneIta = utf8_encode(trim($line[6]));
        $newSelf->denominazioneAltraLingua = utf8_encode(trim($line[7]));
        $newSelf->codiceRipartizione = trim(trim($line[8]));
        $newSelf->ripartizioneGeo = trim(trim($line[9]));
        $newSelf->denomReg = utf8_encode(trim($line[10]));
        $newSelf->denomUnitaTerritoriale = utf8_encode(trim($line[11]));
        $newSelf->flagCapoluogo = trim($line[12]);
        $newSelf->siglaAutomob = trim($line[13]);
        $newSelf->codiceComuneNum = trim($line[14]);
        $newSelf->codiceComuneNum110 = trim($line[15]);
        $newSelf->codiceComuneNum107 = trim($line[16]);
        $newSelf->codiceComuneNum103 = trim($line[17]);
        $newSelf->codiceCatastale = trim($line[18]);
        $newSelf->popolazioneLegale = trim($line[19]);
        $newSelf->nuts1 = trim($line[20]);
        $newSelf->nuts2 = trim($line[21]);
        $newSelf->nuts3 = trim($line[22]);

        return $newSelf;
    }
}