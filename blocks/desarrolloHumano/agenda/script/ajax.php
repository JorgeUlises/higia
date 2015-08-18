<?php
/**
 *
 * Los datos del bloque se encuentran en el arreglo $esteBloque.
 */

// URL base
$url = $this->miConfigurador->getVariableConfiguracion("host");
$url .= $this->miConfigurador->getVariableConfiguracion("site");
$url .= "/index.php?";

// Variables
$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar .= "&procesarAjax=true";
$cadenaACodificar .= "&action=index.php";
$cadenaACodificar .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar .= $cadenaACodificar . "&funcion=consultarDependencia";
$cadenaACodificar .= "&tiempo=" . $_REQUEST ['tiempo'];
// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar, $enlace);
// URL definitiva
$peticion1 = $url . $cadena;

?>
<script type='text/javascript'>

function consultarDependencia() {
	$.ajax({
    	url: "<?php echo $peticion1 ?>",
        dataType: "json",
        data: {
          	"<?php echo $this->miConfigurador->fabricaConexiones->crypto->codificar('valor') ?>" : 'Cadena Valor'//$("#<?php echo $this->campoSeguro('sede') ?>").val()
        },
        success: function (data) {
			console.log(data);
        }
    });
};

</script>

