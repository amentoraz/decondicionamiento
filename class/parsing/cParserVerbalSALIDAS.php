<?php

include_once('iParserVerbal.php');

class cParserVerbalSALIDAS implements iParserVerbal {


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

        echo ("[PROCESANDO SALIDAS ".$oracion."]");

        // TODO : leer de aventura_instancia_salida para la localización y jugador actual, qué salidas están disponibles.


    }

} 