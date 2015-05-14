<?php
/**
 * Created by PhpStorm.
 * User: pablo
 * Date: 13/05/15
 * Time: 10:51
 */

include_once('cParserFactoriaVerbo.php');
include_once('iParserVerbal.php');

class cParser {



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

        // Aquí van a llegar oraciones individuales
        $oParserFactoriaVerbo = new cParserFactoriaVerbo();
        $oParserVerbal = $oParserFactoriaVerbo->Crear($oracion);

        if (isset($oParserVerbal)) {
            $oParserVerbal->Procesar($oracion);
        } else {
            $rand = rand( 0, count(($this->arrayErroneo)) - 1 );
            cPintarPantalla::Pintar($this->arrayErroneo[$rand]);
        }



    }

} 