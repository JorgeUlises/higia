<?php

namespace desarrolloHumano\agenda;

if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class Sql extends \Sql {

    var $miConfigurador;

    function __construct() {
        $this->miConfigurador = \Configurador::singleton();
    }

    function getCadenaSql($tipo, $variable = "") {

        /**
         * 1.
         * Revisar las variables para evitar SQL Injection
         */
        $prefijo = $this->miConfigurador->getVariableConfiguracion("prefijo");
        $idSesion = $this->miConfigurador->getVariableConfiguracion("id_sesion");

        switch ($tipo) {

            /**
             * Clausulas específicas
             */
            case "buscarAgenda" :
                $cadenaSql = "SELECT ";
				$cadenaSql .= "a.id_agenda AS id_agenda, ";
				$cadenaSql .= "b.nombre AS consultorio, ";
				$cadenaSql .= "c.descripcion AS modalidad, ";
				$cadenaSql .= "a.hora_inicio AS hora_inicio, ";
				$cadenaSql .= "a.hora_fin AS hora_fin, ";
				$cadenaSql .= "a.descripcion AS descripcion, ";
				$cadenaSql .= "e.documento AS documento_persona, ";
				$cadenaSql .= "f.primer_nombre || ' ' || COALESCE(f.segundo_nombre,'') || ' ' ||  ";
				$cadenaSql .= "f.primer_apellido || ' ' || COALESCE(f.segundo_apellido,'') AS nombre_persona ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "bienestar.agenda AS a ";
				$cadenaSql .= "INNER JOIN ";
				$cadenaSql .= "bienestar.consultorio AS b ";
				$cadenaSql .= "ON ";
				$cadenaSql .= "a.id_consultorio = b.id_consultorio ";
				$cadenaSql .= "INNER JOIN ";
				$cadenaSql .= "bienestar.modalidad AS c ";
				$cadenaSql .= "ON ";
				$cadenaSql .= "a.id_modalidad = c.id_modalidad ";
				$cadenaSql .= "INNER JOIN ";
				$cadenaSql .= "bienestar.agenda_profesional AS d ";
				$cadenaSql .= "ON ";
				$cadenaSql .= "a.id_agenda = d.id_agenda ";
				$cadenaSql .= "INNER JOIN ";
				$cadenaSql .= "bienestar.profesional_salud AS e ";
				$cadenaSql .= "ON ";
				$cadenaSql .= "d.id_profesional = e.id_profesional ";
				$cadenaSql .= "INNER JOIN ";
				$cadenaSql .= "bienestar.persona AS f ";
				$cadenaSql .= "ON ";
				$cadenaSql .= "e.documento = f.documento ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "a.estado_registro = TRUE AND ";
				$cadenaSql .= "b.estado_registro = TRUE AND ";
				$cadenaSql .= "c.estado_registro = TRUE AND ";
				$cadenaSql .= "d.estado_registro = TRUE AND ";
				$cadenaSql .= "e.estado_registro = TRUE AND ";
				$cadenaSql .= "f.estado_registro = TRUE ";
				$cadenaSql .= "ORDER BY a.id_agenda;";
                break;

        }
        return $cadenaSql;
    }

}

?>
