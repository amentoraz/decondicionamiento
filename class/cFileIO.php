<?php

class cFileIO
{

    // Leemos y devolvemos los contenidos de un fichero

    public function ReadFileContents($file)
    {
        $myfile = fopen($file, "r") or die("No se pudo abrir el fichero!");
        $contenido = fread($myfile,filesize($file));
        fclose($myfile);
        return $contenido;
    }

}