<?php
if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
}

class registrarForm {

    var $miConfigurador;
    var $lenguaje;
    var $miFormulario;
    var $miSql;

    function __construct($lenguaje, $formulario, $sql) {
        $this->miConfigurador = \Configurador::singleton();

        $this->miConfigurador->fabricaConexiones->setRecursoDB('principal');

        $this->lenguaje = $lenguaje;

        $this->miFormulario = $formulario;

        $this->miSql = $sql;
    }

    function miForm() {

// Rescatar los datos de este bloque
        $esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

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

// -------------------------------------------------------------------------------------------------
        $conexion = "estructura";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        $conexion = "docentes";
        $esteRecursoDBO = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

// Limpia Items Tabla temporal
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
// ---------------- SECCION: Controles del Formulario -----------------------------------------------

        $esteCampo = "marcoDatosBasicos";
        $atributos ['id'] = $esteCampo;
        $atributos ["estilo"] = "jqueryui";
        $atributos ['tipoEtiqueta'] = 'inicio';
        $atributos ["leyenda"] = "Criterios de Búsqueda";
        echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);

        $esteCampo = "AgrupacionDisponibilidad";
        $atributos ['id'] = $esteCampo;
        $atributos ['leyenda'] = "Primer Filtro";
        echo $this->miFormulario->agrupacion('inicio', $atributos);
        {


// ---------------------- CONTROL LISTA DESPLEGABLE ---------------------//
            $esteCampo = "sede";
            $atributos ['nombre'] = $esteCampo;
            $atributos ['id'] = $esteCampo;
            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
            $atributos ["etiquetaObligatorio"] = false;
            $atributos ['tab'] = $tab ++;
            $atributos ['seleccion'] = - 1;
            $atributos ['anchoEtiqueta'] = 280;
            $atributos ['evento'] = '';
            if (isset($_REQUEST [$esteCampo])) {
                $atributos ['valor'] = $_REQUEST [$esteCampo];
            } else {
                $atributos ['valor'] = '';
            }
            $atributos ['deshabilitado'] = false;
            $atributos ['columnas'] = 1;
            $atributos ['tamanno'] = 1;
            $atributos ['ajax_function'] = "";
            $atributos ['ajax_control'] = $esteCampo;
            $atributos ['estilo'] = "jqueryui";
            $atributos ['validar'] = "";
            $atributos ['limitar'] = 1;
            $atributos ['anchoCaja'] = 49;
            $atributos ['miEvento'] = '';
            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("sede");
            $matrizItems = array(
                array(
                    0,
                    ' '
                )
            );
            $matrizItems = $esteRecursoDBO->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
            $atributos ['matrizItems'] = $matrizItems;
// $atributos['miniRegistro']=;
// $atributos ['baseDatos'] = "inventarios";
// $atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "clase_entrada" );
// Aplica atributos globales al control
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->campoCuadroLista($atributos);
            unset($atributos);

            //----------------------------------------------------
            $esteCampo = "dependencia";
            $atributos ['columnas'] = 1;
            $atributos ['nombre'] = $esteCampo;
            $atributos ['id'] = $esteCampo;
            $atributos ['evento'] = '';
            $atributos ['deshabilitado'] = false;
            $atributos ["etiquetaObligatorio"] = false;
            $atributos ['tab'] = $tab;
            $atributos ['tamanno'] = 1;
            $atributos ['estilo'] = 'jqueryui';
            $atributos ['validar'] = '';
            $atributos ['limitar'] = 1;
            $atributos ['anchoCaja'] = 70;
            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
            $atributos ['anchoEtiqueta'] = 280;
            if (isset($_REQUEST [$esteCampo])) {
                $atributos ['seleccion'] = $_REQUEST [$esteCampo];
            } else {
                $atributos ['seleccion'] = - 1;
            }
// 					$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "dependencias" );

            $matrizItems = array(
                array(
                    ' ',
                    'Seleccion ... '
                )
            );


            $atributos ['matrizItems'] = $matrizItems;

            // Utilizar lo siguiente cuando no se pase un arreglo:
            // $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
            // $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
            $tab ++;
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->campoCuadroLista($atributos);
            unset($atributos);


//---------------------------------------------------------------------------------

            $esteCampo = "nombreFuncionario";
            $atributos ['nombre'] = $esteCampo;
            $atributos ['id'] = $esteCampo;
            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
            $atributos ["etiquetaObligatorio"] = false;
            $atributos ['tab'] = $tab ++;
            $atributos ['seleccion'] = - 1;
            $atributos ['anchoEtiqueta'] = 280;
            $atributos ['evento'] = '';
            if (isset($_REQUEST [$esteCampo])) {
                $atributos ['valor'] = $_REQUEST [$esteCampo];
            } else {
                $atributos ['valor'] = '';
            }
            $atributos ['deshabilitado'] = false;
            $atributos ['columnas'] = 1;
            $atributos ['tamanno'] = 1;
            $atributos ['ajax_function'] = "";
            $atributos ['ajax_control'] = $esteCampo;
            $atributos ['estilo'] = "jqueryui";
            $atributos ['validar'] = "";
            $atributos ['limitar'] = 1;
            $atributos ['anchoCaja'] = 49;
            $atributos ['miEvento'] = '';
            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("funcionarios");
            $matrizItems = array(
                array(
                    0,
                    ' '
                )
            );
            $matrizItems = $esteRecursoDBO->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
            $atributos ['matrizItems'] = $matrizItems;
// $atributos['miniRegistro']=;
// $atributos ['baseDatos'] = "inventarios";
// $atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "clase_entrada" );
// Aplica atributos globales al control
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->campoCuadroLista($atributos);
            unset($atributos);
        }

