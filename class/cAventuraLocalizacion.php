<?php
/**
 * Created by PhpStorm.
 * User: pablo
 * Date: 13/05/15
 * Time: 17:31
 */

class cAventuraLocalizacion {

    private $databaseLink;
    private $tipoLog;

    public function __construct($databaseLink, $tipoLog = 'standard')
    {
        $this->databaseLink = $databaseLink;
        $this->tipoLog = $tipoLog;
    }

    public function SetIdJugador($value) { $this->idJugador = $value; }
    public function SetIdInstanciaLocalizacion($value) { $this->idInstanciaLocalizacion = $value; }



    // Obtiene la descripcion de una localizacion
    public function GetDescription()
    {
        $sql = "SELECT al.descripcion
                FROM aventura_instancia_localizacion ail, aventura_localizacion al
				WHERE ail.id = ?
				AND ail.idJugador = ?
				AND ail.idLocalizacion = al.id
				LIMIT 1
				";
        $stmt = $this->databaseLink->PrepareStatementRead($sql);
        $stmt->execute(array($this->idInstanciaLocalizacion, $this->idJugador));
        $result = $stmt->fetchAll();

        return $result[0]['descripcion'];
    }



    // Obtiene los datos básicos de una localización
    public function GetBasicData()
    {
        $sql = "SELECT al.descripcion, al.referencia, al.descripcion_alt, al.oscura
                FROM aventura_instancia_localizacion ail, aventura_localizacion al
				WHERE ail.id = ?
				AND ail.idJugador = ?
				AND ail.idLocalizacion = al.id
				LIMIT 1
				";
        $stmt = $this->databaseLink->PrepareStatementRead($sql);
        $stmt->execute(array($this->idInstanciaLocalizacion, $this->idJugador));
        $result = $stmt->fetchAll();

        return $result[0];
    }


} 