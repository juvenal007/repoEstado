<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Modelo
 *
 * @author EXTEORICO
 */
class Modelo extends CI_Model {

    public $usuario, $departamento, $documento, $archivo;

    public function __construct() {
        parent::__construct();
        $this->usuario = "usuario";
        $this->departamento = "departamento";
        $this->documento = "documento";
        $this->estado = "estado";
        $this->archivo = "archivo";
    }

    public function iniciarSesion($usuario, $password) {
        $this->db->where('usu_rut', $usuario);
        $this->db->where('usuario_password', $password);
        return $this->db->get($this->usuario)->result();
    }

    // ****************** ESTADO *******************//

    public function eliminarEstados($iddocumento) {
        $this->db->where('documento_iddocumento', $iddocumento);        
        return $this->db->delete($this->estado);
    }

    public function updateUltimoEstado($idestado) {
        $datos = array(
            'estado_nombre' => 'RECIBIDO'
        );

        $this->db->where('idestado', $idestado);
        $this->db->update($this->estado, $datos);
        return $this->db->affected_rows();
    }

    public function getEstadoRecibido($documento_iddocumento, $usuario_usu_rut) {
        $this->db->where('usuario_usu_rut', $usuario_usu_rut);
        $this->db->where('documento_iddocumento', $documento_iddocumento);
        return $this->db->get($this->estado)->result();
    }

    public function getEstadoUnicoUsuario($usu_rut, $estado) {
        $this->db->distinct();
        $this->db->select();
        $this->db->group_by('documento_iddocumento');
        $this->db->join('documento', 'documento.iddocumento = estado.documento_iddocumento');
        $this->db->join('usuario', 'usuario.usu_rut = estado.usuario_usu_rut');
        $this->db->where('estado.usuario_usu_rut', $usu_rut);
        $this->db->where('estado.estado_nombre', $estado);
        return $this->db->get($this->estado)->result();
    }

    public function verDoc($usuario_usu_rut) {
        $this->db->join('documento', 'documento.iddocumento = estado.documento_iddocumento');
        $this->db->join('departamento', 'departamento.iddepartamento = estado.departamento_iddepartamento');
        $this->db->join('usuario', 'usuario.usu_rut = estado.usuario_usu_rut');
        $this->db->where('estado.usuario_usu_rut', $usuario_usu_rut);
        $this->db->order_by('estado_fecha_ingreso', 'ASC');
        return $this->db->get($this->estado)->result();
    }

    public function crearEstado($datos) {
        return $this->db->insert($this->estado, $datos);
    }

    public function getEstados($iddocumento) {
        $this->db->join('departamento', 'departamento.iddepartamento = estado.departamento_iddepartamento');
        $this->db->join('usuario', 'usuario.usu_rut = estado.usuario_usu_rut');
        $this->db->where('documento_iddocumento', $iddocumento);
        $this->db->order_by('idestado', 'ASC');
        return $this->db->get($this->estado)->result();
    }

    public function getEstado($idestado) {
        $this->db->where('idestado', $idestado);
        $this->db->where('estado_nombre', "RECIBIDO");
        $this->db->order_by('idestado', 'ASC');
        return $this->db->get($this->estado)->result();
    }

    public function getEstadoCompleto($idestado) {
        $this->db->where('idestado', $idestado);
        $this->db->join('departamento', 'departamento.iddepartamento = estado.departamento_iddepartamento');
        $this->db->join('usuario', 'usuario.usu_rut = estado.usuario_usu_rut');
        $this->db->order_by('idestado', 'ASC');
        return $this->db->get($this->estado)->result();
    }

    public function getEstadoCompletoDocumento($iddocumento) {
        $this->db->where('documento_iddocumento', $iddocumento);
        $this->db->join('departamento', 'departamento.iddepartamento = estado.departamento_iddepartamento');
        $this->db->join('usuario', 'usuario.usu_rut = estado.usuario_usu_rut');
        $this->db->join('documento', 'documento.iddocumento = estado.documento_iddocumento');
        $this->db->order_by('idestado', 'ASC');
        return $this->db->get($this->estado)->result();
    }

    public function getEstadoDocumentoUsuario($usu_rut, $iddocumento) {
        $this->db->join('usuario', 'usuario.usu_rut = estado.usuario_usu_rut');
        $this->db->join('departamento', 'departamento.iddepartamento = estado.departamento_iddepartamento');
        $this->db->join('documento', 'documento.iddocumento = estado.documento_iddocumento');
        $this->db->where('estado.usuario_usu_rut', $usu_rut);
        $this->db->where('estado.documento_iddocumento', $iddocumento);
        $this->db->order_by('idestado', 'ASC');
        return $this->db->get($this->estado)->result();
    }

