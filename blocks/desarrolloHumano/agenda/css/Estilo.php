<?php

$indice = 0;

$estilo [$indice++] = "lib/cupertino/jquery-ui.min.css";
//$plugin[$indice]=true;//para bootstrap.min.css, hasta que se actualice jquery en el core
$estilo [$indice++] = "lib/jquery-ui-bootstrap/jquery.ui.theme.css";
$estilo [$indice++] = "fullcalendar.css";
$atributoEspecial[$indice]='media';
$valorEspecial[$indice]='print';
$estilo [$indice++] = "fullcalendar.print.css";
// $plugin[$indice]=true;//para bootstrap.min.css
// $estilo [$indice++] = "plugin/scripts/bootstrap/bootstrap-3.3.5-dist/css/bootstrap.min.css";

$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "host" );
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion ( "site" );
$rutaSara = $rutaBloque;
if ($unBloque ["grupo"] == "") {
	$rutaBloque .= "/blocks/" . $unBloque ["nombre"];
} else {
	$rutaBloque .= "/blocks/" . $unBloque ["grupo"] . "/" . $unBloque ["nombre"];
}

foreach ( $estilo as $clave=>$nombre ) {
	if (isset ( $plugin [$clave] ) && $plugin [$clave] == true)	{
		echo "\n<link rel='stylesheet' type='text/css' href='" . $rutaSara . "/" . $nombre . "'>\n";
	} elseif (isset ( $atributoEspecial [$clave] ) && isset ( $valorEspecial [$clave] ))	{
		echo "\n<link rel='stylesheet' type='text/css' " . $atributoEspecial [$clave] . "='" . $valorEspecial [$clave] . "' href='" . $rutaBloque . "/css/" . $nombre . "'>\n";
	} else	{
		echo "\n<link rel='stylesheet' type='text/css' href='" . $rutaBloque . "/css/" . $nombre . "'>\n";
	}
}
?>

