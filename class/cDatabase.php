<?php

/*
 * 
 * Esta clase permite la conexión a la base de datos mediante PDO
 * 
 */

Class cDatabase {

    private static $hostbd;
    private static $basedatos;
    private static $dbh;
    private static $user_read;
    private static $password_read;
    private static $user_write;
    private static $password_write;
    private static $dbh_read;
    private static $dbh_write;





    public static function getInstance()
    {
        static $instance = null;
        if (null === $instance) {

            $instance = new static();

        }

        return $instance;
    }

    // Set up values for the database

    public function Configure() {
        $this->hostbd = "127.0.0.1";
        $this->basedatos = "onethrto_decondicionamiento_game";
        $this->user_read = "root";
        $this->password_read = "";
        $this->user_write = "root";
        $this->password_write = "";
    }


    public function GetRead()
    {
        return $this->dbh_read;
    }

    public function GetWrite()
    {
        return $this->dbh_write;
    }


    public function ConnectDB() {

        try {

            $this->dbh_read = new PDO("mysql:host=$this->hostbd;dbname=$this->basedatos;charset=utf8", $this->user_read, $this->password_read, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            $this->dbh_write = new PDO("mysql:host=$this->hostbd;dbname=$this->basedatos;charset=utf8", $this->user_write, $this->password_write, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

        }
        catch (PDOException $e) {
            echo ($e->getMessage());
//            print_r($e->errorInfo);
            die();
        }

    }

    function QueryRead($select) {
        try {
            return $this->dbh_read->query($select);
        }
        catch (PDOException $e) {
            print_r($e->errorInfo);
            die();
        }
    }

    function QueryWrite($select) {
        try {
            return $this->dbh_write->query($select);
        }
        catch (PDOException $e) {
            print_r($e->errorInfo);
            die();
        }
    }

    function PrepareStatementRead($string) {
        return $this->dbh_read->prepare($string);
    }

    function PrepareStatementWrite($string) {
        return $this->dbh_write->prepare($string);
    }


    function lastID() {
        try {
            return $this->dbh->lastInsertId();
        }
        catch (PDOException $e) {
            print_r($e->errorInfo);
            die();
        }

    }

    function lastIDWrite() {
        try {
            return $this->dbh_write->lastInsertId();
        }
        catch (PDOException $e) {
            print_r($e->errorInfo);
            die();
        }

    }



    function cierraBD(){
        $this->dbh_read = NULL;
        $this->dbh_write = NULL;
    }





    /**
     *  Funciones para proteger que no se pueda quitar de static
     */

    // No se puede hacer construct de una clase Singleton!
    protected function __construct()
    {
    }

    // No se puede hacer clone de una clase Singleton!
    private function __clone()
    {
    }

    // Ni tampoco wakeup
    private function __wakeup()
    {
    }






}

?>