    public function updateEstadoUsuarioDocumento($usu_rut, $iddocumento, $datos) {
        $this->db->where('usuario_usu_rut', $usu_rut);
        $this->db->where('documento_iddocumento', $iddocumento);
        $this->db->update($this->estado, $datos);
        return $this->db->affected_rows();
    }

    public function getEstadosDocumentos($usuario_usu_rut) {
        $this->db->where('usuario_usu_rut', $usuario_usu_rut);
        $this->db->where('estado_nombre', "RECIBIDO");
        $this->db->join('documento', 'documento.iddocumento = estado.documento_iddocumento');
        $this->db->order_by('idestado', 'ASC');
        return $this->db->get($this->estado)->result();
    }

    public function getUltimoEstado($documento_iddocumento) {
        //  $this->db->where('usuario_usu_rut', $usuario_usu_rut);
        $this->db->where('documento_iddocumento', $documento_iddocumento);
        $this->db->order_by('idestado', 'DESC');
        return $this->db->get($this->estado, 1)->result();
    }

    public function updateEstadoFecha($idestado, $estado_fecha_egreso) {
        $datos = array(
            'estado_fecha_egreso' => $estado_fecha_egreso
        );
        $this->db->where('idestado', $idestado);
        $this->db->update($this->estado, $datos);
    }

    public function getEstadosId($idestado) {
        $this->db->join('documento', 'documento.iddocumento = estado.documento_iddocumento');
        $this->db->where('idestado', $idestado);
        return $this->db->get($this->estado)->result();
    }

    public function getEstadosMenu($usuario_usu_rut) {
        $this->db->where('usuario_usu_rut', $usuario_usu_rut);
        $this->db->where('estado_nombre', 'EN PROCESO');
        return $this->db->get($this->estado)->result();
    }

    public function updateUltimoEstadoPendientes($idestado, $datos) {
        $this->db->where('idestado', $idestado);
        $this->db->update($this->estado, $datos);
        return $this->db->affected_rows();
    }

    public function getEstadosExcel($datos) {
        $this->db->join('usuario', 'usuario.usu_rut = estado.usuario_usu_rut');
        $this->db->join('departamento', 'departamento.iddepartamento = estado.departamento_iddepartamento');
        $this->db->join('documento', 'documento.iddocumento = estado.documento_iddocumento');
        $this->db->order_by('estado_fecha_ingreso', 'ASC');
        $this->db->where($datos);
        return $this->db->get($this->estado)->result();
    }

    // *************** DEPARTAMENTO ****************//

    public function crearDepartamento($depto_nombre, $depto_descripcion, $depto_telefono, $depto_img) {

        $datos = array(
            'depto_nombre' => $depto_nombre,
            'depto_descripcion' => $depto_descripcion,
            'depto_telefono' => $depto_telefono,
            'depto_img' => $depto_img
        );

        return $this->db->insert($this->departamento, $datos);
    }

    public function getDepartamento($iddepartamento) {
        $this->db->where('iddepartamento', $iddepartamento);
        return $this->db->get($this->departamento)->result();
    }

    public function getDocumentoPorDepartamento($departamento_iddepartamento) {
        
    }

    public function updateDepartamento($iddepartamento, $datos) {
        $this->db->where('iddepartamento', $iddepartamento);
        $this->db->update($this->departamento, $datos);
        return $this->db->affected_rows();
    }

    // *************** DOCUMENTO ****************//

    public function eliminarDocumento($iddocumento) {
        $this->db->where('iddocumento', $iddocumento);
        return $this->db->delete($this->documento);
        
    }

    public function updateDocumento($iddocumento, $datos) {
        $this->db->where('iddocumento', $iddocumento);
        $this->db->update($this->documento, $datos);
        return $this->db->affected_rows();
    }

    public function terminarDocumento($iddocumento, $datos) {
        $this->db->where('iddocumento', $iddocumento);
        $this->db->update($this->documento, $datos);
    }

    public function getDocumentoEstado($iddocumento) {
        $this->db->where('iddocumento', $iddocumento);
        return $this->db->get($this->documento)->result();
    }

    public function getUltimoDocumento() {
        $query = 'SELECT * FROM documento ORDER by iddocumento DESC LIMIT 1';
        $res = $this->db->query($query);
        return $res->result();
    }

