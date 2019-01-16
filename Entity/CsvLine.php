<?php

namespace GGGGino\ItalyMunicipalityBundle\Entity;

class CsvLine
{
    /** @var string Codice Regione */
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
     */
    public static function createCsvLine($line)
    {
        $newSelf = new self();

        $newSelf->codiceRegione = $line[0];
        $newSelf->codiceUnitaTerritoriale = $line[1];
        $newSelf->codiceProvincia = $line[2];
        $newSelf->progressivoDelComune = $line[3];
        $newSelf->codiceComuneAlfaumerico = $line[4];
        $newSelf->denominazione = $line[5];
        $newSelf->denominazioneIta = $line[6];
        $newSelf->denominazioneAltraLingua = $line[7];
        $newSelf->codiceRipartizione = $line[8];
        $newSelf->ripartizioneGeo = $line[9];
        $newSelf->denomReg = $line[10];
        $newSelf->denomUnitaTerritoriale = $line[11];
        $newSelf->flagCapoluogo = $line[12];
        $newSelf->siglaAutomob = $line[13];
        $newSelf->codiceComuneNum = $line[14];
        $newSelf->codiceComuneNum110 = $line[15];
        $newSelf->codiceComuneNum107 = $line[16];
        $newSelf->codiceComuneNum103 = $line[17];
        $newSelf->codiceCatastale = $line[18];
        $newSelf->popolazioneLegale = $line[19];
        $newSelf->nuts1 = $line[20];
        $newSelf->nuts2 = $line[21];
        $newSelf->nuts3 = $line[22];

        return $newSelf;
    }
}