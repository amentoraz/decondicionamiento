<?php

include_once('iParserVerbal.php');

class cParserVerbalDEJAR implements iParserVerbal {



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



    private function DejarObjeto($nombreObjeto)
    {
        $sql = "SELECT aio.id, ao.referencia, ao.femenino
                FROM aventura_instancia_objeto aio, aventura_objeto ao
                WHERE aio.idObjeto = ao.id
                AND aio.idLocalizacion = 0
                AND aio.idJugador = ?
                AND (
                    UPPER(ao.referencia) = ?
                    OR UPPER(ao.alias1) = ?
                    OR UPPER(ao.alias2) = ?
                )
                ";
        $stmt = $this->databaseLink->PrepareStatementRead($sql);
        $stmt->execute(array($this->idJugador, $nombreObjeto, $nombreObjeto, $nombreObjeto));
        $result = $stmt->fetchAll();
        if (count($result) > 0)
        {
            // 1. Escribimos el mensaje de que lo has cogido bien
            if ($result[0]['femenino'] == 1)
            {
                cPintarPantalla::PintarRespuestaAccion("Dejas la ".$result[0]['referencia'].".");
            } else {
                cPintarPantalla::PintarRespuestaAccion("Dejas el ".$result[0]['referencia'].".");
            }

            // 2. Cambiamos la localizacion del objeto para pasarla a tu inventario (0)
            $sql2 = "UPDATE aventura_instancia_objeto
                    SET idLocalizacion = ?
                    WHERE id = ?
                    ";
            $stmt2 = $this->databaseLink->PrepareStatementWrite($sql2);
            $stmt2->execute(array($this->idInstanciaLocalizacion, $result[0]['id']));

            // 3. Devolvemos true alegremente
            return true;

        } else {
            cPintarPantalla::PintarRespuestaAccion("No puedes dejar  eso.");
        }
    }





    public function Procesar($oracion)
    {

        // 1. Procesamos la oración para sacar el objeto que quiere dejar
        $oracion = strtoupper($oracion);
        if (substr($oracion, 0, 6) == 'DEJAR ')
        {
            $oracion = substr($oracion, 6);
            if ((substr($oracion, 0, 3) == 'LA ') || (substr($oracion, 0, 3) == 'EL ') || (substr($oracion, 0, 3) == 'UN ')) { $oracion = substr($oracion, 3); }
            if ((substr($oracion, 0, 4) == 'LAS ') || (substr($oracion, 0, 3) == 'LOS ') || (substr($oracion, 0, 3) == 'UNA ')) { $oracion = substr($oracion, 4); }

            return ($this->DejarObjeto($oracion));

        } else {
            return false;
        }

    }

} 