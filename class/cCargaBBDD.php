<?php

include_once('cFileIO.php');

class cCargaBBDD {

    private $databaseLink;
    private $tipoLog;

    private $rutaScript = "docs/bbdd.sql";

    public function __construct($databaseLink, $tipoLog = 'standard')
    {
        $this->databaseLink = $databaseLink;
        $this->tipoLog = $tipoLog;
    }


    public function EjecutarScript()
    {

        $command = "mysql --user=root onethrto_decondicionamiento < /var/www/decondicionamiento/game/docs/bbdd.sql";
        $output = shell_exec($command);

    }


} 