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

        /*
        $oFileIO = new cFileIO();
        $sql = $oFileIO->ReadFileContents($this->rutaScript);
        $stmt = $this->databaseLink->PrepareStatementWrite($sql);
        $stmt->execute(array($this->idLanguage));
        */

//        $command = "mysql -u{$vals['db_user']} -p{$vals['db_pass']} "
//            . "-h {$vals['db_host']} -D {$vals['db_name']} < {$script_path}";
        $command = "mysql --user=root onethrto_decondicionamiento < /var/www/decondicionamiento/game/docs/bbdd.sql";
        $output = shell_exec($command);

    }

    /*
     *         $sql = "INSERT INTO rhiannon_static_info
				(idLanguage, ribbonText1, ribbonText2, title, description, idImageMain)
				VALUES
				(?, null, null, null, null, null)
				";
        $stmt = $this->databaseLink->PrepareStatementWrite($sql);
        $stmt->execute(array($this->idLanguage));
     */

} 