<?php
include_once ($this->ruta . "/builder/DibujarMenu.class.php");
use gui\menuPrincipal\builder\Dibujar;
// include_once ($this -> ruta . 'funcion/GetLink.php');
// use gui\menuPrincipal\funcion\GetLink;

$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );

$esteBloque=$this->miConfigurador->getVariableConfiguracion ( 'esteBloque' );

$paginas = [ 
	'modalidad',
	'agenda',
	'profesional',
	'cita',
	'reportes',
	'usuario'
];

$enlaces = array ();

foreach ( $paginas as $pagina ) {
	$enlace = 'pagina=' . $pagina;
	$enlace = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );
	//$enlace = GetLink::obtener($pagina);
	$nombrePagina = $this->lenguaje->getCadena ( $pagina );
	$enlaces[$nombrePagina] = $enlace;
}

$enlaces[$this->lenguaje->getCadena ( 'sesion' )]=array(
	'usuario registrado'=>'#',
	'logout'=>'#',	
);

$atributos ['enlaces'] = $enlaces;

$crearMenu = new Dibujar ();
echo $crearMenu->html ( $atributos );

?>