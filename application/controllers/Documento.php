<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Documento
 *
 * @author EXTEORICO
 */
require_once APPPATH . "/third_party/dompdf/autoload.inc.php";

use Dompdf\Dompdf;
use Dompdf\Options;

class Documento extends CI_Controller {

    public $archivo;

    public function __construct() {
        parent::__construct();
        $this->load->model('Modelo');
        $this->load->model('Pdf');
        $this->archivo = 'assets/archivos/';
     
    }

    public function crearDocumento() {

        $fecha = new DateTime();
        $docu_codigo = $this->input->post('docu_codigo');
        $docu_tipo = $this->input->post('docu_tipo');
        $docu_tipo = strtoupper($docu_tipo);
        $docu_nombre = $this->input->post('docu_nombre');
        $docu_fecha_ingreso = $fecha->format('Y-m-d H:i:s');
        $docu_descripcion = $this->input->post('docu_descripcion');
        $docu_estado = "ENVIADO";
        $destinatarios = $this->input->post('destinatarios');
        $archivoUrl = $this->input->post('archivoUrl');
        $archivoNombre = $this->input->post('archivoNombre');

        $split = explode('.', $archivoNombre);

        $extension = array_pop($split);

        $destinatarios = explode('-', $destinatarios);
        array_pop($destinatarios);
        $usuario_usu_rut = $this->session->userdata('user')->usu_rut;

        $departamento_iddepartamento = $this->session->userdata('user')->departamento_iddepartamento;
        $departamento = $this->Modelo->getDepartamento(intval($departamento_iddepartamento));
        $usuario_usu_rut = $this->session->userdata('user')->usu_rut;

        $resp = '';
        $existe = false;
        $documento = $this->Modelo->insertDocumento($docu_codigo, $docu_tipo, $docu_fecha_ingreso, $docu_nombre, $docu_descripcion, $usuario_usu_rut, $docu_estado);
        $ultimoDocumento = $this->getUltimoDocumento();

        $insertDestinatarios = [];

        if ($documento > 0) {
            $this->crearEstadoEnviado($ultimoDocumento[0]->iddocumento, $departamento[0]->iddepartamento, $usuario_usu_rut);
            $this->Modelo->crearArchivo($archivoNombre, $extension, $archivoUrl, $docu_fecha_ingreso, $ultimoDocumento[0]->iddocumento);
            if ($docu_tipo == 'MEMORANDO' || $docu_tipo == 'CIRCULAR' || $docu_tipo == 'OTROS') {
                foreach ($destinatarios as $destino) {
                    if (strlen($destino) < 3) {
                        $usuarios = $this->Modelo->getUsuariosDepartamento(intval($destino));
                        foreach ($usuarios as $usu) {
                            if ($usu->usu_rut != $usuario_usu_rut) {
                                array_push($insertDestinatarios, $usu->usu_rut);
                            }
                        }
                        for ($i = 0; $i < sizeof($usuarios); $i++) {
                            if ($usuarios[$i]->usu_rut == $usuario_usu_rut) {
                                unset($usuarios[$i]);
                            }
                        }
//                        unset($usuarios[$usuario_usu_rut]);
//                        foreach ($usuarios as $usuario) {
//                            if ($documento > 0 && $this->crearEstadoProceso($ultimoDocumento[0]->iddocumento, $departamento[0]->iddepartamento, $usuario->usu_rut)) {
//                                $resp = "Documento ingresado con EXITO MEMORANDO";
//                                $existe = true;
//                            } else {
//                                $ultimoDocumento = '';
//                                $resp = "ERROR de datos MEMORANDO";
//                            }
//                        }
                    } else {
                        array_push($insertDestinatarios, $destino);
//                        if ($documento > 0 && $this->crearEstadoProceso($ultimoDocumento[0]->iddocumento, $departamento[0]->iddepartamento, $destino)) {
//                            $resp = "Documento ingresado con EXITO MEMORANDO";
//                            $existe = true;
//                        } else {
//                            $ultimoDocumento = '';
//                            $resp = "ERROR de datos MEMORANDO";
//                        }
                    }
                }
                $insertDestinatarios = array_unique($insertDestinatarios);
                foreach ($insertDestinatarios as $id) {
                    if ($this->crearEstadoProceso($ultimoDocumento[0]->iddocumento, $departamento[0]->iddepartamento, $id)) {
                        $resp = "Documento ingresado MEMORANDO";
                        $existe = true;
                    } else {
                        $resp = "ERROR de datos MEMORANDO";
                        $existe = false;
                    }
                }
            } else {
                $resp = "Documento ingresado con EXITO";
                $existe = true;
            }
        } else {
            $ultimoDocumento = '';
            $resp = "ERROR de datos DOCUMENTO";
        }

        echo json_encode(array('existe' => $existe, 'resp' => $resp, 'documento' => $ultimoDocumento, 'desti' => $insertDestinatarios));
    }