        echo $this->miFormulario->agrupacion('fin');

        $esteCampo = "AgrupacionDisponibilidad";
        $atributos ['id'] = $esteCampo;
        $atributos ['leyenda'] = "Segundo Filtro";
        echo $this->miFormulario->agrupacion('inicio', $atributos);
        {

//---------------------- CONTROL LISTA DESPLEGABLE ----------------------//
            $esteCampo = "selec_tipoConsulta";
            $atributos ['nombre'] = $esteCampo;
            $atributos ['id'] = $esteCampo;
            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
            $atributos ["etiquetaObligatorio"] = true;
            $atributos ['tab'] = $tab ++;
            $atributos ['seleccion'] = - 1;
            $atributos ['anchoEtiqueta'] = 310;
            $atributos ['evento'] = '';
            if (isset($_REQUEST [$esteCampo])) {
                $atributos ['valor'] = $_REQUEST [$esteCampo];
            } else {
                $atributos ['valor'] = '';
            }
            $atributos ['deshabilitado'] = false;
            $atributos ['columnas'] = 1;
            $atributos ['tamanno'] = 1;
            $atributos ['ajax_function'] = "";
            $atributos ['ajax_control'] = $esteCampo;
            $atributos ['estilo'] = "jqueryui";
            $atributos ['validar'] = "required";
            $atributos ['limitar'] = 1;
            $atributos ['anchoCaja'] = 49;
            $atributos ['miEvento'] = '';
            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipoConsulta");
            $matrizItems = array(
                array(
                    0,
                    ' '
                )
            );
            $matrizItems = $esteRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
            $atributos ['matrizItems'] = $matrizItems;
// Aplica atributos globales al control
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->campoCuadroLista($atributos);
            unset($atributos);
        }

        echo $this->miFormulario->agrupacion('fin');

