<?php
include_once ($this->ruta . "/builder/DibujarMenu.class.php");
use reportes\menuIngreso\menu\Dibujar;

$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );

$esteBloque=$this->miConfigurador->getVariableConfiguracion ( 'esteBloque' );

$valorCodificado = "action=loginSso";//Es el nombre del directorio del bloque :P
$valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );

$valorCodificado .= "&bloque=loginSso";
$valorCodificado .= "&bloqueGrupo=";
$valorCodificado .= "&opcion=logout";
$valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $valorCodificado );

$enlaces['Logout'] = $directorio.'='.$valorCodificado;

$atributos ['enlaces'] = $enlaces;

$crearMenu = new Dibujar ();
echo $crearMenu->html ( $atributos );

?>