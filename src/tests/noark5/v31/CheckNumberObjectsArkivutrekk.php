<?php

class CheckNumberObjectsArkivutrekk extends Test
{
    protected $numberFromArkivUttrekk;
    protected $numberFromParsingArkivstruktur;
    protected $noark5File;
    protected $type;

    function __construct($testName, $numberFromArkivUttrekk, $numberFromParsingArkivstruktur, $noark5File, $type, $testProperty)
    {
        parent::__construct($testName, $testProperty);
        $this->numberFromArkivUttrekk = $numberFromArkivUttrekk;
        $this->numberFromParsingArkivstruktur = $numberFromParsingArkivstruktur;
        $this->noark5File = $noark5File;
        $this->type = $type;
    }

    public function runTest()
    {
        if ($this->numberFromArkivUttrekk == $this->numberFromParsingArkivstruktur) {

            $this->testProperty->addTestResult(true);
        } else {

            $this->testProperty->addTestResult(false);
        }

        $this->testProperty->addTestResultDescription('The number of ' . $this->type . ' reported in arkivuttrekk.xml is (' . $this->numberFromArkivUttrekk . ')' .
            ' The number og ' . $this->type . ' found when parsing ' . $this->noark5File . ' is (' . $this->numberFromParsingArkivstruktur . ')' );

        $this->testProperty->addTestResultReportDescription('Antall ' . $this->type . ' identifisert i arkivuttrekk.xml er (' . $this->numberFromArkivUttrekk . ')' .
            ' Antall ' . $this->type . ' funnet mens filen ' . $this->noark5File . ' ble gjennomgått er (' . $this->numberFromParsingArkivstruktur . ')' );
    }
}

?>