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


    public function GetDatosJugador($idJugador)
    {
        $sql = "SELECT * FROM aventura_jugador
				WHERE id = ?
				LIMIT 1
				";
        $stmt = $this->databaseLink->PrepareStatementRead($sql);
        $stmt->execute(array($idJugador));
        $result = $stmt->fetchAll();
        return $result[0];
    }

} 