        $atributos ["id"] = "agrupacionCriterios";
        $atributos ["estiloEnLinea"] = "display:none";
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->division("inicio", $atributos);
        unset($atributos);
        {
            $esteCampo = "AgrupacionEntrada";
            $atributos ['id'] = $esteCampo;
            $atributos ['leyenda'] = "Criterios de Búsqueda";
            echo $this->miFormulario->agrupacion('inicio', $atributos); {

                $atributos ["id"] = "numero_entradaD";
                $atributos ["estiloEnLinea"] = "display:none";
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->division("inicio", $atributos);
                unset($atributos);
                {
                    // ---- Control de Lista desplegable -----//
                    $esteCampo = 'numero_entrada';
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['id'] = $esteCampo;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ["etiquetaObligatorio"] = false;
                    $atributos ['tab'] = $tab ++;
                    $atributos ['seleccion'] = - 1;
                    $atributos ['anchoEtiqueta'] = 220;
                    $atributos ['evento'] = '';
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['deshabilitado'] = false;
                    $atributos ['columnas'] = 2;
                    $atributos ['tamanno'] = 1;
                    $atributos ['ajax_function'] = "";
                    $atributos ['ajax_control'] = $esteCampo;
                    $atributos ['estilo'] = "jqueryui";
                    $atributos ['validar'] = "";
                    $atributos ['limitar'] = true;
                    $atributos ['anchoCaja'] = 24;
                    $atributos ['miEvento'] = '';
                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("buscar_entradas");
                    $matrizItems = $esteRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");

                    $arreglo = array(
                        array(
                            '',
                            'Sin Entradas Registradas'
                        )
                    );

                    $matrizItems = $matrizItems[0][0] != '' ? $matrizItems : $arreglo;
                    $atributos ['matrizItems'] = $matrizItems;
                    // $atributos['miniRegistro']=;
                    $atributos ['baseDatos'] = "inventarios";
                    // $atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "clase_entrada" );
                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);
                }
                echo $this->miFormulario->division("fin");
                unset($atributos);


                // ---- Control de Lista desplegable -----//
                $atributos ["id"] = "vigencia_entradaD";
                $atributos ["estiloEnLinea"] = "display:none";
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->division("inicio", $atributos);
                unset($atributos);
                {
                    $esteCampo = 'vigencia_entrada';
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['id'] = $esteCampo;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ["etiquetaObligatorio"] = false;
                    $atributos ['tab'] = $tab ++;
                    $atributos ['seleccion'] = - 1;
                    $atributos ['anchoEtiqueta'] = 220;
                    $atributos ['evento'] = '';
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['deshabilitado'] = false;
                    $atributos ['columnas'] = 2;
                    $atributos ['tamanno'] = 1;
                    $atributos ['ajax_function'] = "";
                    $atributos ['ajax_control'] = $esteCampo;
                    $atributos ['estilo'] = "jqueryui";
                    $atributos ['validar'] = "";
                    $atributos ['limitar'] = true;
                    $atributos ['anchoCaja'] = 24;
                    $atributos ['miEvento'] = '';
                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("vigencia_entrada");
                    $matrizItems = $esteRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");

                    $arreglo = array(
                        array(
                            '',
                            'Sin Entradas Registradas'
                        )
                    );


                    $matrizItems = $matrizItems[0][0] != '' ? $matrizItems : $arreglo;
                    $atributos ['matrizItems'] = $matrizItems;
                    // $atributos['miniRegistro']=;
                    $atributos ['baseDatos'] = "inventarios";
                    // $atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "clase_entrada" );
                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);
                }
                echo $this->miFormulario->division("fin");
                unset($atributos);



                //------- control lista desplegable ---------------- //
                $atributos ["id"] = "proveedorD";
                $atributos ["estiloEnLinea"] = "display:none";
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->division("inicio", $atributos);
                unset($atributos);
                {
                    $esteCampo = "proveedor";
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['id'] = $esteCampo;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ["etiquetaObligatorio"] = false;
                    $atributos ['tab'] = $tab ++;
                    $atributos ['seleccion'] = - 1;
                    $atributos ['anchoEtiqueta'] = 220;
                    $atributos ['evento'] = '';
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['deshabilitado'] = false;
                    $atributos ['columnas'] = 1;
                    $atributos ['tamanno'] = 1;
                    $atributos ['ajax_function'] = "";
                    $atributos ['ajax_control'] = $esteCampo;
                    $atributos ['estilo'] = "jqueryui";
                    $atributos ['validar'] = "";
                    $atributos ['limitar'] = 1;
                    $atributos ['anchoCaja'] = 49;
                    $atributos ['miEvento'] = '';
                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("proveedores");
                    $matrizItems = array(
                        array(
                            0,
                            ' '
                        )
                    );
                    $matrizItems = $esteRecursoDBO->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
                    $atributos ['matrizItems'] = $matrizItems;
// Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);
                }
                echo $this->miFormulario->division("fin");
                unset($atributos);

