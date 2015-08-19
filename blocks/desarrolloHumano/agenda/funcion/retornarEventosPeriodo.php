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
	$conexion = 'bienestar';
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	
	$cadenaSql = $this->sql->getCadenaSql ( 'buscarAgenda', '' );
	$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
	/*
	 * Esta función permite recoger los elementos con un identificador común y agrupar algunos 
	 * atributos que ya se saben que no son los mismos en un arreglo como una propiedad de la consulta
	 * de otra manera, habrá una sola fila con campos que son el arreglo de atributos diferentes.
	 */
	function unificarResultados ($resultado, $id, $atributos){
		$arreglo = array();
		$filaant = false;
		foreach ($resultado as $value => $fila){
			if($filaant[$id]==$fila[$id]){
				foreach ($atributos as $atributo){
					array_push($arreglo[count($arreglo)-1][$atributo],$fila[$atributo]);
				}
			} else {
				array_push($arreglo,$fila);
				foreach ($atributos as $atributo){
					$arreglo[count($arreglo)-1][$atributo] = array($fila[$atributo]);
				}
			}
			$filaant = $fila;
		}
		return $arreglo;
	}
	$resultado = unificarResultados($resultado,'id_agenda',['documento_persona','nombre_persona']);
	
	$respuesta['events'] = array();
	foreach ($resultado as $fila){
		array_push($respuesta['events'], array (
			'id' => $fila['id_agenda'],
			'title' => $fila['descripcion'] . ' - ' . $fila['nombre_persona'][0],
			'start' => $fila['hora_inicio'],
			'end' => $fila['hora_fin'],
			'overlap' => 'false',
			'color' => '\'#3A87AD\'',
			'nombre_persona' => $fila['nombre_persona']
		));
	}
	$respuesta['periodo'] = array(
		'start' => '2015-01-10',
		'end' => '2015-12-10'
	);
	//header("Content-type: application/json");
 	$resultado = json_encode ($respuesta);
 	
 	echo $resultado;
 	//include $this->ruta . 'script/fullCalendar/json/actividades.json';
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

?>