    public function getDocumento($iddocumento) {
        $this->db->where('iddocumento', $iddocumento);
        return $this->db->get($this->documento)->result();
    }

    public function getDocumentoCompleto($iddocumento) {
        $this->db->join('usuario', 'usuario.usu_rut = documento.usuario_usu_rut');
        $this->db->join('departamento', 'departamento.iddepartamento = usuario.departamento_iddepartamento');
        $this->db->where('iddocumento', $iddocumento);
        return $this->db->get($this->documento)->result();
    }

    public function insertDocumento($docu_codigo, $docu_tipo, $docu_fecha_ingreso, $docu_nombre, $docu_descripcion, $usuario_usu_rut, $docu_estado) {

        $datos = array(
            'docu_codigo' => $docu_codigo,
            'docu_tipo' => $docu_tipo,
            'docu_fecha_ingreso' => $docu_fecha_ingreso,
            'docu_nombre' => $docu_nombre,
            'docu_descripcion' => $docu_descripcion,
            'usuario_usu_rut' => $usuario_usu_rut,
            'docu_estado' => $docu_estado
        );
        return $this->db->insert($this->documento, $datos);
    }

    public function getDocumentoUsuario($usuario_usu_rut) {
        $this->db->where('usuario_usu_rut', $usuario_usu_rut);
        return $this->db->get($this->documento)->result();
    }

    // *************** USUARIO ****************//

    public function updateUsuario($usu_rut, $datos) {
        $this->db->where('usu_rut', $usu_rut);
        $this->db->update($this->usuario, $datos);
        return $this->db->affected_rows();
    }

    public function crearUsuario($usu_rut, $usuario_nombre_pri, $usuario_nombre_secu, $usuario_apellido_pat, $usuario_apellido_mat, $usuario_tipo, $usuario_anexo, $usuario_correo, $usuario_funcion, $usuario_img, $departamento_iddepartamento) {

        $datos = array(
            'usu_rut' => $usu_rut,
            'usuario_password' => '123',
            'usuario_nombre_pri' => $usuario_nombre_pri,
            'usuario_nombre_secu' => $usuario_nombre_secu,
            'usuario_apellido_pat' => $usuario_apellido_pat,
            'usuario_apellido_mat' => $usuario_apellido_mat,
            'usuario_tipo' => $usuario_tipo,
            'usuario_activo' => 'SI',
            'usuario_anexo' => $usuario_anexo,
            'usuario_correo' => $usuario_correo,
            'usuario_funcion' => $usuario_funcion,
            'usuario_img' => $usuario_img,
            'departamento_iddepartamento' => $departamento_iddepartamento
        );
        return $this->db->insert($this->usuario, $datos);
    }

    public function getUsuariosDepartamento($iddepartamento) {
        $this->db->join('departamento', 'departamento.iddepartamento = usuario.departamento_iddepartamento');
        $this->db->where('departamento_iddepartamento', $iddepartamento);
        return $this->db->get($this->usuario)->result();
    }

    public function getUsuariosDeptoDocu($iddepartamento) {
        $this->db->where('departamento_iddepartamento', $iddepartamento);
        return $this->db->get($this->usuario)->result();
    }

    public function getDepartamentos() {
        return $this->db->get($this->departamento)->result();
    }

    public function getUsuarios() {
        $this->db->order_by('usuario_nombre_secu', 'ASC');
        return $this->db->get($this->usuario)->result();
    }

    public function getUsuario($usu_rut) {
        $this->db->where('usu_rut', $usu_rut);
        return $this->db->get($this->usuario)->result();
    }

    public function getUsuarioCompleto() {
        $this->db->join('departamento', 'departamento.iddepartamento = usuario.departamento_iddepartamento');
        return $this->db->get($this->usuario)->result();
    }

    // *************** ARCHIVO ****************//    

    public function crearArchivo($archivoNombre, $extension, $archivoUrl, $archivo_fecha_ingreso, $iddocumento) {

        $datos = array(
            'archivo_nombre' => $archivoNombre,
            'archivo_extension' => $extension,
            'archivo_url' => $archivoUrl,
            'archivo_fecha_ingreso' => $archivo_fecha_ingreso,
            'documento_iddocumento' => $iddocumento
        );

        $this->db->insert($this->archivo, $datos);
        return $this->db->affected_rows();
    }

    public function getArchivo($iddocumento) {
        $this->db->where('documento_iddocumento', $iddocumento);
        $this->db->order_by('idarchivo', 'ASC');
        return $this->db->get($this->archivo)->result();
    }

}
