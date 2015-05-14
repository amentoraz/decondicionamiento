<?php

include_once('iParserVerbal.php');

class cParserVerbalMovimiento implements iParserVerbal {

    public function Procesar($oracion)
    {

        echo ("[PROCESANDO MOVIMIENTO]");

        $oracion = strtoupper(trim($oracion));

        if (strpos($oracion, "NORTE") !== false)
        {
            echo ("[Norte]");
        }
        if (strpos($oracion, "SUR") !== false)
        {
            echo ("[Sur]");
        }
        if (strpos($oracion, "ESTE") !== false)
        {
            echo ("[Este]");
        }
        if (strpos($oracion, "OESTE") !== false)
        {
            echo ("[Oeste]");
        }

        if (strpos($oracion, "ENTRAR") !== false)
        {
            echo ("[Entrar]");
        }

        if (strpos($oracion, "SALIR") !== false)
        {
            echo ("[Salir]");
        }

        if (((strpos($oracion, "ARRIBA") !== false) || (strpos($oracion, "SUBIR")) !== false || (strpos($oracion, "SUBE")) !== false))
        {
            echo ("[Arriba/Subir]");
        }

        if (((strpos($oracion, "ABAJO") !== false) || (strpos($oracion, "BAJAR")) !== false || (strpos($oracion, "BAJA")) !== false))
        {
            echo ("[Abajo/Bajar]");
        }

    }

} 