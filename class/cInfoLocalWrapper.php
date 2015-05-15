<?php

/**
 *  Esta clase lo que hace es sacar información de otras clases obteniendo los datos de la localización en
 * la que se encuentra el jugador
 *
 */


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

        $oAventuraObjeto = new cAventuraObjeto($this->databaseLink);
        $oAventuraObjeto->SetIdJugador($this->idJugador);
        $oAventuraObjeto->SetIdInstanciaLocalizacion($this->idInstanciaLocalizacion);
        $arrayObjetos = $oAventuraObjeto->GetObjetosLocalizacion();

        $arrayFinal['infoBase'] = $arrayDescripcion;
        $arrayFinal['salidas'] = $arraySalidas;
        $arrayFinal['objetos'] = $arrayObjetos;

        return $arrayFinal;

    }


} 