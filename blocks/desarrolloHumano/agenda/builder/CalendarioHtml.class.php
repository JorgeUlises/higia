<?php

//namespace blocks\docentes\planDeTrabajo\builder\componentes;

if (! isset ( $GLOBALS ['autorizado'] )) {
	include ('index.php');
	exit ();
}

include_once ("HtmlBaseMod.class.php");
/**
 * Para calendario:
 * $atributos['id'] String Identificador del objeto HTML
 * $atributos['id'] TipoVariable Comentario
 */
class CalendarioHtml extends HtmlBaseMod{

    function calendario($atributos) {
        
        $this->setAtributos ( $atributos );
        
        $this->campoSeguro();
        
        $this->cadenaHTML = '';
        
        $final='';
    
        $this->cadenaHTML .= $this->createCalendar();
        
        return $this->cadenaHTML.$final;
    
    }
    
	private function createCalendar(){    
    	// $htmlModal = file_get_contents('page-content-wrapper.html.php', true);
    	$html = $this->parsePhpHtml('html/fullCalendar.html.php');
    	$html .= $this->parsePhpJs('js/fullCalendar.js.php');
    	return $html;
    }  
    
}