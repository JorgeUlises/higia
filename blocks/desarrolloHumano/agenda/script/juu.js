/**
 * @author Jorge Ulises Useche Cuellar
 * Ampliación de la funcionalidad de jQuery para manejar recursos en el proyecto actual
 */

(function( $ ) {

/*
 * Se inicia el complemento/plugin JUU como un objeto al que se le pueden adicionar método y/o eventos
 */
$.juu = new Object();

/*
 * Crea un element <div> con la clase parámetro que se escoja.
 */
$.juu.createDivByClass = function(clase) {
	return $("<div>")
	.addClass(clase);
};

/*
 * Crea un element <button> con la clase que se ingresa como parámetro.
 */
$.juu.createButtonByClass = function(clase) {
	return $("<button>")
	.attr("type","button")
	.addClass(clase);
}

/*
 * Crea un diálogo de bootrap recursivamente, los parámetro de ingreso es un objeto con los atributos:
 * titulo: posee el título del diálogo / ventaja emergente.
 * closeMessage: es el texto del botón que cierra la ventana.
 * saveMessage: es el nombre del botón que guarda los cambios y cierra la ventana.
 * contenido: es un Stringo o Elemento del DOM que si es un Formulario hace una validación de parámetros.
 * onSave: es el event listener o evento de escucha cuando se guardan los cambios.
 */
$.juu.createDialog = function(obj) {
	obj=(obj!=null)?obj:new Object();
	obj.titulo=(obj.titulo!=null)?obj.titulo:"Mi título";
	obj.closeMessage=(obj.closeMessage!=null)?obj.closeMessage:"Cerrar";
	obj.saveMessage=(obj.saveMessage!=null)?obj.saveMessage:"Guardar Actividad";
	obj.contenido=(obj.contenido!=null)?obj.contenido:"Mi contenido";
	obj.onSave=(obj.onSave!=null)?obj.onSave:function(){};
	
	obj.contenidoIsNode = (typeof(obj.contenido)=='object');
	obj.contenidoIsForm = ((obj.contenidoIsNode)?($(obj.contenido).prop("tagName") == "FORM"):false);
	
	var modalFade = $.juu.createDivByClass("modal fade")
	.attr("id","dialog-confirm");
	
	var modalDialog = $.juu.createDivByClass("modal-dialog")
	.appendTo(modalFade);
	
	var modalContent = $.juu.createDivByClass("modal-content")
	.appendTo(modalDialog);
	
	var modalHeader = $.juu.createDivByClass("modal-header")
	.appendTo(modalContent);
	
	var modalHeaderButton1 = $.juu.createButtonByClass("close")
	.attr("data-dismiss","modal")
	.attr("aria-hidden","true")
	.html("x")
	.appendTo(modalHeader);
	
	var modalHeaderH4 = $("<h4>")
	.addClass("modal-title")
	.html(obj.titulo)
	.appendTo(modalHeader);
	
	var modalBody = $.juu.createDivByClass("modal-body")
	.appendTo(modalContent);
	
	var modalBodyP = $("<p>")
	.appendTo(modalBody);

	if(obj.contenidoIsNode){
		modalBodyP.append(obj.contenido);
	} else {
		modalBodyP.html(obj.contenido);
	}
	
	var modalFooter = $.juu.createDivByClass("modal-footer")
	.appendTo(modalContent);
	
	var modalFooterButton1 = $.juu.createButtonByClass("btn btn-default")
	.attr("data-dismiss","modal")
	.html(obj.closeMessage)
	.appendTo(modalFooter);
	
	if(obj.saveMessage){
		var modalFooterButton2 = $.juu.createButtonByClass("btn btn-primary")
		.html(obj.saveMessage)
		.click(function(){
			if(obj.contenidoIsForm){
				$(obj.contenido).submit();
			} else {
				obj.onSave(obj.contenido);
				modalFade.modal('hide');
			}		
		})
		.appendTo(modalFooter);
	}	
	
	modalFade.modal();
	
	//Evento si el contenido es un formulario, valida antes de enviar
	if(obj.contenidoIsForm){
		$(obj.contenido).submit(function (e) {
			if (e.isDefaultPrevented()) {
				// handle the invalid form...
			} else {
				// everything looks good!
				e.preventDefault();
				obj.onSave(obj.contenido);
				modalFade.modal('hide');
			}
		});
	}
	
    return modalFade;
};

/*
 * Crea un fomulario a partir de un arreglo de objetos con los atributos solicitados
 * var values = [{
		'name' : 'nombreInput',
		'alias' : 'Nombre del campo Input o Label',
		'placeholder' : 'Nombre que se desea para ayudar al usuario a llenar el campo'
	}];
 */
$.juu.createFormWithSelects = function(values) {
    return $('<form data-toggle="validator" role="form">').html(
		function (){
			//values is objects with key value attributes				
			var str = new String();
			$.each(values, function (i,v){
				str += '<div class="form-group">'
					+'<label for="'+this.name+'" class="control-label">'+this.alias+'</label>'
				    +'<input name="'+this.name+'" type="text" class="form-control" placeholder="'+this.placeholder+'" required>'
				    +'</div>';	
			});
			return str;
		}()
	).validator();
};

/*
 * Recoge los campos de un formulario y guarda un objeto con muchos atributos
 * con la estructura:
 * 	var attr = {
		'nombreInput1' : 'valorInput1',
		'nombreInput2' : 'valorInput2'
	};
 */
$.juu.formToAttrObject = function(form) {
    var obj = new Object();
    $(form).find("[name]").each(function(index){
    	obj[$(this).attr('name')] = $(this).val();
    });
    return obj;
};

/*
 * 
 */
$.juu.display = function(message) {
	var options = {
		titulo : 'Alerta',
		contenido : message,
		saveMessage: false
	};
	var dialog = $.juu.createDialog(options);
	dialog.modal('show');
};

/*
 * 
 */
$.juu.createAndAppendIconButton = function(nodo,eventoClic,clase){	
	var iconButton = $.juu.createIconButtonByClassAndClick(eventoClic,clase);
	$.juu.appendAfterNode(nodo,iconButton);
	return iconButton;
}

/*
 * 
 */
$.juu.appendAfterNode = function(nodo,element){
    $(nodo).after(element);
}

/*
 * 
 */
$.juu.createIconButtonByClassAndClick = function(eventoClic,clase){
	var button = $('<button class="fc-prev-button ui-button ui-state-default" type="button">');
    var icon = $('<span class="ui-icon">').addClass(clase).appendTo(button);
    button.click(function() {
	if (!button.hasClass('ui-state-disabled')) {
		eventoClic();
		if (button.hasClass('ui-state-active') || button.hasClass('ui-state-disabled')) {
			button.removeClass('ui-state-hover');
		}
	}
	}).mousedown(function() {
		button.not('.ui-state-active').not('.ui-state-disabled').addClass('ui-state-down');
	}).mouseup(function() {
		button.removeClass('ui-state-down');
	}).hover(function() {
		button.not('.ui-state-active').not('.ui-state-disabled').addClass('ui-state-hover');
	}, function() {
		button.removeClass('ui-state-hover').removeClass('ui-state-down');
	});
    return button;
}
 
}( jQuery ));