                $atributos ["id"] = "tipo_entradaD";
                $atributos ["estiloEnLinea"] = "display:none";
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->division("inicio", $atributos);
                unset($atributos);
                {
                    $esteCampo = "tipo_entrada";
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['id'] = $esteCampo;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ["etiquetaObligatorio"] = false;
                    $atributos ['tab'] = $tab ++;
                    $atributos ['seleccion'] = - 1;
                    $atributos ['anchoEtiqueta'] = 220;
                    $atributos ['evento'] = '';
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['deshabilitado'] = false;
                    $atributos ['columnas'] = 1;
                    $atributos ['tamanno'] = 1;
                    $atributos ['ajax_function'] = "";
                    $atributos ['ajax_control'] = $esteCampo;
                    $atributos ['estilo'] = "jqueryui";
                    $atributos ['validar'] = "";
                    $atributos ['limitar'] = 1;
                    $atributos ['anchoCaja'] = 49;
                    $atributos ['miEvento'] = '';
                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("clase_entrada");
                    $matrizItems = array(
                        array(
                            0,
                            ' '
                        )
                    );
                    $matrizItems = $esteRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
                    $atributos ['matrizItems'] = $matrizItems;
// Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);
                }
                echo $this->miFormulario->division("fin");
                unset($atributos);
                //--------------------- fin agrupacion 1----------------------------//
                // ---- Control de Lista desplegable -----//
                $atributos ["id"] = "numero_salidaD";
                $atributos ["estiloEnLinea"] = "display:none";
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->division("inicio", $atributos);
                unset($atributos);
                {
                    $esteCampo = 'numero_salida';
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['id'] = $esteCampo;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ["etiquetaObligatorio"] = false;
                    $atributos ['tab'] = $tab ++;
                    $atributos ['seleccion'] = - 1;
                    $atributos ['anchoEtiqueta'] = 220;
                    $atributos ['evento'] = '';
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['deshabilitado'] = false;
                    $atributos ['columnas'] = 2;
                    $atributos ['tamanno'] = 1;
                    $atributos ['ajax_function'] = "";
                    $atributos ['ajax_control'] = $esteCampo;
                    $atributos ['estilo'] = "jqueryui";
                    $atributos ['validar'] = "";
                    $atributos ['limitar'] = true;
                    $atributos ['anchoCaja'] = 24;
                    $atributos ['miEvento'] = '';
                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("buscar_salidas");
                    $matrizItems = $esteRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");

                    $arreglo = array(
                        array(
                            '',
                            'Sin Entradas Registradas'
                        )
                    );

                    $matrizItems = $matrizItems[0][0] != '' ? $matrizItems : $arreglo;
                    $atributos ['matrizItems'] = $matrizItems;
                    // $atributos['miniRegistro']=;
                    // $atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "clase_entrada" );
                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);
                }
                echo $this->miFormulario->division("fin");
                unset($atributos);
                // ---- Control de Lista desplegable -----//
                $atributos ["id"] = "vigencia_salidaD";
                $atributos ["estiloEnLinea"] = "display:none";
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->division("inicio", $atributos);
                unset($atributos);
                {
                    $esteCampo = 'vigencia_salida';
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['id'] = $esteCampo;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ["etiquetaObligatorio"] = false;
                    $atributos ['tab'] = $tab ++;
                    $atributos ['seleccion'] = - 1;
                    $atributos ['anchoEtiqueta'] = 220;
                    $atributos ['evento'] = '';
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['deshabilitado'] = false;
                    $atributos ['columnas'] = 2;
                    $atributos ['tamanno'] = 1;
                    $atributos ['ajax_function'] = "";
                    $atributos ['ajax_control'] = $esteCampo;
                    $atributos ['estilo'] = "jqueryui";
                    $atributos ['validar'] = "";
                    $atributos ['limitar'] = true;
                    $atributos ['anchoCaja'] = 24;
                    $atributos ['miEvento'] = '';
                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("vigencia_salida");
                    $matrizItems = $esteRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");

                    $arreglo = array(
                        array(
                            '',
                            'Sin Entradas Registradas'
                        )
                    );


                    $matrizItems = $matrizItems[0][0] != '' ? $matrizItems : $arreglo;
                    $atributos ['matrizItems'] = $matrizItems;
                    // $atributos['miniRegistro']=;
                    // $atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "clase_entrada" );
                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);
                }
                echo $this->miFormulario->division("fin");
                unset($atributos);
