<?php

include_once('iParserVerbal.php');

class cParserVerbalINVENTARIO implements iParserVerbal {


    // Private variables

    private $databaseLink;
    private $tipoLog;

    // Constructor and Set methods

    public function __construct($databaseLink, $tipoLog = 'standard')
    {
        $this->databaseLink = $databaseLink;
        $this->tipoLog = $tipoLog;
    }


    private $idInstanciaLocalizacion;
    private $idJugador;
    public function SetIdJugador($value) { $this->idJugador = $value; }
    public function SetIdInstanciaLocalizacion($value) { $this->idInstanciaLocalizacion = $value; }


    public function Procesar($oracion)
    {

        echo ("[PROCESANDO INVENTARIO]");



    }

} 