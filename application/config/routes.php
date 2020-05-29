<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	https://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There are three reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router which controller/method to use if those
  | provided in the URL cannot be matched to a valid route.
  |
  |	$route['translate_uri_dashes'] = FALSE;
  |
  | This is not exactly a route, but allows you to automatically route
  | controller and method names that contain dashes. '-' isn't a valid
  | class or method name character, so it requires translation.
  | When you set this option to TRUE, it will replace ALL dashes in the
  | controller and method URI segments.
  |
  | Examples:	my-controller/index	-> my_controller/index
  |		my-controller/my-method	-> my_controller/my_method
 */
$route['default_controller'] = 'Control';


///////*************** CONTROL ***************///////

$route['menu'] = 'Control/menu';

$route['logout'] = 'Control/logout';

$route['enviarDocumento'] = 'Control/enviarDocumento';
$route['recibirDocumento'] = 'Control/recibirDocumento';
$route['crearDocumento'] = 'Control/crearDocumento';
$route['comprobante'] = 'Control/comprobanteDocumento';
$route['codigoBarra'] = 'Control/codigoBarra';
$route['crearUsuario'] = 'Control/crearUsuario';
$route['crearDepartamento'] = 'Control/crearDepartamento';
$route['codigoBarra'] = 'Control/codigoBarra';
$route['verDocumento'] = 'Control/verDocumento';
$route['verEstados/(:num)'] = 'Control/verEstados/$1';
$route['verMensajes/(:num)'] = 'Control/verMensajes/$1';
$route['porDepartamento'] = 'Control/porDepartamento';
$route['porUsuario'] = 'Control/porUsuario';
$route['porCodigo'] = 'Control/porCodigo';
$route['listaUsuarios'] = 'Control/listaUsuarios';
$route['listaDepartamentos'] = 'Control/listaDepartamentos';
$route['perfilUsuario'] = 'Control/perfilUsuario';
$route['pendientes'] = 'Control/pendientes';
$route['pendientesMen'] = 'Control/pendientesMen';
$route['terminarDocumento'] = 'Control/terminarDocumento';
$route['documentosPendientes'] = 'Control/documentosPendientes';



///////*************** LOGIN ***************///////
$route['iniciar'] = 'Login/iniciarSesion';


///////*************** DOCUMENTO ***************///////
$route['compro'] = 'Pdfgenerator/crearPDF';
$route['generarPDF/(:num)'] = 'Documento/generarPDF/$1';
$route['insertDocumento'] = 'Documento/crearDocumento';
$route['getDocumentoEstado'] = 'Documento/getDocumentoEstado';
$route['getDocumentoUsuario'] = 'Documento/getDocumentoUsuario';
$route['getDocumentoPorDepartamento'] = 'Documento/getDocumentoPorDepartamento';
$route['getDocumentoPorCodigo'] = 'Documento/getDocumentoPorCodigo';
$route['subirArchivo'] = 'Documento/do_upload';
$route['verDocumentoBuscar/(:any)'] = 'Documento/verDocumentoBuscar/';
$route['terminarDoc'] = 'Documento/terminarDoc';
$route['eliminarDocumento'] = 'Documento/eliminarDocumento';


///////*************** DEPARTAMENTOS ***************///////
$route['getDepartamentos'] = 'Departamento/getDepartamentos';
$route['insertDepartamento'] = 'Departamento/crearDepartamento';
$route['subirFotoDepto'] = 'Departamento/subirFotoDepto';
$route['editarDepartamento'] = 'Departamento/editarDepartamento';

///////*************** USUARIOS ***************///////
$route['getUsuario'] = 'Usuario/getUsuario';
$route['insertUsuario'] = 'Usuario/crearUsuario';
$route['validarRut'] = 'Usuario/validarRut';
$route['getUsuarios'] = 'Usuario/getUsuariosDepartamento';
$route['getDocumentoPorUsuario'] = 'Usuario/getDocumentoPorUsuario';
$route['subirFotoUsuario'] = 'Usuario/subirFotoUsuario';
$route['obtenerUsuario'] = 'Usuario/obtenerUsuario';
$route['editarPerfil'] = 'Usuario/editarPerfil';

///////*************** ESTADO ***************///////
$route['getEstados'] = 'Estado/getEstados';
$route['getDoc'] = 'Estado/getDoc';
$route['getUltimoEstado'] = 'Estado/getUltimoEstado';
$route['recibirDocumentoEstado'] = 'Estado/recibirDocumento';
$route['getDocumentosNotificaciones'] = 'Estado/getDocumentosNotificaciones';
$route['faltantesDepartamentos'] = 'Estado/faltantesDepartamentos';
$route['faltantesUsuarios'] = 'Estado/faltantesUsuarios';
$route['exportarExcel'] = 'Estado/exportarExcel';

///////*************** ARCHIVO ***************///////
$route['getArchivo'] = 'Archivo/getArchivo';
$route['agregarArchivo'] = 'Archivo/agregarArchivo';


///////*************** EXCEL ***************///////
$route['excel'] = 'Excel/excel';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
