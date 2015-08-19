<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class registrarForm {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miSql;
	function __construct($lenguaje, $formulario, $sql) {
		$this->miConfigurador = \Configurador::singleton ();
		
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		
		$this->lenguaje = $lenguaje;
		
		$this->miFormulario = $formulario;
		
		$this->miSql = $sql;
	}
	function miForm() {
		
		// Rescatar los datos de este bloque
		$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
		$miPaginaActual = $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		
		$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
		$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
		$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
		
		$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "host" );
		$rutaBloque .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/";
		$rutaBloque .= $esteBloque ['grupo'] . '/' . $esteBloque ['nombre'];
		
		// ---------------- SECCION: Parámetros Globales del Formulario ----------------------------------
		/**
		 * Atributos que deben ser aplicados a todos los controles de este formulario.
		 * Se utiliza un arreglo
		 * independiente debido a que los atributos individuales se reinician cada vez que se declara un campo.
		 *
		 * Si se utiliza esta técnica es necesario realizar un mezcla entre este arreglo y el específico en cada control:
		 * $atributos= array_merge($atributos,$atributosGlobales);
		 */
		
		$atributosGlobales ['campoSeguro'] = 'true';

		$_REQUEST ['tiempo'] = time();
		
		// ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------
		$esteCampo = $esteBloque ['nombre'];
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;
		// Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
		$atributos ['tipoFormulario'] = 'multipart/form-data';
		// Si no se coloca, entonces toma el valor predeterminado 'POST'
		$atributos ['metodo'] = 'POST';
		// Si no se coloca, entonces toma el valor predeterminado 'index.php' (Recomendado)
		$atributos ['action'] = 'index.php';
		// $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo );
		// Si no se coloca, entonces toma el valor predeterminado.
		$atributos ['estilo'] = '';
		$atributos ['marco'] = true;
		$tab = 1;
		// ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
		// ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
		$atributos ['tipoEtiqueta'] = 'inicio';
		echo $this->miFormulario->formulario($atributos);
		unset($atributos);
		// ---------------- SECCION: Controles del Formulario -----------------------------------------------
		
		// $conexion = "salones";
		// $conexionDBSalones = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
		// $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("buscarSalones");
		// $matrizItems = $conexionDBSalones->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
// 		var_dump($matrizItems);

		// ----------------INICIAR EL CALENDARIO -----------------------------------------------------------
		$esteCampo = "Calendario1";
		$atributos ['id'] = $esteCampo;
		$contenidoCalendario = $this->miFormulario->calendario($atributos);
		unset($atributos);
		// ----------------FIN EL CALENDARIO -----------------------------------------------------------
		
		?>
		<div class="container-fluid">
			<div class="row-fluid">
			  <div class="col-sm-2">
			  	<div class="panel-group" id="accordion">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion"
									href="#collapseOne"><span
									class="glyphicon glyphicon-folder-open"> </span>Medicina</a>
							</h4>
						</div>
						<div id="collapseOne" class="panel-collapse collapse in">
							<div class="panel-body">
								<div class='row-fluid'>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#collapseTwo"
													href="#collapseInInterno">Profesional</a>
											</h4>
										</div>
										<div id="collapseInInterno" class="panel-collapse collapse in">
											<div class="panel-body">
												<div class='row-fluid' role="form">
												 	<div class="radio">
													  <label><input type="radio" name="optradio" value="">Juan Herrera</label>
													</div>
													<div class="radio">
													  <label><input type="radio" name="optradio" value="">Juan Hernandez</label>
													</div>
													<div class="radio">
													  <label><input type="radio" name="optradio" value="">Juan Fernandez</label>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#collapseTwo"
													href="#collapseInInterno2">Sede</a>
											</h4>
										</div>
										<div id="collapseInInterno2" class="panel-collapse collapse in">
											<div class="panel-body">
												<div class='row-fluid'>
												 	<div class="radio">
													  <label><input type="radio" name="optradio2" value="">Ingeniería</label>
													</div>
													<div class="radio">
													  <label><input type="radio" name="optradio2" value="">Vivero</label>
													</div>
													<div class="radio disabled">
													  <label><input type="radio" name="optradio2" value="" disabled>Marcarena A</label>
													</div>
													<div class="radio">
													  <label><input type="radio" name="optradio2" value="">Marcarena B</label>
													</div>
													<div class="radio">
													  <label><input type="radio" name="optradio2" value="">Tecnológica</label>
													</div>
												</div>
											</div>
										</div>
									</div>								
								</div>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion"
									href="#collapseTwo"><span class="glyphicon glyphicon-th"> </span>Odontología</a>
							</h4>
						</div>
						<div id="collapseTwo" class="panel-collapse collapse">
							<div class="panel-body">
								<div class='row-fluid'>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#collapseTwo"
													href="#collapseInInterno">Profesional</a>
											</h4>
										</div>
										<div id="collapseInInterno" class="panel-collapse collapse in">
											<div class="panel-body">
												<div class='row-fluid'>
												 	<div class="checkbox">
													  <label><input type="checkbox" value="">Juan Herrera</label>
													</div>
													<div class="checkbox">
													  <label><input type="checkbox" value="">Juan Hernandez</label>
													</div>
													<div class="checkbox disabled">
													  <label><input type="checkbox" value="" disabled>Juan Fernandez</label>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#collapseTwo"
													href="#collapseInInterno2">Sede</a>
											</h4>
										</div>
										<div id="collapseInInterno2" class="panel-collapse collapse in">
											<div class="panel-body">
												<div class='row-fluid'>
												 	<div class="checkbox">
													  <label><input type="checkbox" value="">Ingeniería</label>
													</div>
													<div class="checkbox">
													  <label><input type="checkbox" value="">Vivero</label>
													</div>
													<div class="checkbox disabled">
													  <label><input type="checkbox" value="" disabled>Marcarena A</label>
													</div>
													<div class="checkbox">
													  <label><input type="checkbox" value="">Marcarena B</label>
													</div>
													<div class="checkbox">
													  <label><input type="checkbox" value="">Tecnológica</label>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion"
									href="#collapseThree"><span class="glyphicon glyphicon-list"> </span>Psicología</a>
							</h4>
						</div>
						<div id="collapseThree" class="panel-collapse collapse">
							<div class="panel-body">
								<div class='row-fluid'>
									
								</div>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion"
									href="#collapseThree"><span class="glyphicon glyphicon-list"> </span>Fisioterapia</a>
							</h4>
						</div>
						<div id="collapseThree" class="panel-collapse collapse">
							<div class="panel-body">
								<div class='row-fluid'>
									
								</div>
							</div>
						</div>
					</div>
				</div>
			  </div>
			  <div class="col-sm-10"><?php echo $contenidoCalendario ?></div>
			</div>
		</div>
		<?php
		
		// ---------------- FIN SECCION: Controles del Formulario -----------------------------------------------
		// ----------------FINALIZAR EL FORMULARIO ------------------------------------------------------------
		$atributos ['marco'] = true;
		$atributos ['tipoEtiqueta'] = 'fin';
		echo $this->miFormulario->formulario($atributos);
		
	}
}

$miSeleccionador = new registrarForm ( $this->lenguaje, $this->miFormulario, $this->sql );

$miSeleccionador->miForm ();
?>