//------------------------ FIN AGRUPACION 2 --------------------------------------//
                ////--------Agrupacion Elementos ---------------///
                $atributos ["id"] = "numero_placaD";
                $atributos ["estiloEnLinea"] = "display:none";
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->division("inicio", $atributos);
                unset($atributos);
                {
                    $esteCampo = 'numero_placa';
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['id'] = $esteCampo;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ["etiquetaObligatorio"] = false;
                    $atributos ['tab'] = $tab ++;
                    $atributos ['seleccion'] = - 1;
                    $atributos ['anchoEtiqueta'] = 220;
                    $atributos ['evento'] = '';
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['deshabilitado'] = false;
                    $atributos ['columnas'] = 2;
                    $atributos ['tamanno'] = 1;
                    $atributos ['ajax_function'] = "";
                    $atributos ['ajax_control'] = $esteCampo;
                    $atributos ['estilo'] = "jqueryui";
                    $atributos ['validar'] = "";
                    $atributos ['limitar'] = true;
                    $atributos ['anchoCaja'] = 24;
                    $atributos ['miEvento'] = '';
                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("buscar_placa");
                    $matrizItems = $esteRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");

                    $arreglo = array(
                        array(
                            '',
                            'Sin Entradas Registradas'
                        )
                    );

                    $matrizItems = $matrizItems[0][0] != '' ? $matrizItems : $arreglo;
                    $atributos ['matrizItems'] = $matrizItems;
                    // $atributos['miniRegistro']=;
                    $atributos ['baseDatos'] = "inventarios";
                    // $atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "clase_entrada" );
                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);
                }
                echo $this->miFormulario->division("fin");
                unset($atributos);
                ///-----------------FIN LISTA DESPLEGABLE ------------------------------------//
                $atributos ["id"] = "numero_serieD";
                $atributos ["estiloEnLinea"] = "display:none";
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->division("inicio", $atributos);
                unset($atributos);
                {
                    $esteCampo = 'numero_serie';
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['id'] = $esteCampo;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ["etiquetaObligatorio"] = false;
                    $atributos ['tab'] = $tab ++;
                    $atributos ['seleccion'] = - 1;
                    $atributos ['anchoEtiqueta'] = 220;
                    $atributos ['evento'] = '';
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['deshabilitado'] = false;
                    $atributos ['columnas'] = 2;
                    $atributos ['tamanno'] = 1;
                    $atributos ['ajax_function'] = "";
                    $atributos ['ajax_control'] = $esteCampo;
                    $atributos ['estilo'] = "jqueryui";
                    $atributos ['validar'] = "";
                    $atributos ['limitar'] = true;
                    $atributos ['anchoCaja'] = 24;
                    $atributos ['miEvento'] = '';
                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("buscar_serie");
                    $matrizItems = $esteRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");

                    $arreglo = array(
                        array(
                            '',
                            'Sin Entradas Registradas'
                        )
                    );

                    $matrizItems = $matrizItems[0][0] != '' ? $matrizItems : $arreglo;
                    $atributos ['matrizItems'] = $matrizItems;
                    // $atributos['miniRegistro']=;
                    // $atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "clase_entrada" );
                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);
                }
                echo $this->miFormulario->division("fin");
                unset($atributos);

