<?php
/**
 * Created by PhpStorm.
 * User: pablo
 * Date: 13/05/15
 * Time: 10:51
 */

class cParser {

    // Private variables

    private $databaseLink;
    private $tipoLog;

    private $idInstanciaLocalizacion;
    private $idJugador;


    private $arrayErroneo = array(
        'Lo siento, no te he entendido.',
        'No sé qué quieres hacer.',
        '¿Podrías intentar escribirlo de otra manera?',
        'No sé cómo interpretar tus órdenes',
        'No entiendo.'
    );

    private $conjuncionArray = array(
        ', luego ',
        ' y luego ',
        ' y después ',
        ' y despues ',
        ', después ',
        ', despues ',
        ' y ',
    );


    private $verboAliasArray = array(
        array('TOMAR ',  'COGER '),
        array('RECOGER ',  'COGER '),
        array('ACOGER ',  'INVALIDO '),  // Esto es para que no malinterprete según qué cosas
        array('ENCOGER ',  'INVALIDO '),
        array('SOLTAR ',  'DEJAR '),
    );




    // Constructor and Set methods

    public function __construct($databaseLink, $tipoLog = 'standard')
    {
        $this->databaseLink = $databaseLink;
        $this->tipoLog = $tipoLog;
    }

    public function SetIdJugador($value) { $this->idJugador = $value; }
    public function SetIdInstanciaLocalizacion($value) { $this->idInstanciaLocalizacion = $value; }





    // Con este método vamos a buscar nexos conjuntivos + partícular temporales como "y", "y luego"

    private function EsConjuntiva($oracion)
    {
        for ($i = 0; $i < count($this->conjuncionArray); $i++)
        {
            if (strpos($oracion, $this->conjuncionArray[$i]) !== false)
            {
                return true;
            }
        }
        return false;
    }

    // Con este método partimos la oración y llamamos recursivamente a parsear

    private function EjecutarConjuntiva($oracion)
    {

        for ($i = 0; $i < count($this->conjuncionArray); $i++)
        {
            $lugar = strpos($oracion, $this->conjuncionArray[$i]);
            if ($lugar !== false)
            {
                $primeraFrase = substr($oracion, 0, $lugar);
                $segundaFrase = substr($oracion, $lugar+3, (strlen($oracion) - $lugar - 3) );
                $this->ParsearOracion($primeraFrase);
                $this->ParsearOracion($segundaFrase);
            }
        }
    }


    // ***********************************************
    //       Este metodo hace el destripado de la oracion
    // ***********************************************

    public function ParsearOracion($oracion)
    {
//echo ("Parseando : ".$oracion."<br/>");
        // En primer lugar vamos a ver si se trata de más de una acción en conjunción
        if ($this->EsConjuntiva($oracion))
        {
            $this->EjecutarConjuntiva($oracion);
            return;
        }

        // 1. Pasamos a mayúsculas
        $oracion = strtoupper($oracion);

        // 2. Acortados especiales
        if (trim($oracion) == "O") { $oracion = "OESTE"; }
        if (trim($oracion) == "E") { $oracion = "ESTE"; }
        if (trim($oracion) == "N") { $oracion = "NORTE"; }
        if (trim($oracion) == "S") { $oracion = "SUR"; }
        if (trim($oracion) == "I") { $oracion = "INVENTARIO"; }

        //  3. Dependiendo del verbo que localice como principal dentro de la frase, decidirá usar una u otra
        // implementación del interfaz iParserVerbal
        for ($i = 0; $i < count($this->verboAliasArray); $i++) {
            $lugar = strpos($oracion, $this->verboAliasArray[$i][0]);
            if ($lugar !== false) {
                $oracion = str_replace($this->verboAliasArray[$i][0], $this->verboAliasArray[$i][1], $oracion);
            }
        }

        // Aquí van a llegar oraciones individuales
        $oParserFactoriaVerbo = new cParserFactoriaVerbo($this->databaseLink);
        $oParserFactoriaVerbo->SetIdInstanciaLocalizacion($this->idInstanciaLocalizacion);
        $oParserFactoriaVerbo->SetIdJugador($this->idJugador);
        $oParserVerbal = $oParserFactoriaVerbo->Crear($oracion);

        if (isset($oParserVerbal)) {
            //$oParserVerbal->Procesar($oParserFactoriaVerbo->GetOracionfinal()); // En vez de $oracion, para que envíe el procesado
            $oParserVerbal->Procesar($oracion); // En vez de $oracion, para que envíe el procesado
        } else {
            $rand = rand( 0, count(($this->arrayErroneo)) - 1 );
            cPintarPantalla::PintarRespuestaAccion($this->arrayErroneo[$rand]);
        }



    }

} 