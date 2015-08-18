/**
 * @author Jorge Ulises Useche Cuellar
 */

$(document).ready(function() {
	//En esta configuración no se aceptan los "allDayEvent", "Repeating Event" por lo tanto darán error porque no tienen "end" time moment
	//	{
	//		"title": "All Day Event",
	//		"start": "2015-02-01"
	//	},
	$.getJSON("json/actividades.json", loadCalendar);
});

//window.onbeforeunload = listenerBlockCalendar;
	
function listenerBlockCalendar (event) {
	var message = 'No se han guardado los cambios en el Calendario.';
	console.log(event,window.event);
    var e = e || window.event;
    if (e) {
        e.returnValue = message;
    }
    return message;
};

function loadCalendar(data) {
	var calendario = $('#calendar');
	//	var dayClickListener = function(date, jsEvent, view) {
	////		calendario.fullCalendar('changeView', 'agendaWeek');
	////		calendario.fullCalendar('gotoDate', date);
	//
	//		// change the day's background color just for fun
	//		$(this).css('background-color', 'red');
	//
	//	};
	var periodo = data.periodo;
	var inicioPeriodo = $.fullCalendar.moment(periodo.start);
	var finPeriodo = $.fullCalendar.moment(periodo.end);
	
	var selectListener = function(start, end) {
		
		 if (isOverlapping({start:start,end:end})) {
			 $.juu.display('Ya hay una actividad en ese horario.');
			 return false;
		 }
		 
		 if (isOutPeriod({start:start,end:end})) {
			 $.juu.display('Está asignando una actividad fuera del Periodo.');
			 return false;
		 }
		 
		var onSave = function(contenido) {
			var attr = $.juu.formToAttrObject(contenido);
			eventData = {
				title : attr.nombreActividad,
				start : start,
				end : end
			};
			calendario.fullCalendar('renderEvent', eventData, true);
			// stick? = true
			//calendario.fullCalendar('unselect');
		};
		
		var values = [{
			'name' : 'nombreActividad',
			'alias' : 'Nombre de la Actividad',
			'placeholder' : 'Seleccione un nombre descriptivo para la Actividad'
		}, {
			'name' : 'observacion',
			'alias' : 'Observación',
			'placeholder' : 'Escriba una observación para la actividad'
		}];

		var contenido = $.juu.createFormWithSelects(values);
		var options = {
			titulo : 'Parámetros de la Actividad',
			contenido : contenido,
			onSave : onSave
		};
		var dialog = $.juu.createDialog(options);
		dialog.modal('show');

	};
	
	var isOutPeriod = function (event){		
		if (event.start > inicioPeriodo && event.end < finPeriodo) {
			return false;
		} 
		return true;
	}
	
	var isOverlapping = function (event){
		var array = calendario.fullCalendar('clientEvents');
		for (i in array) {
			if (array[i]._id != event._id) {
				if (!(array[i].start.format() >= event.end.format() || array[i].end
						.format() <= event.start.format())) {
					return true;
				}
			}
		}
		return false;
	}
	
//	var eventDropListener = function(event, delta, revertFunc, jsEvent, ui, view) {
//        if (isOverlapping(event)) {
//        	$.juu.display('Ya hay una actividad en ese horario');
//        	revertFunc();
//        }
//    };
    
    var eventDayRenderListener = function(view, element){
    	perro = inicioPeriodo;
    	gato = finPeriodo;
    	raton = element;
    	console.log(view,element,perro,gato);
        if (view.start > finPeriodo || view.stop < inicioPeriodo){
        	//Está fuera del periodo
        	$(element).find('.fc-day').css('background-color',"#ff9f89");
        } else {
        	//Está dentro del periodo
        }
    }
	
	calendario.fullCalendar({
		theme : true,
		header : {
			left : 'prevYear,prev,next,nextYear',
			center : 'title',
			right : 'today'
		},
		defaultDate : '2015-02-12',
		annotations: [{
            start: new Date('2015-02-11'),
            end: new Date('2015-02-12'),
            title: 'Blocked Day',
            cls: 'open',
            color: '#777777',
            background: '#000'
        }],
		defaultView : 'agendaWeek',
		lang : 'es',
		slotDuration : '01:00:00',
		//No permite el overlapping, pero si más eventos en una hora del día
		slotEventOverlap : false,
		// time formats
		//		titleFormat: {
		//		    month: 'MMMM yyyy',
		//		    week: "MMM d[ yyyy]{ '&#8212;'[ MMM] d yyyy}",
		//		    day: 'dddd, MMM d, yyyy'
		//		},
		//		columnFormat: {
		//		    month: 'ddd',
		//		    week: 'ddd M/d',
		//		    day: 'dddd d'
		//		},
		axisFormat : 'h:mm A', //,'H(:mm)',
		timeFormat : {
			agenda : 'h:mm A' //H(:mm)'
		},
		firstDay : 1,
		hiddenDays : [0],
		height : 610,
		// locale
		//		buttonIcons : false, // show the prev/next text
		// weekNumbers: true,
		//		businessHours : true, // display business hours
		editable : true,
		allDaySlot : false,
		allDayText : false,
		//		eventLimit : true, // allow "more" link when too many events
		events : data.events,
		//		dayClick : dayClickListener,
		selectable : true,
		selectHelper : true,
		select : selectListener,
		//Impedir overlapping
		//eventDrop: eventDropListener,//Ya no se necesita si se tiene en el json "overlap": false,
	    //eventResize: eventDropListener,//Ya no se necesita si se tiene en el json "overlap": false,
	    //Deshabilitar día si sale del periodo
	    viewRender: eventDayRenderListener
	});

}
