<?php
/**
 * Importante: Este script es invocado desde la clase ArmadorPagina. La información del bloque se encuentra
 * en el arreglo $esteBloque. Esto también aplica para todos los archivos que se incluyan.
 *
 * CUANDO SE NECESITE REGISTRAR OPCIONES PARA LA FUNCIÓN ready DE JQuery, SE DEBE DECLARAR EN ARCHIVOS DENOMINADOS
 * ready.js o ready.php. DICHOS ARCHIVOS DEBEN IR EN LA CARPETA script DE LOS BLOQUES PERO NO RELACIONARSE AQUI. 
 */
// Registrar los archvos js que deben incluirse

$indice=0;
$funcion[$indice++]='lib/moment.min.js';
$funcion[$indice++]='lib/jquery.min.js';
$funcion[$indice++]='fullcalendar.js';
$funcion[$indice++]='lang-all.js';
// $plugin[$indice]=true;//para bootstrap.min.js
// $funcion[$indice++]='plugin/scripts/bootstrap/bootstrap-3.3.5-dist/js/bootstrap.min.js';
// $plugin[$indice]=true;//para validator.js
// $funcion[$indice++]='plugin/scripts/bootstrap/bootstrap-3.3.5-dist/js/validator.js';
$funcion[$indice++]='juu.js';
// $embebido[$indice]=true;//para ajax.php
// $funcion[$indice++]='ajax.php';

$rutaBloque=$this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site");
$rutaSara = $rutaBloque;
if($esteBloque["grupo"]==""){
	$rutaBloque.="/blocks/".$esteBloque["nombre"];
}else{
	$rutaBloque.="/blocks/".$esteBloque["grupo"]."/".$esteBloque["nombre"];
}

foreach ($funcion as $clave=>$nombre){
	if(isset($plugin[$clave]) && $plugin[$clave]==true){
		echo "\n<script type='text/javascript' src='".$rutaSara."/".$nombre."'></script>\n";
	}elseif(isset($embebido[$clave]) && $embebido[$clave]==true){
		echo "\n<script type='text/javascript'>";
		include($nombre);
		echo "</script>\n";
	}else{
		echo "\n<script type='text/javascript' src='".$rutaBloque."/script/".$nombre."'></script>\n";
		
	}
}

/**
 * Incluir los scripts que deben registrarse como javascript pero requieren procesamiento previo de código php
 */
//include("archivoPHP con código js embebido.php");
// Procesar las funciones requeridas en ajax
// echo "\n<script type='text/javascript'>";
// 	include("sara.js.php");
// echo "\n</script>\n";
//include("ajax.php");
?>