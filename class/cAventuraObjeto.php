<?php

class cAventuraObjeto {


    private $databaseLink;
    private $tipoLog;

    public function __construct($databaseLink, $tipoLog = 'standard')
    {
        $this->databaseLink = $databaseLink;
        $this->tipoLog = $tipoLog;
    }

    private $idInstanciaLocalizacion;
    private $idJugador;

    public function SetIdInstanciaLocalizacion($value) { $this->idInstanciaLocalizacion = $value; }
    public function SetIdJugador($value) { $this->idJugador = $value; }





    public function GetObjetosLocalizacion()
    {
        $sql = "SELECT aio.*, ao.femenino, ao.referencia, ao.descripcion_en_localizacion
                FROM aventura_instancia_objeto aio, aventura_objeto ao
				WHERE aio.idLocalizacion = ?
				AND aio.idJugador = ?
				AND ao.id = aio.idObjeto
				AND ao.visible = 1
				";
        $stmt = $this->databaseLink->PrepareStatementRead($sql);
        $stmt->execute(array($this->idInstanciaLocalizacion, $this->idJugador));
        $result = $stmt->fetchAll();
        return $result;
    }



    public function MostrarInventario()
    {
        $sql = "SELECT aio.*, ao.femenino, ao.referencia
                FROM aventura_instancia_objeto aio, aventura_objeto ao
				WHERE aio.idLocalizacion = 0
				AND aio.idJugador = ?
				AND ao.id = aio.idObjeto
				AND ao.visible = 1
				";
        $stmt = $this->databaseLink->PrepareStatementRead($sql);
        $stmt->execute(array($this->idJugador));
        $result = $stmt->fetchAll();
        return $result;
    }





} 