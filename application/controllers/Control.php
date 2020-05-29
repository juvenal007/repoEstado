<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "/third_party/dompdf/autoload.inc.php";

use Dompdf\Dompdf;
use Dompdf\Options;
use TCPDF\TCPDF;

class Control extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Modelo');
        $this->load->model('Pdf');
    }

    public function cargarSession($v) {
        if ($this->session->userdata('user')) {
            $this->load->view($v);
        } else {
            redirect(base_url());
        }
    }

    public function cargarSessionDatos($v, $d) {
        if ($this->session->userdata('user')) {
            $this->load->view($v, $d);
        } else {
            redirect(base_url());
        }
    }

    public function index() {
        $this->load->view('login');
    }

    public function menu() {
        $this->cargarSession('menu');
    }

    public function Tcpdf() {
        $this->cargarSession('Tpdf');
    }

    public function crearUsuario() {
        $this->cargarSession('crearUsuario');
    }

    public function crearDepartamento() {
        $this->cargarSession('crearDepartamento');
    }

    public function enviarDocumento() {
        $this->cargarSession('enviarDocumento');
    }

    public function crearDocumento() {
        $this->cargarSession('crearDocumento');
    }

    public function recibirDocumento() {
        $this->cargarSession('recibirDocumento');
    }

    public function verDocumento() {
        $this->cargarSession('verDocumento');
    }

    public function verEstados($iddocumento) {
        $datos['iddocumento'] = $iddocumento;        
        $this->cargarSessionDatos('verEstados', $datos);
    }

    public function verMensajes($iddocumento) {
        $datos['iddocumento'] = $iddocumento;   
        $this->cargarSessionDatos('verMensajes', $datos);
    }

    public function porDepartamento() {
        $this->cargarSession('porDepartamento');
    }

    public function porUsuario() {
        $this->cargarSession('porUsuario');
    }

    public function porCodigo() {
        $this->cargarSession('porCodigo');
    }

    public function codigoBarra() {
        $this->cargarSession('codigoBarra');
    }

    public function listaUsuarios() {
        $this->cargarSession('listaUsuarios');
    }

    public function listaDepartamentos() {
        $this->cargarSession('listaDepartamentos');
    }

    public function logout() {
        $this->load->view('login');        
    }

    public function perfilUsuario() {
        $this->cargarSession('perfilUsuario');
    }

    public function pendientes() {
        $this->cargarSession('pendientes');
    }

    public function pendientesMen() {
        $this->cargarSession('pendientesMensaje');
    }

    public function terminarDocumento() {
        $this->cargarSession('terminarDocumento');
    }

    public function documentosPendientes() {
        $this->cargarSession('documentosPendientes');
    }

}
