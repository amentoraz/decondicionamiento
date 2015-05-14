<?php
/**
 * Created by PhpStorm.
 * User: pablo
 * Date: 13/05/15
 * Time: 11:50
 */


// TODO que esto se cargue solo
include_once('cParserVerbalCOGER.php');
include_once('cParserVerbalDEJAR.php');
include_once('cParserVerbalEXAMINAR.php');
include_once('cParserVerbalAYUDA.php');
include_once('cParserVerbalINVENTARIO.php');
include_once('cParserVerbalSALIDAS.php');
include_once('cParserVerbalMovimiento.php');

class cParserFactoriaVerbo {

    // Private variables

    private $databaseLink;
    private $tipoLog;

    private $idInstanciaLocalizacion;
    private $idJugador;

    private $verboArray = array(
        'COGER ',
        'DEJAR ',
        'EXAMINAR ',
        'AYUDA',
        'INVENTARIO',
        'SALIDAS',
    );

    private $salidasArray = array(
        'NORTE',
        'SUR',
        'ESTE',
        'OESTE',
        'ENTRAR',
        'SALIR',
        'ARRIBA',
        'ABAJO',
        'SUBIR',
        'BAJAR',
    );


    // Constructor and Set methods

    public function __construct($databaseLink, $tipoLog = 'standard')
    {
        $this->databaseLink = $databaseLink;
        $this->tipoLog = $tipoLog;
    }

    public function SetIdJugador($value) { $this->idJugador = $value; }
    public function SetIdInstanciaLocalizacion($value) { $this->idInstanciaLocalizacion = $value; }



    //  Esto solo necesita un método, que es el de creación. Este localiza un verbo y determina entonces a qué
    // implementación se debe enviar la frase

    public function Crear($oracion)
    {

        // Pasamos ambos a mayúsculas
        $oracion = strtoupper($oracion);


        // Primero vamos a ver si es una salida
        for ($j = 0; $j < count($this->salidasArray); $j++)
        {
            $lugar = strpos($oracion, $this->salidasArray[$j]);
            if ($lugar !== false) {
                $oParserVerbal = new cParserVerbalMovimiento($this->databaseLink);
                $oParserVerbal->SetIdInstanciaLocalizacion($this->idInstanciaLocalizacion);
                $oParserVerbal->SetIdJugador($this->idJugador);
                return $oParserVerbal;
            }
        }

        //  Dependiendo del verbo que localice como principal dentro de la frase, decidirá usar una u otra
        // implementación del interfaz iParserVerbal

        for ($i = 0; $i < count($this->verboArray); $i++) {
            $lugar = strpos($oracion, $this->verboArray[$i]);
            if ($lugar !== false) {
                // Montamos el nombre de la implementacion de iParserVerbal como cParserVerboXXXXX
                $nombreClase = "cParserVerbal" . trim($this->verboArray[$i]);
                $oParserVerbal = new $nombreClase($this->databaseLink);
                $oParserVerbal->SetIdInstanciaLocalizacion($this->idInstanciaLocalizacion);
                $oParserVerbal->SetIdJugador($this->idJugador);
            }
        }

        if (isset($oParserVerbal)) { return $oParserVerbal; } else { return null; };


    }

} 