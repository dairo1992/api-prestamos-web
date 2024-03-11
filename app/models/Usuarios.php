<?php

namespace App\Models;

db()->autoConnect();

class Usuarios extends Model
{
    static function obtenerUsuarios()
    {
        $resp = db()->query('CALL OBTENER_USUARIOS()')->all();
        response()->json($resp);
        db()->close();
    }

    static function obtenerUsuario($id)
    {
        $resp = db()->query('CALL OBTENER_USUARIO(?)')->bind($id)->all();
        response()->json(count($resp) > 0 ? $resp[0] : null);
        db()->close();
    }

    static function editarUsuario($datos)
    {
        $resp = db()->query('CALL EDITAR_USUARIO(?,?,?)')->bind(
            $datos["ID"],
            $datos["NOMBRE"],
            // $datos["CONTRASENA"],
            $datos["TIPO"],
        )->obj();
        response()->json(json_decode($resp->JSON_ROW_OUT));
        db()->close();
    }

    static function CambiarEstadoUsuario($datos)
    {
        $estado = $datos["ESTADO"] == "A" ? "I" : "A";
        $resp = db()->query('CALL ACTIVAR_INACTIVAR_USU(?,?)')->bind(
            $datos["ID"],
            $estado
        )->obj();
        response()->json(json_decode($resp->JSON_ROW_OUT));
        db()->close();
    }

    static function obtenerClientes()
    {
        $resp = db()->query('CALL OBTENER_CLIENTES()')->all();
        response()->json($resp);
        db()->close();
    }

    static function obtenerCliente($id)
    {
        $resp = db()->query('CALL OBTENER_CLIENTE(?)')->bind($id)->all();
        response()->json(count($resp) > 0 ? $resp[0] : null);
        db()->close();
    }

    static function editarCliente($datos)
    {
        $resp = db()->query('CALL EDITAR_CLIENTE(?,?,?,?,?)')->bind(
            $datos["ID_CLIENTE"],
            $datos["NOMBRE"],
            $datos["NEGOCIO"],
            $datos["LICENCIAS"],
            $datos["FECHA_FIN"],
        )->obj();
        response()->json(json_decode($resp->JSON_ROW_OUT));
        db()->close();
    }

    static function CambiarEstadoCliente($datos)
    {
        $estado = $datos["ESTADO"] == "A" ? "I" : "A";
        $resp = db()->query('CALL CAMBIAR_ESTADO_CLIENTE(?,?)')->bind(
            $datos["ID"],
            $estado
        )->obj();
        response()->json(json_decode($resp->JSON_ROW_OUT));
        db()->close();
    }
}
