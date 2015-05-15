<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="color: #fe7777; background-color: #000000;">
<?php

/*
 * Indice temporal en el que jugar antes de montar la pantalla real, que es parte TODO
 *
 */

  include_once ("class/parsing/cParser.php");
  include_once ("class/cDatabase.php");
  include_once("class/views/cPintarPantalla.php");
  include_once ("class/cCargaBBDD.php");

  include_once ("class/views/cInfoView.php");

  include_once ("class/cInfoLocalWrapper.php");
  include_once ("class/cAventuraLocalizacion.php");
  include_once ("class/cAventuraJugador.php");
  include_once ("class/cAventuraSalidas.php");
  include_once('class/cAventuraObjeto.php');

  // Inicializamos la base de datos
  $objectMySQL = cDatabase::GetInstance();
  $objectMySQL->Configure();
  $objectMySQL->ConnectDB();
  $sql = "SET NAMES utf8";
  $stmt = $objectMySQL->PrepareStatementWrite($sql);
  $stmt->execute();




  // Vamos a ver si nos han pedido recargar la BBDD
  if (isset($_REQUEST['cargarBBDD']))
  {
      $oCargaBBDD = new cCargaBBDD($objectMySQL);
      $oCargaBBDD->EjecutarScript();
  }

  ?>
    <p>
    <form method="post">
        <input type="hidden" name="cargarBBDD" value="1">
        <input type="submit" value="Recargar BBDD">
    </form>
    </p>
    <hr/>
  <?php




  // Sacamos la info del jugador
  $oAventuraJugador = new cAventuraJugador($objectMySQL);
  $oAventuraJugador->SetIdJugador(1); // TODO ESTO ESTA A PELO!!!
  $arrayJugador = $oAventuraJugador->GetDatosJugador();

  // TODO no habría que incrementar turno cuando se pide ayuda (y quiza tampoco cuando el sistema no entiende el comando)
  $arrayJugador['turno']++;  // Para que cuadre en pantalla y ahora la grabar
  $oAventuraJugador->ActualizarTurno($arrayJugador['turno']);



  echo ("<p style='color: #00fd00'>".$arrayJugador['nombre']." - <i>Turno ".$arrayJugador['turno']."</i></p>");

  // Escribimos la propia acción
  if (isset($_REQUEST['frase']))
  {
      cPintarPantalla::PintarAccionAnterior("<b>>> ".$_REQUEST['frase']."</b>");
  }




  // Vamos a parsear la accion realizada. Esto tiene que ir antes de nada porque puede cambiar condiciones como
  // la localizacion

  if (isset($_REQUEST['ejecutar_accion']))
  {
      $oParser = new cParser($objectMySQL);
      $oParser->SetIdInstanciaLocalizacion($arrayJugador['idInstanciaLocalizacion']);
      $oParser->SetIdJugador($arrayJugador['id']); // idJugador
      $oParser->ParsearOracion($_REQUEST['frase']);
        // Por si cambia la localizacion
      $arrayJugador = $oAventuraJugador->GetDatosJugador();
  }


  // Vamos a sacar con el wrapper toda la información de la localizacion: datos, salidas y objetos presentes
  $oInfoLocalWrapper = new cInfoLocalWrapper($objectMySQL);
  $oInfoLocalWrapper->SetIdJugador($arrayJugador['id']);
  $oInfoLocalWrapper->SetIdInstanciaLocalizacion($arrayJugador['idInstanciaLocalizacion']);
  $arrayLugar = $oInfoLocalWrapper->GetDatosBaseLugar();
  //var_dump($arrayLugar);




  // Pintamos la descripción TODO ESTO VA A UNA CLASE QUE COMPRUEBE TAMBIEN EVENTOS
  echo "<p>".$arrayLugar['infoBase']['descripcion']."</p>";


  // TODO : sacar esto a una clase
  for ($i = 0; $i < count($arrayLugar['objetos']); $i++)
  {
      $textoGenero =  ($arrayLugar['objetos'][$i]['femenino'] == 1) ? "una" : "un";
      if ($i == 0)
      {
          cPintarPantalla::Pintar(" Puedes ver además ".$textoGenero." ".$arrayLugar['objetos'][$i]['referencia']);
      } else {
          if (($i+1) < count($arrayLugar['objetos']))
          {
              cPintarPantalla::Pintar(", ".$textoGenero." ".$arrayLugar['objetos'][$i]['referencia']);
          } else {
              cPintarPantalla::Pintar(" y ".$textoGenero." ".$arrayLugar['objetos'][$i]['referencia']);
          }
      }
  }
  if ($i > 0) { echo ("."); };


  // Pintamos las salidas
  $oInfoView = new cInfoView();
  $oInfoView->PrintExits($arrayLugar);





  // TODO - que no te deja meter una orden vacía (javascript)

?>


    <br/>

    <p>¿Qué quieres hacer?</p>

    <form method="post" action="index.php">
        <input type="text" name="frase" size="80" autofocus></textarea>
        <p>
            <input type="hidden" name="ejecutar_accion" value="1">
            <input type="submit" value="Realizar acción">
        </p>
    </form>

</body>
</html>