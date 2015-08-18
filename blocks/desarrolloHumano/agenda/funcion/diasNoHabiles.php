<?php

require_once 'Festivos.php';


class DiasNoHabiles{

	var $domingo;
	var $festivos;
	var $DateOfRequest;
	var $fecha_inicio;
	var $fecha_fin;
	var $ano;



	public function __construct($fecha_inicio, $fecha_fin){

		$this->fecha_inicio = $fecha_inicio;
		$this->fecha_fin = $fecha_fin;

		$dato1 = explode("/", $this->fecha_inicio);
		$ano_inicio = $dato1[0];

		$dato2 = explode("/", $this->fecha_fin);
		$ano_fin = $dato2[0];

		$llamar = new Festivos;

		for( $i = $ano_inicio; $i <= $ano_fin; $i++  ){
			$this->festivos = $llamar->buscarFestivos($i);
		}
	}

	public function biciesto($ano){
		if((!($ano%4) && ($ano%100)) || !($ano%400)){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function mesBiciesto(){
		$mesBiciesto = array( 31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
		return $mesBiciesto;
	}

	public function mesNoBiciesto(){
		$mesNoBiciesto = array( 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 );
		return $mesNoBiciesto;
	}

	public function eliminarCeros($numero){
		switch ($numero){
			case '01':
				return 1;
				break;
			case '02':
				return 2;
				break;
			case '03':
				return 3;
				break;
			case '04':
				return 4;
				break;
			case '05':
				return 5;
				break;
			case '06':
				return 6;
				break;
			case '07':
				return 7;
				break;
			case '08':
				return 8;
				break;
			case '09':
				return 9;
				break;
			default:
				return $numero;
				break;
		}
	}

	public function buscarDomingosFestivos(){
		$dato1 = explode("/", $this->fecha_inicio);
		$ano_inicio = $dato1[0];
		$mes_inicio = $this->eliminarCeros ( $dato1[1] );
		$dia_inicio = $this->eliminarCeros ( $dato1[2] );

		$dato2 = explode("/", $this->fecha_fin);
		$ano_fin = $dato2[0];
		$mes_fin = $this->eliminarCeros ( $dato2[1] );
		$dia_fin = $this->eliminarCeros ( $dato2[2] );

		if( $ano_inicio == $ano_fin ){
			if($this->biciesto($ano_inicio) == true){
				$diasMes = $this->mesBiciesto();
			}else{
				$diasMes = $this->mesNoBiciesto();
			}

			$diasMes[$mes_fin - 1] = $dia_fin;

			for( $mes = $mes_inicio; $mes <= $mes_fin; $mes++ ){
				for( $dia = $dia_inicio; $dia <= $diasMes[$mes - 1]; $dia++ ){
					$date = new DateTime($dia."-".$mes."-".$ano_inicio);//se establece la fecha y se le pasa como parametro getdate($date->getTimestamp()) para obtener el dia de la semana.
					if(getdate($date->getTimestamp())['wday'] == 0){
						$this->domingo[$ano_inicio][$mes][$dia] = true;
						$this->DateOfRequest[] = array(
								"start" => date("Y/m/d H:i:s", mktime(0, 0, 0, $mes, $dia, $ano_inicio)),
								"end" => date("Y/m/d H:i:s", mktime(23, 59, 59, $mes, $dia, $ano_inicio)),
						);
					}else if($this->festivos[$ano_inicio][$mes][$dia] == true){
						$this->DateOfRequest[] = array(
								"start" => date("Y/m/d H:i:s", mktime(0, 0, 0, $mes, $dia, $ano_inicio)),
								"end" => date("Y/m/d H:i:s", mktime(23, 59, 59, $mes, $dia, $ano_inicio)),
						);
					}
					if($dia == $diasMes[$mes - 1]){
						$dia_inicio = 1;
					}
				}
			}
		}else if( $ano_fin > $ano_inicio ){
			for($ano = $ano_inicio; $ano <= $ano_fin; $ano++){
				if($this->biciesto($ano) == true){
					$diasMes = $this->mesBiciesto();
				}else{
					$diasMes = $this->mesNoBiciesto();
				}

				if($ano == $ano_fin){
					$diasMes[$mes_fin - 1] = $dia_fin;
					$fin = $mes_fin;
				}else{
					$fin = 12;
				}

				for( $mes = $mes_inicio; $mes <= $fin; $mes++ ){
					for( $dia = $dia_inicio; $dia <= $diasMes[$mes - 1]; $dia++){
						$date = new DateTime($dia."-".$mes."-".$ano_inicio);//se establece la fecha y se le pasa como parametro getdate($date->getTimestamp()) para obtener el dia de la semana.
						if(getdate($date->getTimestamp())['wday'] == 0){
							$this->domingo[$ano][$mes][$dia] = true;
							$this->DateOfRequest[] = array(
									"start" => date("Y/m/d H:i:s", mktime(0, 0, 0, $mes, $dia, $ano)),
									"end" => date("Y/m/d H:i:s", mktime(23, 59, 59, $mes, $dia, $ano)),
							);
						}else if($this->festivos[$ano][$mes][$dia] == true){
							$this->DateOfRequest[] = array(
									"start" => date("Y/m/d H:i:s", mktime(0, 0, 0, $mes, $dia, $ano)),
									"end" => date("Y/m/d H:i:s", mktime(23, 59, 59, $mes, $dia, $ano)),
							);
						}
						if($dia == $diasMes[$mes - 1]){
							$dia_inicio = 1;
						}
					}
					if($mes == 12){
						$mes_inicio = 1;
					}
				}
					
			}
		}
			
		json_encode($this->DateOfRequest);

		//return json_encode($this->DateOfRequest);
		var_dump ($this->DateOfRequest);
	}

}


//EL CONSTRUCTOR DE LA CLASE RECIBE COMO PARAMETROS 'AAAA/MM/DD' ,  'AAAA/MM,DD' SIENDO FECHA DE INICIO Y FECHA FINAL RESPECTIVAMENTE.

$llamada = new DiasNoHabiles('2016/06/01', '2016/06/31');
$resultado = $llamada->buscarDomingosFestivos();
echo $resultado;


?>