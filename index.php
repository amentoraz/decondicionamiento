<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="color: #fe7777; background-color: #000000;">
<?php
/**
 * Created by PhpStorm.
 * User: pablo
 * Date: 13/05/15
 * Time: 10:46
 */

  include_once ("class/parsing/cParser.php");
  include_once ("class/cDatabase.php");
  include_once ("class/cPintarPantalla.php");
  include_once ("class/cCargaBBDD.php");

  include_once ("class/views/cInfoView.php");

  include_once ("class/cInfoLocalWrapper.php");
  include_once ("class/cAventuraLocalizacion.php");
  include_once ("class/cAventuraJugador.php");
  include_once ("class/cAventuraSalidas.php");


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
  echo ("<b>>> ".$_REQUEST['frase']."</b>");

  echo ("<br/>");
  echo ("<br/>");




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
  echo $arrayLugar['infoBase']['descripcion'];



  // TODO : mostrar los objetos que hay en el lugar


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