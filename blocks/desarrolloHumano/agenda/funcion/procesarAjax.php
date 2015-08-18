<?php

use docentes\planDeTrabajo\Sql;
//$conexion = "inventarios";
//$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

switch ($_REQUEST ['funcion']) { 
	
	case 'consultarAgenda':		
		include 'retornarEventosPeriodo.php';		
		break;
	case 'otraCosa':
		break;
}

?>
