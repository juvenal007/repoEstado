<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Archivo
 *
 * @author EXTEORICO
 */
class Archivo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->Model('Modelo');
    }

    public function getArchivo() {

        $iddocumento = $this->input->post('iddocumento');
        $archivo = $this->Modelo->getArchivo($iddocumento);

        echo json_encode(array('archivo' => $archivo));
    }

    public function agregarArchivo() {

        $fecha = new DateTime();
        $archivo_fecha_ingreso = $fecha->format('Y-m-d H:i:s');
        $documento_iddocumento = $this->input->post('documento_iddocumento');
        $archivo_nombre = $this->input->post('archivo_nombre');
        $archivo_extension = $this->input->post('archivo_extension');
        $archivo_url = $this->input->post('archivo_url');

        $archivo = $this->Modelo->crearArchivo($archivo_nombre, $archivo_extension, $archivo_url, $archivo_fecha_ingreso, $documento_iddocumento);

        $resp = '';
        $existe = false;

        if ($archivo > 0) {
            $existe = true;
            $resp = 'Archivo agregado con exito';
        } else {
            $resp = 'Error al cargar el archivo';
        }
        echo json_encode(array('existe' => $existe, 'resp' => $resp, 'archivo' => $archivo));
    }

}
