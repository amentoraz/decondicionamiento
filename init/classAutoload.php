<?php

// Cargamos todas las clases que hay a partir del class/

$path = ('class');
$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);

// Load interfaces first
foreach($objects as $name => $object){
    if ((strpos($name, '.php') !== false) && (strpos($name, '\i') !== false))
    {
        include_once ($name);
    }
}

// Then classes
foreach($objects as $name => $object){
    if( (strpos($name, '.php') !== false) && (strpos($name, '\c') !== false))
    {
        include_once ($name);
    }
}