    public function getUltimoDocumento() {
        return $this->Modelo->getUltimoDocumento();
    }

    public function crearEstadoEnviado($iddocumento, $iddepartamento, $usuario_usu_rut) {

        $fecha = new DateTime();

        $datos = array(
            'estado_nombre' => "ENVIADO",
            'estado_descripcion' => 'Documento Enviado',
            'estado_fecha_ingreso' => $fecha->format('Y-m-d H:i:s'),
            'documento_iddocumento' => $iddocumento,
            'departamento_iddepartamento' => $iddepartamento,
            'usuario_usu_rut' => $usuario_usu_rut
        );
        return $this->Modelo->crearEstado($datos);
//        $this->Modelo->crearEstado($datos);      
//        $estado_nombre = "ENVIADO";
//        $estado_descripcion = 'Documento Enviado';
//        $estado_fecha_ingreso = $fecha->format('d-m-Y h:i:s');
//        
//        $documento_iddocumento = $ultimoDocumento->iddocumento;
//        $departamento_iddepartamento = $departamento->iddepartamento;
//        $usuario_usu_rut = $usuario_usu_rut;
    }

    public function crearEstadoProceso($iddocumento, $iddepartamento, $usuario_usu_rut) {

        $fecha = new DateTime();
        $datos = array(
            'estado_nombre' => "PROCESO",
            'estado_descripcion' => 'Documento Enviado',
            'estado_fecha_ingreso' => $fecha->format('Y-m-d H:i:s'),
            'documento_iddocumento' => $iddocumento,
            'departamento_iddepartamento' => $iddepartamento,
            'usuario_usu_rut' => $usuario_usu_rut
        );
        return $this->Modelo->crearEstado($datos);
    }

    public function generarPDF($iddocumento) {

        $fecha = new DateTime();

        $fechaDocu = $fecha->format('Y-m-d H:i:s');

        $options = new Options();
        $options->set('isJavascriptEnabled', TRUE);
        $options->set('isRemoteEnabled', TRUE);
        $pdf = new Dompdf($options);

//        echo json_encode(array('documento' => $documento));


        $departamento_iddepartamento = $this->session->userdata('user')->departamento_iddepartamento;
        $departamento = $this->Modelo->getDepartamento(intval($departamento_iddepartamento));
        $usuario_usu_rut = $this->session->userdata('user')->usu_rut;


        $documento = $this->Modelo->getDocumento($iddocumento);
        $usuario = $this->session->userdata('user');

        $ultimoArchivo = $this->Modelo->getArchivo($documento[0]->iddocumento);
        $ultimoArchivo = end($ultimoArchivo);

        $docu_tipo = strtoupper($documento[0]->docu_tipo);

        $ruta = $docu_tipo . "-" . $documento[0]->iddocumento;


        $path = 'http://192.168.1.35/repoEstado/Barcode/barcode_generator/Code128b/30/' . $ruta . '/true';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);


        $data = array(
            'departamento' => $departamento[0],
            'usuario' => $usuario,
            'nombreDocumento' => 'MEMORANDO',
            'archivo' => $ultimoArchivo,
            'documento' => $documento[0],
            'base64' => $base64,
            'codigo' => $ruta
        );
        $this->load->view('comprobanteDocumento', $data);

