<?php

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

        $oAventuraObjeto = new cAventuraObjeto($this->databaseLink);
        $oAventuraObjeto->SetIdJugador($this->idJugador);
        $objetos = $oAventuraObjeto->MostrarInventario();

        // TODO : sacar esto a una clase
        for ($i = 0; $i < count($objetos); $i++)
        {
            $textoGenero =  ($objetos[$i]['femenino'] == 1) ? "una" : "un";
            if ($i == 0)
            {
                $texto = (" Tienes ".$textoGenero." ".$objetos[$i]['referencia']);
            } else {
                if (($i+1) < count($objetos))
                {
                    $texto = $texto.(", ".$textoGenero." ".$objetos[$i]['referencia']);
                } else {
                    $texto = $texto.(" y ".$textoGenero." ".$objetos[$i]['referencia']);
                }
            }
        }
        if ($i > 0) { $texto .= ("."); };

        cPintarPantalla::PintarRespuestaAccion($texto);

//print_r($resultado);


    }

} 