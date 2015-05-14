<?php

include_once('iParserVerbal.php');

class cParserVerbalAYUDA implements iParserVerbal {

    private $idInstanciaLocalizacion;
    private $idJugador;
    public function SetIdJugador($value) { $this->idJugador = $value; }
    public function SetIdInstanciaLocalizacion($value) { $this->idInstanciaLocalizacion = $value; }


    private function PintarMensajeSalidas()
    {
        $msg = ("Si escribes \"salidas\" sin más, se te informará de las posibles direcciones que puedes tomar desde tu localización actual.");
        cPintarPantalla::Pintar($msg);
    }

    private function PintarMensajeAyuda()
    {
        $msg = ("Puedes desplazarte entre localizaciones escribiendo simplemente la dirección en que te desplazas (p.ej norte, sur, arriba, entrar). Por lo demás, ");
        $msg .= ("intenta escribir oraciones sencillas formadas por un verbo en infinitivo y un objeto directo. Por ejemplo, \"coger taza\" o \"examinar pantalla\".");
        $msg .= (" Aunque hay diversidad de verbos que puede funcionar para distintas acciones, hay algunos como \"coger\", \"dejar\", \"examinar\", \"salidas\" o \"usar\" que te pueden");
        $msg .= (" resultar útiles muy a menudo. También puedes escribir \"ayuda [tema]\" si quieres consultar algún tema en particular.");
        $msg .= (" Además, puedes encadenar acciones mediante oraciones conjuntivas (ver \"ayuda conjuntivas\") ");
        cPintarPantalla::Pintar($msg);
    }


    private function PintarMensajeCoger()
    {
        $msg = ("La acción \"coger\" te permite tomar un objeto, que salvo casos excepcionales pasará a formar parte de tu inventario. ");
        $msg .= "Si quieres ver tus posesiones, puedes usar el comando \"inventario\" a secas. ";
        cPintarPantalla::Pintar($msg);
    }

    private function PintarMensajeDejar()
    {
        $msg = ("La acción \"dejar\" te permite dejar un objeto que poseas en la habitación en la que te encuentres. ");
        cPintarPantalla::Pintar($msg);
    }

    private function PintarMensajeInventario()
    {
        $msg = ("El comando \"inventario\" te mostrará un listado de lo que llevas contigo en este momento. ");
        cPintarPantalla::Pintar($msg);
    }

    private function PintarMensajeExaminar()
    {
        $msg = "El verbo \"examinar\" sirve para obtener detalles específicos de un escenario o de un objeto que se encuentre en él o que tú poseas. Sirve además ";
        $msg .= "como sinónimo del verbo leer. Así, \"examinar libro\" o \"examinar botas\" te darán detalles acerca de ambos.";
        cPintarPantalla::Pintar($msg);
    }

    private function PintarMensajeConjuntivas()
    {
        $msg = "Puedes indicar más de una acción separándola por una conjunción como la letra \"y\" ";
        $msg .= "u otras variantes temporales como \"después\" o \"luego\". Así por ejemplo, puedes indicar que quieres \"dejar silla y sentarme\",  ";
        $msg .= "o \"dejar silla y después sentarme\", ";
        $msg .= "con lo que realizarás ambas acciones una detrás de otra como si hubieras escrito por separado ambas oraciones.";
        cPintarPantalla::Pintar($msg);
    }


    public function Procesar($oracion)
    {
        $oracion = trim($oracion);

        if (strtoupper($oracion) == 'AYUDA')
        {
            // Esto es que ha pedido ayuda sin más
            $this->PintarMensajeAyuda();
            return true;
        } else {
            // Vamos a ver si está pidiendo ayuda sobre algo en concreto
            if (strlen($oracion) > 6)
            {
                $predicado = trim(substr($oracion, 6)); // Esto debería extraer lo que venga después
                $predicado = strtoupper($predicado);
                switch($predicado)
                {
                    case 'EXAMINAR' :   echo ("[EXAM]");
                                        $this->PintarMensajeExaminar();
                                        break;
                    case 'CONJUNCION' :
                    case 'CONJUNCIONES' :
                    case 'CONJUNCIóN' :
                    case 'CONJUNCIÓN' :
                    case 'CONJUNTIVAS' : $this->PintarMensajeConjuntivas();
                                        break;

                    case 'COGER' :      $this->PintarMensajeCoger();
                                        break;
                    case 'DEJAR' :      $this->PintarMensajeDejar();
                                        break;
                    case 'INVENTARIO' : $this->PintarMensajeInventario();
                                        break;
                    case 'SALIDAS' :    $this->PintarMensajeSalidas();
                                        break;
                }
            }
        }

    }

} 