<?php

class cPintarPantalla {

    public static function Pintar($mensaje) {

        echo ("<p>");
        echo $mensaje;
        echo ("</p>");
    }



    public static function PintarAccionAnterior($mensaje) {

        echo ("<p style='color: #993333'>");
        echo $mensaje;
        echo ("</p>");
    }


    public static function PintarRespuestaAccion($mensaje) {

        echo ("<p style='color: #ff9999'><i>");
        echo $mensaje;
        echo ("</i></p>");
    }


    public static function PintarTextoAyuda($mensaje) {

        echo ("<p style='color: #8888ff'><i>");
        echo $mensaje;
        echo ("</i></p>");
    }

}