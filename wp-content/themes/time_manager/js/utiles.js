/*
	FUNCION: listen(event, elem,func);
	DESCRIPCION: 
		Se encarga de asignar eventos a objetos que lanzarán una función
		definida.
	ARGUMENTOS: 
			- event: Tipo de evento a escuchar.
			- elem: Elemento a escuchar (en String)
			- func: Función a lanzar al cumplir (event) en (elem).
	DEVUELVE: 
		Registra en el navegador los eventos definidos.
*/
function listen(event, elem, func) {
    elem = $(elem);
    if (elem.addEventListener)  // W3C DOM
        elem.addEventListener(event,func,false);
    else if (elem.attachEvent)  // IE DOM
        elem.attachEvent('on'+event, function(){ func(new W3CDOM_Event(elem)) } );
    else throw 'No es posible añadir evento';
}
// Necesario para atacar al DOM de IE
function W3CDOM_Event(currentTarget) {
    this.currentTarget  = currentTarget;
    this.preventDefault = function() { window.event.returnValue = false }
    return this;
}

/*
	FUNCION: $(elem);
	DESCRIPCION: 
		Nos devuelve el objeto de un elemento pasado por parametro
	ARGUMENTOS: 
			- elem: Elemento a buscar (en String)
	DEVUELVE: 
		El objeto buscado o un error en caso de no existir.
*/
function $(elem) {
    if (document.getElementById) {
        if (typeof elem == "string") {
            elem = document.getElementById(elem);
            if (elem===null) throw 'No se ha podido coger el elemento: ' + elem + ' no existe';
        } else if (typeof elem != "object") {
            throw 'No se ha podido coger el elemento: tipo de datos invalido';
        }
    } else throw 'No se ha podido coger el elemento: DOM no soportado';
    return elem;
}
/*
	FUNCION: Oculta(id);
	DESCRIPCION: 
		Oculta un elemento.
	ARGUMENTOS: 
			- id: Nombre del ID del objeto a ocultar
	DEVUELVE: 
		Asigna NONE al atributo display del objeto.
*/
function Oculta(id){ if ($(id))	$(id).style.display = "none"; }

/*
	FUNCION: Muestra(id);
	DESCRIPCION: 
		Hace visible un elemento.
	ARGUMENTOS: 
			- id: Nombre del ID del objeto a mostrar
	DEVUELVE: 
		Asigna "" al atributo display del objeto.
*/
function Muestra(id){ if ($(id)) $(id).style.display = "";}

/** XHConn - Simple XMLHTTP Interface - bfults@gmail.com - 2005-04-08        **
 ** Code licensed under Creative Commons Attribution-ShareAlike License      **
 ** http://creativecommons.org/licenses/by-sa/2.0/                           **/
function XHConn()
{
  var xmlhttp, bComplete = false;
  try { xmlhttp = new ActiveXObject("Msxml2.XMLHTTP"); }
  catch (e) { try { xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); }
  catch (e) { try { xmlhttp = new XMLHttpRequest(); }
  catch (e) { xmlhttp = false; }}}
  if (!xmlhttp) return null;
  this.connect = function(sURL, sMethod, sVars, fnDone)
  {
    if (!xmlhttp) return false;
    bComplete = false;
    sMethod = sMethod.toUpperCase();
    try {
      if (sMethod == "GET"){xmlhttp.open(sMethod, sURL+"?"+sVars, true); sVars = "";}
      else {
        xmlhttp.open(sMethod, sURL, true);
        xmlhttp.setRequestHeader("Method", "POST "+sURL+" HTTP/1.1");
        xmlhttp.setRequestHeader("Content-Type",
          "application/x-www-form-urlencoded");
      }
      xmlhttp.onreadystatechange = function(){
        if (xmlhttp.readyState == 4 && !bComplete){ bComplete = true;fnDone(xmlhttp);}};
      xmlhttp.send(sVars);
    }
    catch(z) { return false; }
    return true;
  };
  return this;
}

/* Eventos */
window.onload = function() {
$("commentform").onsubmit = function () {
		var form = this;
		var param ='';
		for(var x=0; x<form.elements.length; x++) {
			param += form.elements[x].name + "=" + form.elements[x].value +"&";
			if (form.elements[x].name == 'comment_post_ID') id=form.elements[x].value
		}

		$("comment").value = "";
		$('ajax_comments').innerHTML += Loading();
		
		param = param.substring(0,param.length);

		var myConn = CreaAjax();
		var inserta = function (oXML) {commentNew(id);};
		myConn.connect(newComent, "POST", param, inserta);
	return false;
}
}


function CreaAjax(){var myConn = new XHConn(); if (!myConn) alert("XMLHTTP not available. Try a newer/better browser.");return myConn;}
function Loading() { return '<p style="text-align:center;"><img src="' + imgLoading + '" alt="Cargando..." /></p>';}


function commentNew(id){
        target= $('ajax_comments');
        target.style.display= "";
		var myConn = CreaAjax();
	    var comments = function (oXML) {
			target.style.display = "none";
			target.innerHTML = oXML.responseText;
			Muestra("ajax_comments");
		};
		myConn.connect(urlComments, "POST", "comment_post_ID="+id, comments);
}

/************/
/*
Descomentar para activar lightbox
*/
//window.onload=function() {  initLightbox(); }