        $html = $this->output->get_output(['isRemoteEnabled' => true]);
        $this->load->library('Pdf');
        $pdf->loadHtml($html);
        $pdf->setPaper('letter', 'portrait');
        $pdf->render();
        // Output the generated PDF (1 = download and 0 = preview)
        $pdf->stream($ruta . '-' . $fechaDocu, array("Attachment" => 0));
    }

    public function getDocumentoEstado() {

        $iddocumento = $this->input->post('iddocumento');

        $estado = $this->Modelo->getDocumentoEstado($iddocumento);

        $existe = false;
        $resp = '';

        if (count($documento) > 0) {

            $fecha = new DateTime();

            $usuario = $this->session->userdata('user');
            $departamento = $this->Modelo->getDepartamento($usuario->departamento_iddepartamento);

            $datos = array(
                'estado_nombre' => "RECIBIDO",
                'estado_descripcion' => 'Documento Recibido',
                'estado_fecha_ingreso' => $fecha->format('Y-m-d H:i:s'),
                'documento_iddocumento' => $documento[0]->iddocumento,
                'departamento_iddepartamento' => $departamento[0]->iddepartamento,
                'usuario_usu_rut' => $usuario->usu_rut
            );

            if ($this->Modelo->crearEstado($datos) > 0) {
                $resp = 'Documento recibido con exito!';
                $existe = true;
            } else {
                $resp = 'Error de Estado';
            }
        } else {
            $resp = 'Error, de Documento';
        }
        echo json_encode(array('resp' => $resp, 'existe' => $existe));
    }

    public function getDocumentoUsuario() {
        $usuario = $this->session->userdata('user');
        $documentoUsuario = $this->Modelo->getDocumentoUsuario($usuario->usu_rut);

        $documentoEstado = '';
        $existe = false;
        $resp = '';

        if (count($documentoUsuario) > 0) {
            $existe = true;
            $resp = 'Datos Obtenidos';
        } else {
            $resp = 'Sin Datos';
        }
        echo json_encode(array('documentoUsuario' => $documentoUsuario, 'resp' => $resp, 'existe' => $existe, 'usuario' => $usuario, 'documentoEstado' => $documentoEstado));
    }

    public function getDocumentoPorDepartamento() {

        $iddepartamento = $this->input->post('departamento_iddepartamento');

        $usuarios = $this->Modelo->getUsuariosDepartamento($iddepartamento);

        $documentosDepartamentos = [];

        $resp = '';
        $existe = false;
        $mostrar = false;
        if (count($usuarios) > 0) {
            foreach ($usuarios as $usuario) {
                $documentos = $this->Modelo->getDocumentoUsuario($usuario->usu_rut);
                foreach ($documentos as $documento) {
                    $documento = $this->Modelo->getDocumentoCompleto($documento->iddocumento);
                    array_push($documentosDepartamentos, $documento[0]);
                }
                if (count($documentosDepartamentos) > 0) {
                    $existe = true;
                    $mostrar = true;
                }
            }
            if ($existe == true) {
                $resp = 'Documentos Encontrados';
                $mostrar = true;
            } else {
                $resp = 'Sin documentos';
                $mostrar = false;
            }
        } else {
            $resp = 'No se encontraron usuarios en el departamento';
            $mostrar = false;
        }
        echo json_encode(array('resp' => $resp, 'usuarios' => $usuarios, 'documentos' => $documentosDepartamentos, 'mostrar' => $mostrar));
    }

    public function getDocumentoPorCodigo() {

        $iddcoumento = $this->input->post('iddocumento');

        $documentos = $this->Modelo->getDocumento($iddcoumento);

        $existe = false;
        $resp = '';

        if (count($documentos) > 0) {
            $existe = true;
            $resp = 'Documento Encontrado';
        } else {
            $existe = false;
            $resp = 'Documento No encontrado';
        }
        echo json_encode(array('resp' => $resp, 'existe' => $existe, 'documentos' => $documentos));
    }

    public function do_upload() {

        $archivo = $this->input->post('archivo');

        $fecha = date('Y-m-d_H_i_s', time());
        $exito = false;
        $resp = '';

        if (($_FILES['archivo']['name']) != NULL) {
            $fecha = date('Y-m-d_H_i_s', time());

            $nombre_original = $_FILES['archivo']['name']; //foto.png
            $nombre_original = trim($nombre_original);
            $nombre_original = str_replace('"', '', $nombre_original);
            $nombre_original = str_replace(':', '', $nombre_original);
            $nombre_original = str_replace(',', '', $nombre_original);
            $nombre_original = str_replace(';', '', $nombre_original);
            $nombre_original = str_replace(' ', '', $nombre_original);
            $tmp = explode('.', $nombre_original); // [foto] [png]
            $extension = end($tmp);  // declarar ultimo elemento del arreglo
            $foto = $tmp[0] . '_' . $fecha . "." . $extension; // foto_2019-12-12_20:30:12.png

            $config['upload_path'] = './assets/archivos/';
            $config['allowed_types'] = 'pdf|docx|doc|xlsx|txt';
            $config['max_size'] = "5000000";
            $config['file_name'] = trim($foto);

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('archivo')) {
                $url = "assets/archivos/" . $foto;
                $resp = 'Archivo Subido con Exito';
                $exito = true;
            } else {
                $url = 'Error al subir Archivo';
                $resp = 'Error de Extension';
            }
        }

        echo json_encode(array(
            'nombre' => $nombre_original,
            'extension' => $extension,
            'url' => $url,
            'resp' => $resp,
            'exito' => $exito
        ));
    }

    public function verDocumentoBuscar() {

        $codigoDocumento = $this->input->post('codigoDocumento');
        $codigoDocumento = explode('-', $codigoDocumento);
        $iddcoumento = end($codigoDocumento);
        $documentos = $this->Modelo->getDocumento($iddcoumento);

        $existe = false;
        $resp = '';

        if (count($documentos) > 0) {
            $existe = true;
            $resp = 'Documento Encontrado';
        } else {
            $existe = false;
            $resp = 'Documento No encontrado';
        }
        echo json_encode(array('resp' => $resp, 'existe' => $existe, 'documentos' => $documentos));
    }

    public function terminarDoc() {

        $fecha = new DateTime();
        $tipo_documento = $this->input->post('tipo_documento');
        $tipo_documento = strtoupper($tipo_documento);
        $iddocumento = $this->input->post('iddocumento');
        $usuario = $this->session->userdata('user');
        $documento = $this->Modelo->getDocumento($iddocumento);

        $exito = false;
        $resp = '';

        if ($tipo_documento == 'DECRETO' || $tipo_documento == 'OFICIO' || $tipo_documento == 'RESOLUCION') {
            if ($documento[0]->docu_estado == 'TERMINADO') {
                $resp = 'YA TERMINADO';
            } else {
                $documento = $this->Modelo->getDocumento($iddocumento);

                $datos = array(
                    'docu_estado' => 'TERMINADO'
                );
                $updateDocumento = $this->Modelo->updateDocumento($iddocumento, $datos);

                if ($updateDocumento > 0) {

                    $datoUltimo = array(
                        'estado_nombre' => 'RECIBIDO',
                        'estado_fecha_egreso' => $fecha->format('Y-m-d H:i:s')
                    );

                    $ultimoEstado = $this->Modelo->getUltimoEstado($documento[0]->iddocumento);

                    if ($this->Modelo->updateUltimoEstadoPendientes($ultimoEstado[0]->idestado, $datoUltimo) > 0) {
                        $datos = array(
                            'estado_nombre' => "TERMINADO",
                            'estado_descripcion' => 'Documento Recibido',
                            'estado_fecha_ingreso' => $fecha->format('Y-m-d H:i:s'),
                            'documento_iddocumento' => $documento[0]->iddocumento,
                            'departamento_iddepartamento' => $usuario->departamento_iddepartamento,
                            'usuario_usu_rut' => $usuario->usu_rut
                        );

                        if ($this->Modelo->crearEstado($datos)) {
                            $resp = 'Documento Terminado';
                            $exito = true;
                        } else {
                            $resp = 'Error Crear Estado';
                        }
                    } else {
                        $resp = 'Error UpdateUltimo Estado';
                    }
                } else {
                    $resp = 'Error UpdateDocumento';
                }
            }
        } else {
            $resp = 'Tipo Documento Inválido';
        }

        echo json_encode(array('resp' => $resp, 'exito' => $exito));
    }
    
    public function eliminarDocumento(){
        
        $iddocumento = $this->input->post('iddocumento');   
        
        $eliminarEstados = $this->Modelo->eliminarEstados(intval($iddocumento));
        
        $eliminarDocumento = $this->Modelo->eliminarDocumento(intval($iddocumento));  
        
        $resp = '';
        
        echo json_encode(array('estado' => $eliminarEstados, 'documento' =>$eliminarDocumento));
        
        
    }

    
}