// ---- agrupación para las tipologías de elementos ------- //


                $atributos ["id"] = "IDbajaD";
                $atributos ["estiloEnLinea"] = "display:none";
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->division("inicio", $atributos);
                unset($atributos); {
                    $esteCampo = 'IDbaja';
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['id'] = $esteCampo;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ["etiquetaObligatorio"] = false;
                    $atributos ['tab'] = $tab ++;
                    $atributos ['seleccion'] = - 1;
                    $atributos ['anchoEtiqueta'] = 220;
                    $atributos ['evento'] = '';
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['deshabilitado'] = false;
                    $atributos ['columnas'] = 2;
                    $atributos ['tamanno'] = 1;
                    $atributos ['ajax_function'] = "";
                    $atributos ['ajax_control'] = $esteCampo;
                    $atributos ['estilo'] = "jqueryui";
                    $atributos ['validar'] = "";
                    $atributos ['limitar'] = true;
                    $atributos ['anchoCaja'] = 24;
                    $atributos ['miEvento'] = '';
                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("buscar_bajas");
                    $matrizItems = $esteRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");

                    $arreglo = array(
                        array(
                            '',
                            'Sin Entradas Registradas'
                        )
                    );

                    $matrizItems = $matrizItems[0][0] != '' ? $matrizItems : $arreglo;
                    $atributos ['matrizItems'] = $matrizItems;
                    // $atributos['miniRegistro']=;
                    // $atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "clase_entrada" );
                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);
                }
                echo $this->miFormulario->division("fin");
                unset($atributos);

                $atributos ["id"] = "estado_bD";
                $atributos ["estiloEnLinea"] = "display:none";
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->division("inicio", $atributos);
                unset($atributos);
                {
                    $esteCampo = 'estado_b';
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['id'] = $esteCampo;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ["etiquetaObligatorio"] = false;
                    $atributos ['tab'] = $tab ++;
                    $atributos ['seleccion'] = - 1;
                    $atributos ['anchoEtiqueta'] = 220;
                    $atributos ['evento'] = '';
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['deshabilitado'] = false;
                    $atributos ['columnas'] = 2;
                    $atributos ['tamanno'] = 1;
                    $atributos ['ajax_function'] = "";
                    $atributos ['ajax_control'] = $esteCampo;
                    $atributos ['estilo'] = "jqueryui";
                    $atributos ['validar'] = "";
                    $atributos ['limitar'] = true;
                    $atributos ['anchoCaja'] = 24;
                    $atributos ['miEvento'] = '';
                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("buscar_estadobaja");
                    $matrizItems = $esteRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");

                    $arreglo = array(
                        array(
                            '',
                            'Sin Entradas Registradas'
                        )
                    );

                    $matrizItems = $matrizItems[0][0] != '' ? $matrizItems : $arreglo;
                    $atributos ['matrizItems'] = $matrizItems;
                    // $atributos['miniRegistro']=;
                    $atributos ['baseDatos'] = "inventarios";
                    // $atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "clase_entrada" );
                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);
                }
                echo $this->miFormulario->division("fin");
                unset($atributos);

                $atributos ["id"] = "IDfaltanteD";
                $atributos ["estiloEnLinea"] = "display:none";
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->division("inicio", $atributos);
                unset($atributos); {
                    $esteCampo = 'IDfaltante';
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['id'] = $esteCampo;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ["etiquetaObligatorio"] = false;
                    $atributos ['tab'] = $tab ++;
                    $atributos ['seleccion'] = - 1;
                    $atributos ['anchoEtiqueta'] = 220;
                    $atributos ['evento'] = '';
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['deshabilitado'] = false;
                    $atributos ['columnas'] = 2;
                    $atributos ['tamanno'] = 1;
                    $atributos ['ajax_function'] = "";
                    $atributos ['ajax_control'] = $esteCampo;
                    $atributos ['estilo'] = "jqueryui";
                    $atributos ['validar'] = "";
                    $atributos ['limitar'] = true;
                    $atributos ['anchoCaja'] = 24;
                    $atributos ['miEvento'] = '';
                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("buscar_faltante");
                    $matrizItems = $esteRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");

                    $arreglo = array(
                        array(
                            '',
                            'Sin Entradas Registradas'
                        )
                    );

                    $matrizItems = $matrizItems[0][0] != '' ? $matrizItems : $arreglo;
                    $atributos ['matrizItems'] = $matrizItems;
                    // $atributos['miniRegistro']=;
                    $atributos ['baseDatos'] = "inventarios";
                    // $atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "clase_entrada" );
                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);
                }
                echo $this->miFormulario->division("fin");
                unset($atributos);


                $atributos ["id"] = "IDhurtoD";
                $atributos ["estiloEnLinea"] = "display:none";
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->division("inicio", $atributos);
                unset($atributos); {
                    $esteCampo = 'IDhurto';
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['id'] = $esteCampo;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ["etiquetaObligatorio"] = false;
                    $atributos ['tab'] = $tab ++;
                    $atributos ['seleccion'] = - 1;
                    $atributos ['anchoEtiqueta'] = 220;
                    $atributos ['evento'] = '';
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['deshabilitado'] = false;
                    $atributos ['columnas'] = 2;
                    $atributos ['tamanno'] = 1;
                    $atributos ['ajax_function'] = "";
                    $atributos ['ajax_control'] = $esteCampo;
                    $atributos ['estilo'] = "jqueryui";
                    $atributos ['validar'] = "";
                    $atributos ['limitar'] = true;
                    $atributos ['anchoCaja'] = 24;
                    $atributos ['miEvento'] = '';
                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("buscar_hurto");
                    $matrizItems = $esteRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");

                    $arreglo = array(
                        array(
                            '',
                            'Sin Entradas Registradas'
                        )
                    );

                    $matrizItems = $matrizItems[0][0] != '' ? $matrizItems : $arreglo;
                    $atributos ['matrizItems'] = $matrizItems;
                    // $atributos['miniRegistro']=;
                    $atributos ['baseDatos'] = "inventarios";
                    // $atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "clase_entrada" );
                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);
                }
                echo $this->miFormulario->division("fin");
                unset($atributos);

                // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------

                $esteCampo = 'fecha_inicio';
                $atributos ['id'] = $esteCampo;
                $atributos ['nombre'] = $esteCampo;
                $atributos ['tipo'] = 'text';
                $atributos ['estilo'] = 'jqueryui';
                $atributos ['marco'] = true;
                $atributos ['estiloMarco'] = '';
                $atributos ["etiquetaObligatorio"] = false;
                $atributos ['columnas'] = 2;
                $atributos ['dobleLinea'] = 0;
                $atributos ['tabIndex'] = $tab;
                $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                $atributos ['validar'] = '';

                if (isset($_REQUEST [$esteCampo])) {
                    $atributos ['valor'] = $_REQUEST [$esteCampo];
                } else {
                    $atributos ['valor'] = '';
                }
                $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                $atributos ['deshabilitado'] = false;
                $atributos ['tamanno'] = 8;
                $atributos ['maximoTamanno'] = '';
                $atributos ['anchoEtiqueta'] = 220;
                $tab ++;

                // Aplica atributos globales al control
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoCuadroTexto($atributos);
                unset($atributos);


                // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------

                $esteCampo = 'fecha_final';
                $atributos ['id'] = $esteCampo;
                $atributos ['nombre'] = $esteCampo;
                $atributos ['tipo'] = 'text';
                $atributos ['estilo'] = 'jqueryui';
                $atributos ['marco'] = true;
                $atributos ['estiloMarco'] = '';
                $atributos ["etiquetaObligatorio"] = false;
                $atributos ['columnas'] = 2;
                $atributos ['dobleLinea'] = 0;
                $atributos ['tabIndex'] = $tab;
                $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                $atributos ['validar'] = '';

                if (isset($_REQUEST [$esteCampo])) {
                    $atributos ['valor'] = $_REQUEST [$esteCampo];
                } else {
                    $atributos ['valor'] = '';
                }
                $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                $atributos ['deshabilitado'] = false;
                $atributos ['tamanno'] = 8;
                $atributos ['maximoTamanno'] = '';
                $atributos ['anchoEtiqueta'] = 220;
                $tab ++;

                // Aplica atributos globales al control
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoCuadroTexto($atributos);
                unset($atributos);

                $atributos ["id"] = "IDtrasladoD";
                $atributos ["estiloEnLinea"] = "display:none";
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->division("inicio", $atributos);
                unset($atributos); {
                    $esteCampo = 'IDtraslado';
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['id'] = $esteCampo;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ["etiquetaObligatorio"] = false;
                    $atributos ['tab'] = $tab ++;
                    $atributos ['seleccion'] = - 1;
                    $atributos ['anchoEtiqueta'] = 220;
                    $atributos ['evento'] = '';
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['deshabilitado'] = false;
                    $atributos ['columnas'] = 2;
                    $atributos ['tamanno'] = 1;
                    $atributos ['ajax_function'] = "";
                    $atributos ['ajax_control'] = $esteCampo;
                    $atributos ['estilo'] = "jqueryui";
                    $atributos ['validar'] = "";
                    $atributos ['limitar'] = true;
                    $atributos ['anchoCaja'] = 24;
                    $atributos ['miEvento'] = '';
                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("buscar_traslado");
                    $matrizItems = $esteRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");

                    $arreglo = array(
                        array(
                            '',
                            'Sin Entradas Registradas'
                        )
                    );

                    $matrizItems = $matrizItems[0][0] != '' ? $matrizItems : $arreglo;
                    $atributos ['matrizItems'] = $matrizItems;
                    // $atributos['miniRegistro']=;
                    $atributos ['baseDatos'] = "inventarios";
                    // $atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "clase_entrada" );
                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);
                }
                echo $this->miFormulario->division("fin");
                unset($atributos);
            }
            echo $this->miFormulario->agrupacion('fin');
        }
        echo $this->miFormulario->division("fin");
        unset($atributos);
        ///// ------------------------ FIN LISTA DESPLEGABLE -----------------------//
