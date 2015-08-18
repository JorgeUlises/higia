<?php
/*
 * Obtener claves de valores que están codificados
 */
$claveCamposCodificados = ['periodo_actual'];
foreach ($claveCamposCodificados as $claveCampo){
	if(isset($_REQUEST[$this->miConfigurador->fabricaConexiones->crypto->codificar($claveCampo)])){
		$_REQUEST[$claveCampo] = $_REQUEST[$this->miConfigurador->fabricaConexiones->crypto->codificar($claveCampo)];
		unset($_REQUEST[$this->miConfigurador->fabricaConexiones->crypto->codificar($claveCampo)]);
	}
}

if (isset($_REQUEST['periodo_actual'])){
	$resultado = ["a"=>"b","c"=>"d"];
	
	header("Content-type: application/json");
 	$resultado = json_encode ( $resultado);
 	//echo $resultado;
 	include $this->ruta . 'script/fullCalendar/json/actividades.json';
} else {
	$resultado = ["a"=>"periodo en específico"];
	header("Content-type: application/json");
 	$resultado = json_encode ( $resultado);
 	echo $resultado;
}

// 	 	$cadenaSql = $this->sql->getCadenaSql ( 'buscarSalones', $_REQUEST[$valor] );
// 		$resultado = $esteRecursoDBO->ejecutarAcceso ( $cadenaSql, "busqueda" );
// // $resultado = ["a"=>"b","c"=>"d"];
// header("Content-type: application/json");
// $resultado = json_encode ( $resultado);
// echo $resultado;
$conexion = "salones";
$esteRecursoDBO = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );

?>

