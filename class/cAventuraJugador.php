<?php
/**
 * Created by PhpStorm.
 * User: pablo
 * Date: 13/05/15
 * Time: 17:36
 */

class cAventuraJugador {

    private $databaseLink;
    private $tipoLog;

    public function __construct($databaseLink, $tipoLog = 'standard')
    {
        $this->databaseLink = $databaseLink;
        $this->tipoLog = $tipoLog;
    }

    public function SetIdJugador($value) { $this->idJugador = $value; }

    public function GetDatosJugador()
    {
        $sql = "SELECT * FROM aventura_jugador
				WHERE id = ?
				LIMIT 1
				";
        $stmt = $this->databaseLink->PrepareStatementRead($sql);
        $stmt->execute(array($this->idJugador));
        $result = $stmt->fetchAll();
        return $result[0];
    }


    public function ActualizarTurno($turnoActual)
    {

        $sql = "UPDATE aventura_jugador
                SET turno = ?
                WHERE id = ?
                ";
        $stmt = $this->databaseLink->PrepareStatementWrite($sql);
        $stmt->execute(array($turnoActual, $this->idJugador));
    }

    public function ActualizarLocalizacion($idInstanciaLocalizacion)
    {
        $sql = "UPDATE aventura_jugador
                SET idInstanciaLocalizacion = ?
                WHERE id = ?
                ";
        $stmt = $this->databaseLink->PrepareStatementWrite($sql);
        $stmt->execute(array($idInstanciaLocalizacion, $this->idJugador));
    }

} 