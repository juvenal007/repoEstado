<?php

require_once APPPATH . "/third_party/dompdf/autoload.inc.php";
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Usuario
 *
 * @author EXTEORICO
 */
class Usuario extends CI_Controller {

    public $archivo;

    public function __construct() {
        parent::__construct();
        $this->load->model('Modelo');
        $this->archivo = 'assets/fotoPerfil/';
    }

    public function crearUsuario() {

        $usu_rut = $this->input->post('usu_rut');
        $usuario_nombre_pri = $this->input->post('usuario_nombre_pri');
        $usuario_nombre_secu = $this->input->post('usuario_nombre_secu');
        $usuario_apellido_pat = $this->input->post('usuario_apellido_pat');
        $usuario_apellido_mat = $this->input->post('usuario_apellido_mat');
        $usuario_tipo = $this->input->post('usuario_tipo');
        $usuario_anexo = $this->input->post('usuario_anexo');
        $usuario_correo = $this->input->post('usuario_correo');
        $usuario_funcion = $this->input->post('usuario_funcion');
        $usuario_img = $this->input->post('usuario_img');
        $departamento_iddepartamento = $this->input->post('departamento_iddepartamento');


        $resp = '';
        $existe = false;
        $usu_rut = str_replace('-', "", $usu_rut);
        $usu_rut = str_replace('.', "", $usu_rut);
        $usuario = $this->Modelo->crearUsuario($usu_rut, $usuario_nombre_pri, $usuario_nombre_secu, $usuario_apellido_pat, $usuario_apellido_mat, $usuario_tipo, $usuario_anexo, $usuario_correo, $usuario_funcion, $usuario_img, $departamento_iddepartamento);

        if ($usuario > 0) {
            $resp = 'Usuario creado con exito';
            $existe = true;
        }


        echo json_encode(array('resp' => $resp, 'existe' => $existe));
    }

    public function validarRut() {
        $rut = $this->input->post('usu_rut');
        echo json_encode(array('resp' => $this->validarRut2($rut)));
    }

    public function validarRut2($rut) {
        if (!preg_match("/^[0-9.]+[-]?+[0-9kK]{1}/", $rut)) {
            return false;
        }
        $rut = preg_replace('/[\.\-]/i', '', $rut);
        $dv = substr($rut, -1);
        $numero = substr($rut, 0, strlen($rut) - 1);
        $i = 2;
        $suma = 0;
        foreach (array_reverse(str_split($numero)) as $v) {
            if ($i == 8)
                $i = 2;
            $suma += $v * $i;
            ++$i;
        }
        $dvr = 11 - ($suma % 11);
        if ($dvr == 11)
            $dvr = 0;
        if ($dvr == 10)
            $dvr = 'K';
        if ($dvr == strtoupper($dv))
            return true;
        else
            return false;
    }

    public function getUsuario() {
        echo json_encode($this->Modelo->getUsuario());
    }

    public function getUsuariosDepartamento() {
        $iddepartamento = $this->input->post('iddepartamento');
        echo json_encode($this->Modelo->getUsuariosDepartamento($iddepartamento));
    }

    public function getDocumentoPorUsuario() {

        $usu_rut = $this->input->post('usu_rut');
        $documentos = $this->Modelo->getDocumentoUsuario($usu_rut);
        $existe = false;
        $resp = '';

        if (count($documentos) > 0) {
            $existe = true;
            $resp = 'Documentos encontrados';
        } else {
            $existe = false;
            $resp = 'Documentos No encontrados';
        }

        echo json_encode(array('resp' => $resp, 'existe' => $existe, 'documentos' => $documentos));
    }

    public function subirFotoUsuario() {

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

            $config['upload_path'] = './assets/fotoPerfil/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = "5000000";
            $config['file_name'] = $foto;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('archivo')) {
                $url = "assets/fotoPerfil/" . $foto;
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

    public function obtenerUsuario() {

        $usuario = $this->session->userdata('user');
        $departamento = $this->Modelo->getDepartamento($usuario->departamento_iddepartamento);
        $usuario = $this->Modelo->getUsuario($usuario->usu_rut);


        echo json_encode(array('usuario' => $usuario[0], 'departamento' => $departamento[0]));
    }

    public function editarPerfil() {



        $usuario_correo = $this->input->post('usuario_correo');
        $usuario_anexo = $this->input->post('usuario_anexo');
        $usuario_img = $this->input->post('usuario_img');

//        $psg = $usuario->usu_password;

        $ps1 = $this->input->post('pass1');
        $ps2 = $this->input->post('pass2');
        $ps1 = $ps1;
        $ps1 = trim($ps1);
        $ps1 = str_replace('"', '', $ps1);
        $ps1 = str_replace(':', '', $ps1);
        $ps1 = str_replace(',', '', $ps1);
        $ps1 = str_replace(';', '', $ps1);
        $ps1 = str_replace(' ', '', $ps1);
        $ps2 = $ps2;
        $ps2 = trim($ps2);
        $ps2 = str_replace('"', '', $ps2);
        $ps2 = str_replace(':', '', $ps2);
        $ps2 = str_replace(',', '', $ps2);
        $ps2 = str_replace(';', '', $ps2);
        $ps2 = str_replace(' ', '', $ps2);

        
        $exito = false;
        $usuarioSes = $this->session->userdata('user');
        $resp = '';
        $res = '';
        $usu_rut = $usuarioSes->usu_rut;

        if (empty($ps1) && empty($ps2)) {

            $datos = array(
                'usuario_anexo' => $usuario_anexo,
                'usuario_correo' => $usuario_correo,
                'usuario_img' => $usuario_img
            );
            
            $res = $this->Modelo->updateUsuario($usu_rut, $datos);

            if ($res > 0) {
                $resp = 'Datos Actualizados1';
                $exito= true;
            } else {
                $resp = 'Error de datos1';
            }
        } elseif ($ps1 == $ps2) {

            $datos = array(
                'usuario_password' => $ps1,
                'usuario_anexo' => $usuario_anexo,
                'usuario_correo' => $usuario_correo,
                'usuario_img' => $usuario_img
            );

            $res = $this->Modelo->updateUsuario($usu_rut, $datos);

            if ($res > 0) {
                $resp = 'Datos Actualizados2';
                $exito = true;
            } else {
                $resp = 'Error de datos2';
            }
        } else {
            $resp = 'Contraseña Nueva no coinciden';
        }



        echo json_encode(array('exito' => $exito, 'resp' => $resp, 'usuario_correo' => $usuario_correo));
    }

}
