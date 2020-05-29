<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Login
 *
 * @author EXTEORICO
 */
class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Modelo');
    }

    public function iniciarSesion() {

        $usuario = $this->input->post("usuario");
        $password = $this->input->post("password");
        $existe = false;
        $ruta = '';
        $respuesta = '';
        if (isset($usuario) && isset($password)) {
            $user = $this->Modelo->iniciarSesion($usuario, $password);
            if (count($user) > 0) {
                $existe = true;
                $respuesta = "Usuario Válido";
                $ruta = "menu";
                if ($user[0]->usuario_tipo === 'admin') {                  
                    $this->session->set_userdata('user', $user[0]);
                } else {                  
                    $this->session->set_userdata('user', $user[0]);
                }                 
            } else {              
                $respuesta = "Usuario Inválido";
            }
            echo json_encode(array("value" => $respuesta, "ruta" => $ruta, "existe" => $existe));
        }
    }

}