// ------------------Division para los botones-------------------------
        $atributos ["id"] = "botones";
        $atributos ["estilo"] = "marcoBotones";
        echo $this->miFormulario->division("inicio", $atributos);

// -----------------CONTROL: Botón ----------------------------------------------------------------
        $esteCampo = 'botonConsultar';
        $atributos ["id"] = $esteCampo;
        $atributos ["tabIndex"] = $tab;
        $atributos ["tipo"] = 'boton';
// submit: no se coloca si se desea un tipo button genérico
        $atributos ['submit'] = true;
        $atributos ["estiloMarco"] = '';
        $atributos ["estiloBoton"] = 'jqueryui';
// verificar: true para verificar el formulario antes de pasarlo al servidor.
        $atributos ["verificar"] = '';
        $atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
        $atributos ["valor"] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['nombreFormulario'] = $esteBloque ['nombre'];
        $tab ++;

// Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoBoton($atributos);
// -----------------FIN CONTROL: Botón -----------------------------------------------------------
// ---------------------------------------------------------
// ------------------Fin Division para los botones-------------------------
        echo $this->miFormulario->division("fin");

        echo $this->miFormulario->marcoAgrupacion('fin');

// ------------------- SECCION: Paso de variables ------------------------------------------------

        /**
         * En algunas ocasiones es útil pasar variables entre las diferentes páginas.
         * SARA permite realizar esto a través de tres
         * mecanismos:
         * (a). Registrando las variables como variables de sesión. Estarán disponibles durante toda la sesión de usuario. Requiere acceso a
         * la base de datos.
         * (b). Incluirlas de manera codificada como campos de los formularios. Para ello se utiliza un campo especial denominado
         * formsara, cuyo valor será una cadena codificada que contiene las variables.
         * (c) a través de campos ocultos en los formularios. (deprecated)
         */
