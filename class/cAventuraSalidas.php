<?php
/**
 * Created by PhpStorm.
 * User: pablo
 * Date: 14/05/15
 * Time: 13:24
 */

class cAventuraSalidas {

    private $databaseLink;
    private $tipoLog;

    private $idInstanciaLocalizacion;
    private $idJugador;

    public function __construct($databaseLink, $tipoLog = 'standard')
    {
        $this->databaseLink = $databaseLink;
        $this->tipoLog = $tipoLog;
    }


    public function SetIdInstanciaLocalizacion($value) { $this->idInstanciaLocalizacion = $value; }
    public function SetIdJugador($value) { $this->idJugador = $value; }


    public function GetSalidasVisiblesLocalizacion()
    {

//echo ("#".$this->idInstanciaLocalizacion."#".$this->idJugador);
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

//print_r($result);
        return $result;
    }



} 