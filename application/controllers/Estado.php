<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Estado
 *
 * @author EXTEORICO
 */
class Estado extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Modelo');

    }

    public function getDoc() {

        $usuario_usu_rut = $this->session->userdata('user')->usu_rut;
        $estados = $this->Modelo->verDoc($usuario_usu_rut);
        $documentos = [];

        $documentos = $this->Modelo->getDocumentoUsuario($usuario_usu_rut);

        $estadosUnicos = [];

        foreach ($estados as $estado) {
            array_push($estadosUnicos, $estado->idestado);
        }

        $estadosUnicos = array_unique($estadosUnicos);

        $estados = [];

        foreach ($estadosUnicos as $estado) {
            $arr = $this->Modelo->getEstadosId($estado);
            array_push($estados, $arr[0]);
        }

        $docUnicos = [];

        foreach ($estados as $estado) {
            array_push($docUnicos, $estado->iddocumento);
        }

        $docUnicos = array_unique($docUnicos);

        $documentos = [];

        foreach ($docUnicos as $doc) {
            $documento = $this->Modelo->getDocumentoCompleto($doc);
            array_push($documentos, $documento[0]);
        }
//
//        $documentos = [];
//
//        foreach ($estados as $estado) {
//            $documento = $this->Modelo->getDocumentoCompleto($estado->iddocumento);
//            array_push($documentos, $documento[0]);
//        }
//
//        $docuUnico = [];
//
//        foreach ($documentos as $doc) {
//            array_push($docuUnico, $doc->iddocumento);
//        }
//
//        $docuUnico = array_unique($docuUnico);
//        
//        $documentos = [];
//
//        foreach ($docuUnico as $doc) {
//            $documento = $this->Modelo->getDocumentoCompleto($estado->iddocumento);
//            array_push($documentos, $documento[0]);
//        }
//        foreach ($estados as $e) {
//            $documento = $this->Modelo->getEstadoDocumentoUsuario($usuario_usu_rut, $e->documento_iddocumento);
//            array_push($documentos, $documento[0]);
//        }
//
//        $final = array();
//
//        foreach ($documentos as $current) {
//            if (!in_array($current, $final)) {
//                $final[] = $current;
//            }
//        }
//
//        $largo = sizeof($final);
//        
//        $ultimosEstados = [];
//        
//        for ($i = 0; $i < $largo ; $i++){
//           $ultimoEstado = $this->Modelo->getUltimoEstado($final[$i]->documento_iddocumento);
//           $usuarioUltimoEstado = $this->Modelo->getUsuario($ultimoEstado[0]->usuario_usu_rut);
//           $usuarioPrimeroEstado = $this->Modelo->getDocumentoCompleto($final[$i]->iddocumento);
//           $final[$i]->ultimoEstado = $ultimoEstado;
//           $final[$i]->primerUsuario = $usuarioPrimeroEstado;
//           $final[$i]->ultimoUsuario = $usuarioUltimoEstado;
//        }      
//           
//        
//        foreach ($final as $f) {
//            $ultimoEstado = $this->Modelo->getUltimoEstado($f->documento_iddocumento);
//            array_push($final, $ultimoEstado);
//        }



        echo json_encode(array('documentos' => $documentos));
    }

    public function recibirDocumento() {

        $documento_iddocumento = $this->input->post('iddocumento');
        $tipo_documento = $this->input->post('tipo_documento');
        $usuario = $this->session->userdata('user');


        $documento = $this->Modelo->getDocumento($documento_iddocumento);

        $existe = false;
        $resp = '';
        $ultimoEstado = '';

        $documentoRecibido = $this->Modelo->getEstadoRecibido($documento_iddocumento, $usuario->usu_rut);

        if (count($documento) > 0) {
            if ($documento[0]->docu_estado == 'TERMINADO') {
                $resp = 'Documento Ya Terminado';
            } else {

                $fecha = new DateTime();
                $usuario = $this->session->userdata('user');
////            $terminarDocumento = $this->terminarDocumento($usuario->usu_rut, $documento_iddocumento);
                $departamento = $this->Modelo->getDepartamento($usuario->departamento_iddepartamento);

                if ($tipo_documento == 'MEMORANDO' || $tipo_documento == 'CIRCULAR' || $tipo_documento == 'OTROS') {

//                $estadoDocumento = $this->Modelo->updateEstadoDocumento($documento[0]->iddocumento, $usuario->usu_rut);

                    $datos = array(
                        'estado_nombre' => "RECIBIDO",
                        'estado_fecha_egreso' => $fecha->format('Y-m-d H:i:s')
                    );
                    $row = $this->Modelo->updateEstadoUsuarioDocumento($usuario->usu_rut, $documento_iddocumento, $datos);
                    if ($row > 0) {
                        $resp = 'Mensaje recibido con exito!';
                        $existe = true;
                    } else {
                        $resp = 'ERROR Mensaje!';
                    }
                } else {
                    if (count($documentoRecibido) > 0) {
                        $resp = 'Documento Ya recibido';
                    } else {


                        $ultimoEstado = $this->getUltimoEstado($documento_iddocumento);
                        $datos = array(
                            'estado_nombre' => "EN PROCESO",
                            'estado_descripcion' => 'Documento Recibido',
                            'estado_fecha_ingreso' => $fecha->format('Y-m-d H:i:s'),
                            'documento_iddocumento' => $documento[0]->iddocumento,
                            'departamento_iddepartamento' => $departamento[0]->iddepartamento,
                            'usuario_usu_rut' => $usuario->usu_rut
                        );

                        if (count($ultimoEstado) > 0) {
                            $idUltimoEstado = $ultimoEstado[0]->idestado;


                            $updateUltimoEstado = $this->Modelo->updateUltimoEstado($idUltimoEstado);

                            if ($this->Modelo->crearEstado($datos) > 0) {
                                $resp = 'Documento recibido con exito!';
                                $existe = true;
                            } else {
                                $resp = 'Error de Creacion de Estado';
                            }
                        } else {
                            $resp = 'Error de UltimoEstado';
                        }
                    }
                }
            }
        } else {
            $resp = 'Error de Codigo';
        }

        echo json_encode(array('resp' => $resp, 'existe' => $existe, 'ultimoEstado' => $ultimoEstado));
    }

    public function getUltimoEstado($documento_iddocumento) {

        $fecha = new DateTime();
        $estado_fecha_egreso = $fecha->format('Y-m-d H:i:s');

        $estado = $this->Modelo->getUltimoEstado($documento_iddocumento);
        if (count($estado) > 0) {
            $insert = $this->Modelo->updateEstadoFecha($estado[0]->idestado, $estado_fecha_egreso);
            return $estado;
        } else {
            return 0;
        }
    }

    public function getEstados() {

        $iddocumento = $this->input->post('iddocumento');

        $estados = $this->Modelo->getEstadoCompletoDocumento($iddocumento);


        $resp = '';
        $existe = false;

        if (count($estados) > 0) {
            $resp = 'Datos encontrados';
            $existe = true;
        } else {
            $resp = 'Error de Datos o Sin Datos!';
        }
        echo json_encode(array('resp' => $resp, 'existe' => $existe, 'estados' => $estados));
    }

    public function terminarDocumento($usu_rut, $iddocumento) {

        $usuario = $this->session->userdata('user');
        $documentosUsuario = $this->Modelo->getDocumentoUsuario($usuario->usu_rut);

        $resp = '';
        $terminado = false;

        foreach ($documentosUsuario as $docu) {
            if ($docu->iddocumento == $iddocumento) {
                $datos = array(
                    'docu_estado' => 'TERMINADO'
                );
                $terminar = $this->Modelo->terminarDocumento($iddocumento, $datos);

                if ($terminar > 0) {
                    $resp = 'Documento Terminado';
                    $terminado = true;
                } else {
                    $resp = 'Error al Terminar';
                }
                break;
            }
        }


        return $terminado;
    }

    public function getDocumentosNotificaciones() {

        $usuario = $this->session->userdata('user');

        $estadoEn = 'EN PROCESO';
        $estadoPro = 'PROCESO';
        $estados = $this->Modelo->getEstadoUnicoUsuario($usuario->usu_rut, $estadoEn);
        $estadosMen = $this->Modelo->getEstadoUnicoUsuario($usuario->usu_rut, $estadoPro);

        echo json_encode(array('estados' => $estados, 'estadosMen' => $estadosMen));
    }

    public function faltantesDepartamentos() {

        $departamentos = $this->Modelo->getDepartamentos();

        $deptosEstadosProceso = [];

        $est = '';


        foreach ($departamentos as $depto) {

            $usuarios = $this->Modelo->getUsuariosDeptoDocu(intval($depto->iddepartamento));
            $est = $usuarios;
            $cantidadesDepartamento = 0;

            foreach ($usuarios as $usuario) {

                $estados = $this->Modelo->getEstadosMenu($usuario->usu_rut);

                $cantidad = count($estados);
                $cantidadesDepartamento = $cantidadesDepartamento + $cantidad;
            }

            $datos = array(
                'iddepartamento' => $depto->iddepartamento,
                'depto_nombre' => $depto->depto_nombre,
                'documentosProceso' => $cantidadesDepartamento
            );

            array_push($deptosEstadosProceso, $datos);
        }

        echo json_encode(array('datos' => $deptosEstadosProceso, 'estados' => $est));
    }

    public function faltantesUsuarios() {

        $departamentos = $this->Modelo->getDepartamentos();
        $deptosEstadosProceso = [];

        $usuarios = $this->Modelo->getUsuarios();

        foreach ($usuarios as $usuario) {
            $estados = $this->Modelo->getEstadosMenu($usuario->usu_rut);
            $cantidad = count($estados);

            $nombre = $usuario->usuario_nombre_pri;
            $apellido = $usuario->usuario_nombre_secu;

            $datos = array(
                'nombre' => $apellido . ' ' . $nombre,
                'apellido' => $apellido,
                'cantidad' => $cantidad
            );

            array_push($deptosEstadosProceso, $datos);
        }

        echo json_encode(array('datos' => $deptosEstadosProceso));
    }

    public function exportarExcel() {

        $departamentos = $this->Modelo->getDepartamentos();
        $deptosEstadosProceso = [];

        $usuarios = $this->Modelo->getUsuarioCompleto();

        $usuarioFinal = [];

        foreach ($usuarios as $usuario) {
            $estados = $this->Modelo->getEstadosMenu($usuario->usu_rut);
            $cantidad = count($estados);

            $nombre = $usuario->usuario_nombre_pri;
            $apellido = $usuario->usuario_nombre_secu;
            
            $datos = array(
                'cantidad' => $cantidad
            );
            
            array_push($usuario, $datos);
            array_push($usuarioFinal, $usuario);
        }
        
        $aux = [];

        foreach ($usuarioFinal as $key => $row) {
            $aux[$key] = $row['cantidad'];
        }
        
        array_multisort($aux, SORT_ASC, $usuarioFinal);

        echo json_encode(array('resp' => $aux));

//        if (count($nuevoP) > 0) {
//            $this->excel->setActiveSheetIndex(0);
//            $this->excel->getActiveSheet()->setTitle('Usuarios');
//
//
//            $cont = 1;
//            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
//            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
//            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
//            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(7);
//            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(7);
//            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
//            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(7);
//            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(8);
//
//            $this->excel->getActiveSheet()->getStyle("A{$cont}")->getFont()->setBold(true);
//            $this->excel->getActiveSheet()->getStyle("B{$cont}")->getFont()->setBold(true);
//            $this->excel->getActiveSheet()->getStyle("C{$cont}")->getFont()->setBold(true);
//            $this->excel->getActiveSheet()->getStyle("D{$cont}")->getFont()->setBold(true);
//            $this->excel->getActiveSheet()->getStyle("E{$cont}")->getFont()->setBold(true);
//            $this->excel->getActiveSheet()->getStyle("F{$cont}")->getFont()->setBold(true);
//            $this->excel->getActiveSheet()->getStyle("G{$cont}")->getFont()->setBold(true);
//            $this->excel->getActiveSheet()->getStyle("H{$cont}")->getFont()->setBold(true);
//
//            $this->excel->getActiveSheet()->getStyle("A{$cont}")->getFont()->setSize(9);
//            $this->excel->getActiveSheet()->getStyle("B{$cont}")->getFont()->setSize(9);
//            $this->excel->getActiveSheet()->getStyle("C{$cont}")->getFont()->setSize(9);
//            $this->excel->getActiveSheet()->getStyle("D{$cont}")->getFont()->setSize(9);
//            $this->excel->getActiveSheet()->getStyle("E{$cont}")->getFont()->setSize(9);
//            $this->excel->getActiveSheet()->getStyle("F{$cont}")->getFont()->setSize(9);
//            $this->excel->getActiveSheet()->getStyle("G{$cont}")->getFont()->setSize(9);
//            $this->excel->getActiveSheet()->getStyle("H{$cont}")->getFont()->setSize(9);
//
//            //Definimos los títulos de la cabecera.
//            $this->excel->getActiveSheet()->setCellValue("A{$cont}", 'ID');
//            $this->excel->getActiveSheet()->setCellValue("B{$cont}", 'NOMBRE');
//            $this->excel->getActiveSheet()->setCellValue("C{$cont}", 'DESCRIPCION');
//            $this->excel->getActiveSheet()->setCellValue("D{$cont}", 'STOCK');
//            $this->excel->getActiveSheet()->setCellValue("E{$cont}", 'VENTA');
//            $this->excel->getActiveSheet()->setCellValue("F{$cont}", 'COMPRA');
//            $this->excel->getActiveSheet()->setCellValue("G{$cont}", 'CODIGO');
//            $this->excel->getActiveSheet()->setCellValue("H{$cont}", 'ESTADO');
//
//
//            foreach ($nuevoP as $p) {
//                $cont++;
//
//                $this->excel->getActiveSheet()->getStyle("A{$cont}")->getFont()->setSize(9);
//                $this->excel->getActiveSheet()->getStyle("B{$cont}")->getFont()->setSize(9);
//                $this->excel->getActiveSheet()->getStyle("C{$cont}")->getFont()->setSize(9);
//                $this->excel->getActiveSheet()->getStyle("D{$cont}")->getFont()->setSize(9);
//                $this->excel->getActiveSheet()->getStyle("E{$cont}")->getFont()->setSize(9);
//                $this->excel->getActiveSheet()->getStyle("F{$cont}")->getFont()->setSize(9);
//                $this->excel->getActiveSheet()->getStyle("G{$cont}")->getFont()->setSize(9);
//                $this->excel->getActiveSheet()->getStyle("H{$cont}")->getFont()->setSize(9);
//
//
//                $this->excel->getActiveSheet()->getStyle("D{$cont}")->getFont()->setBold(true);
//
//                $this->excel->getActiveSheet()->setCellValue("A{$cont}", $p->idproducto);
//                $this->excel->getActiveSheet()->setCellValue("B{$cont}", $p->nombre);
//                $this->excel->getActiveSheet()->setCellValue("C{$cont}", $p->descripcion);
//                $this->excel->getActiveSheet()->setCellValue("D{$cont}", $p->stock);
//                $this->excel->getActiveSheet()->setCellValue("E{$cont}", $p->p_venta);
//                $this->excel->getActiveSheet()->setCellValue("F{$cont}", $p->p_compra);
//                $this->excel->getActiveSheet()->setCellValue("G{$cont}", $p->codigo);
//                $this->excel->getActiveSheet()->setCellValue("H{$cont}", $p->estado);
//            }
//            $hora = strftime("%H:%M:%S", time());
//            $fecha = strftime("%Y-%m-%d", time());
//            $archivo = "INVENTARIOFecha:{$fecha}Hora:{$hora}.xls";
//            header('Content-Type: application/vnd.ms-excel');
//            header('Content-Disposition: attachment;filename="' . $archivo . '"');
//            header('Cache-Control: max-age=0');
//            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
//            $objWriter->save('php://output');
//        } else {
//            echo 'No se han encontrado llamadas';
//            exit;
//        }
    }

}