// En este formulario se utiliza el mecanismo (b) para pasar las siguientes variables:
// Paso 1: crear el listado de variables

        $valorCodificado = "actionBloque=" . $esteBloque ["nombre"];
        $valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina');
        $valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
        $valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
        $valorCodificado .= "&opcion=ConsultarOrden";
        /**
         * SARA permite que los nombres de los campos sean dinámicos.
         * Para ello utiliza la hora en que es creado el formulario para
         * codificar el nombre de cada campo. Si se utiliza esta técnica es necesario pasar dicho tiempo como una variable:
         * (a) invocando a la variable $_REQUEST ['tiempo'] que se ha declarado en ready.php o
         * (b) asociando el tiempo en que se está creando el formulario
         */
        $valorCodificado .= "&campoSeguro=" . $_REQUEST ['tiempo'];
        $valorCodificado .= "&tiempo=" . time();
// Paso 2: codificar la cadena resultante
        $valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar($valorCodificado);

        $atributos ["id"] = "formSaraData"; // No cambiar este nombre
        $atributos ["tipo"] = "hidden";
        $atributos ['estilo'] = '';
        $atributos ["obligatorio"] = false;
        $atributos ['marco'] = true;
        $atributos ["etiqueta"] = "";
        $atributos ["valor"] = $valorCodificado;
        echo $this->miFormulario->campoCuadroTexto($atributos);
        unset($atributos);

        $atributos ['marco'] = true;
        $atributos ['tipoEtiqueta'] = 'fin';
        echo $this->miFormulario->formulario($atributos);
    }

}

$miSeleccionador = new registrarForm($this->lenguaje, $this->miFormulario, $this->sql);

$miSeleccionador->miForm();
?>
