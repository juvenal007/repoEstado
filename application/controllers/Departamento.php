<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Departamento
 *
 * @author EXTEORICO
 */
class Departamento extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Modelo');

        $this->output->set_content_type('application/json');
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header('Access-Control-Allow-Methods: GET, OPTIONS');
        $this->output->set_header('Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding');
    }

    public function crearDepartamento() {

        $depto_nombre = $this->input->post('depto_nombre');
        $depto_descripcion = $this->input->post('depto_descripcion');
        $depto_telefono = $this->input->post('depto_telefono');

        $depto_img = $this->input->post('depto_img');

        $resp = '';

        // VALIDAR DATOS

        $depto = $this->Modelo->crearDepartamento($depto_nombre, $depto_descripcion, $depto_telefono, $depto_img);

        if ($depto > 0) {
            $resp = 'Departamento creado con exito';
        }

        echo json_encode(array('resp' => $resp));
    }

    public function getDepartamentos() {
        echo json_encode($this->Modelo->getDepartamentos());
    }

    public function subirFotoDepto() {

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

            $config['upload_path'] = './assets/fotoDepto/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = "5000000";
            $config['file_name'] = $foto;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('archivo')) {
                $url = "assets/fotoDepto/" . $foto;
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

    public function editarDepartamento() {
        
        $iddepartamento = $this->input->post('iddepartamento');        
        $depto_nombre = $this->input->post('depto_nombre');
        $depto_descripcion = $this->input->post('depto_descripcion');
        $depto_telefono = $this->input->post('depto_telefono');
        $depto_img = $this->input->post('depto_img');
        
        $resp = '';
        $existe = false;
        
        $datos = array(
            'depto_nombre' => $depto_nombre,
            'depto_descripcion' => $depto_descripcion,
            'depto_telefono' => $depto_telefono,
            'depto_img' => $depto_img
        );        
        
        $editDepto = $this->Modelo->updateDepartamento($iddepartamento, $datos);
        
        if ($editDepto > 0) {
            $resp = 'Departamento editado con exito';
            $existe = true;
        }else{
            $resp = 'error de datos';
        }
        
        echo json_encode(array('resp' => $resp, 'existe' => $existe));
        
        
    }

}
