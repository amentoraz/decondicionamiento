<?php

include_once('iParserVerbal.php');

class cParserVerbalMovimiento implements iParserVerbal {


    // Private variables

    private $databaseLink;
    private $tipoLog;


    // Constructor and Set methods

    public function __construct($databaseLink, $tipoLog = 'standard')
    {
        $this->databaseLink = $databaseLink;
        $this->tipoLog = $tipoLog;
    }

    public function SetIdJugador($value) { $this->idJugador = $value; }
    public function SetIdInstanciaLocalizacion($value) { $this->idInstanciaLocalizacion = $value; }


    public function EjecutarMovimiento($codigoSalida)
    {
//        echo ("##".$this->idJugador."#".$this->idInstanciaLocalizacion."@");

        // 1. Vamos a comprobar si existe esa salida (y está visible) en la habitación actual
        $sql = "SELECT ais.*, acs.descripcion AS nombreSalida
                FROM aventura_instancia_salida ais, aventura_salida ass, aventura_codigos_salidas acs
                WHERE ais.idAventuraSalida = ass.id
                AND acs.id = ais.direccion
                AND ais.idLocalizacionOrigen = ?
                AND ais.idJugador = ?
                AND ais.activada = 1
				";

        $stmt = $this->databaseLink->PrepareStatementRead($sql);
        $stmt->execute(array($this->idInstanciaLocalizacion, $this->idJugador));
        $result = $stmt->fetchAll();

        for ($i = 0; $i < count($result); $i++)
        {
            if ($result[$i]['direccion'] == $codigoSalida)
            {
                // Ahora vamos a mover al jugador a la nueva localizacion
                $oAventuraJugador = new cAventuraJugador($this->databaseLink);
                $oAventuraJugador->SetIdJugador($this->idJugador);
                $oAventuraJugador->ActualizarLocalizacion($result[$i]['idLocalizacionDestino']);
                return true;
            }
        }
        return false;
    }




    public function Procesar($oracion)
    {

        //echo ("[PROCESANDO MOVIMIENTO]");

        $oracion = strtoupper(trim($oracion));

        if ((strpos($oracion, "NORTE") !== false) || ($oracion == 'N'))
        {
            $result = $this->EjecutarMovimiento(1);
            if ($result) { cPintarPantalla::Pintar("Vas al Norte.<br/>"); } else { cPintarPantalla::PintarRespuestaAccion("No hay salida en esa dirección.<br/>"); }
            return;
        }
        if ((strpos($oracion, "SUR") !== false) || ($oracion == 'S'))
        {
            $result = $this->EjecutarMovimiento(3);
            if ($result) { cPintarPantalla::Pintar("Vas al Sur.<br/>"); } else { cPintarPantalla::PintarRespuestaAccion("No hay salida en esa dirección.<br/>"); }
            return;
        }
        if ((strpos($oracion, "OESTE") !== false) || ($oracion == 'O'))
        {
            $result = $this->EjecutarMovimiento(4);
            if ($result) { cPintarPantalla::Pintar("Vas al Oeste.<br/>"); } else { cPintarPantalla::PintarRespuestaAccion("No hay salida en esa dirección.<br/>"); }
            return;
        }
        if ((strpos($oracion, "ESTE") !== false) || ($oracion == 'E'))
        {
            $result = $this->EjecutarMovimiento(2);
            if ($result) { cPintarPantalla::Pintar("Vas al Este.<br/>"); } else { cPintarPantalla::PintarRespuestaAccion("No hay salida en esa dirección.<br/>"); }
            return;
        }
        if (strpos($oracion, "ENTRAR") !== false)
        {
            $result = $this->EjecutarMovimiento(5);
            if ($result) { cPintarPantalla::Pintar("Entras.<br/>"); } else { cPintarPantalla::PintarRespuestaAccion("No hay salida en esa dirección.<br/>"); }
            return;
        }

        if (strpos($oracion, "SALIR") !== false)
        {
            $result = $this->EjecutarMovimiento(6);
            if ($result) { cPintarPantalla::Pintar("Sales.<br/>"); } else { cPintarPantalla::PintarRespuestaAccion("No hay salida en esa dirección.<br/>"); }
            return;
        }

        if (((strpos($oracion, "ARRIBA") !== false) || (strpos($oracion, "SUBIR")) !== false || (strpos($oracion, "SUBE")) !== false))
        {
            $result = $this->EjecutarMovimiento(7);
            if ($result) { cPintarPantalla::Pintar("Subes.<br/>"); } else { cPintarPantalla::PintarRespuestaAccion("No hay salida en esa dirección.<br/>"); }
            return;
        }

        if (((strpos($oracion, "ABAJO") !== false) || (strpos($oracion, "BAJAR")) !== false || (strpos($oracion, "BAJA")) !== false))
        {
            $result = $this->EjecutarMovimiento(8);
            if ($result) { cPintarPantalla::Pintar("Bajas.<br/>"); } else { cPintarPantalla::PintarRespuestaAccion("No hay salida en esa dirección.<br/>"); }
            return;
        }

    }

} 