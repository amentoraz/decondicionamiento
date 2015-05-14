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

  include("class/parsing/cParser.php");
  include ("class/cDatabase.php");
  include ("class/cPintarPantalla.php");
  include ("class/cCargaBBDD.php");

  include ("class/cAventuraLocalizacion.php");
  include ("class/cAventuraJugador.php");


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
    <p>éeeé
    <form method="post">
        <input type="hidden" name="cargarBBDD" value="1">
        <input type="submit" value="Recargar BBDD">
    </form>
    </p>
    <hr/>
  <?php



  // Escribimos la propia acción
  echo ("<b>".$_REQUEST['frase']."</b>");

  // Vamos a parsear la accion realizada
  if (isset($_REQUEST['ejecutar_accion']))
  {
      $oParser = new cParser();
      $oParser->ParsearOracion($_REQUEST['frase']);
  }


  // Sacamos la info del jugador
  $oAventuraJugador = new cAventuraJugador($objectMySQL);
  $arrayJugador = $oAventuraJugador->GetDatosJugador(1); // A PELO!!!
print_r($arrayJugador);


  // TODO : mostrar la descripción del lugar [[[[MONTAR UN DESCRIPCIONWRAPPER PARA TODOS ESTOS]]]]
  $oAventuraLocalizacion = new cAventuraLocalizacion($objectMySQL);
  $oAventuraLocalizacion->SetIdJugador($arrayJugador['id']);
  $oAventuraLocalizacion->SetIdInstanciaLocalizacion($arrayJugador['idInstanciaLocalizacion']);
  $descripcion = $oAventuraLocalizacion->GetDescription();
  echo ("<p>".$descripcion."</p>");



  // TODO : mostrar los objetos que hay en el lugar

  // TODO : mostrar las salidas


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