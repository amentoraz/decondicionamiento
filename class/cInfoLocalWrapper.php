<?php

/**
 *  Esta clase lo que hace es sacar información de otras clases obteniendo los datos de la localización en
 * la que se encuentra el jugador
 *
 */

// Todo esto se debería sustituir por un sistema que lo cargue todo dinámicamente, claro
include_once ("class/cAventuraLocalizacion.php");
include_once ("class/cAventuraJugador.php");
include_once ("class/cAventuraSalidas.php");

class cInfoLocalWrapper {


    private $databaseLink;
    private $tipoLog;

    private $idJugador;
    private $idInstanciaLocalizacion;

    public function __construct($databaseLink, $tipoLog = 'standard')
    {
        $this->databaseLink = $databaseLink;
        $this->tipoLog = $tipoLog;
    }

    public function SetIdJugador($value) { $this->idJugador = $value; }
    public function SetIdInstanciaLocalizacion($value) { $this->idInstanciaLocalizacion = $value; }



    public function GetDatosBaseLugar()
    {

        $oAventuraLocalizacion = new cAventuraLocalizacion($this->databaseLink);
        $oAventuraLocalizacion->SetIdJugador($this->idJugador);
        $oAventuraLocalizacion->SetIdInstanciaLocalizacion($this->idInstanciaLocalizacion);
        $arrayDescripcion = $oAventuraLocalizacion->GetBasicData();

        $oAventuraSalidas = new cAventuraSalidas($this->databaseLink);
        $oAventuraSalidas->SetIdJugador($this->idJugador);
        $oAventuraSalidas->SetIdInstanciaLocalizacion($this->idInstanciaLocalizacion);
        $arraySalidas = $oAventuraSalidas->GetSalidasVisiblesLocalizacion();

        $arrayFinal['infoBase'] = $arrayDescripcion;
        $arrayFinal['salidas'] = $arraySalidas;

        return $arrayFinal;

    }


} 