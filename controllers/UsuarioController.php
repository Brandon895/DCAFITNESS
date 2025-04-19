<?php 
// controllers/UsuarioController.php
require_once('../models/UsuarioModel.php');

class UsuarioController {

    // Registrar usuario
    public function registrarUsuario($nombrecompleto, $usuario, $password, $rol) {
        return UsuarioModel::registrarUsuario($nombrecompleto, $usuario, $password, $rol);
    }

    // Editar usuario
    public function editarUsuario($id, $nombrecompleto, $usuario, $password, $rol) {
        return UsuarioModel::editarUsuario($id, $nombrecompleto, $usuario, $password, $rol);
    }

    // Inactivar usuario
    public function inactivarUsuario($id) {
        return UsuarioModel::inactivarUsuario($id);
    }

    // Obtener todos los usuarios
    public function obtenerUsuarios() {
        return UsuarioModel::obtenerUsuarios();
    }
}
?>

