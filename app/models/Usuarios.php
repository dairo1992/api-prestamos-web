<?php

namespace App\Models;

db()->autoConnect();

class Usuarios extends Model
{
    static function obtenerUsuarios()
    {
        try {
            $resp = db()->query("CALL OBTENER_USUARIOS()")->obj();
            db()->close();
            return json_decode($resp->JSON_ROW_OUT);
        } catch (\Throwable $th) {
            return ["STATUS" => FALSE, "MSG" => $th->getMessage()];
        }
    }

    static function obtenerUsuario($id)
    {
        $resp = db()->query('CALL OBTENER_USUARIO(?)')->bind($id)->all();
        response()->json(count($resp) > 0 ? $resp[0] : null);
        db()->close();
    }

    static function editarUsuario($datos)
    {
        try {
            $resp = db()->query('CALL EDITAR_USUARIO(?,?,?,?,?,?,?,?,?,?,?,?)')->bind(
                $datos["ID"],
                $datos["NOMBRE"],
                $datos["DIRECCION"],
                $datos["CIUDAD"],
                $datos["SEXO"],
                $datos["OCUPACION"],
                $datos["TELEFONO"],
                $datos["NACIMIENTO"],
                $datos["EDAD"],
                $datos["EMAIL"],
                $datos["TIPO_PRECIO_VENTA"],
                $datos["NOTA"]
            )->obj();
            return (json_decode($resp->JSON_ROW_OUT));
            db()->close();
        } catch (\Throwable $th) {
            return ["STATUS" => FALSE, "MSG" => $th->getMessage()];
        }
    }

    static function obtenerClientes()
    {
        try {
            $resp = db()->query("CALL OBTENER_CLIENTES()")->obj();
            db()->close();
            return json_decode($resp->JSON_ROW_OUT);
        } catch (\Throwable $th) {
            return ["STATUS" => FALSE, "MSG" => $th->getMessage()];
        }
    }

    static function obtenerCliente($id)
    {
        $resp = db()->query('CALL OBTENER_CLIENTE(?)')->bind($id)->all();
        response()->json(count($resp) > 0 ? $resp[0] : null);
        db()->close();
    }

    static function editarCliente($datos)
    {
        try {
            $resp = db()->query('CALL EDITAR_CLIENTE(?,?,?,?,?)')->bind(
                $datos["ID"],
                $datos["NOMBRE"],
                $datos["NEGOCIO"],
                $datos["LICENCIA"],
                $datos["FECHA_FIN"],
            )->obj();
            return response()->json(json_decode($resp->JSON_ROW_OUT));
            db()->close();
        } catch (\Throwable $th) {
            return ["STATUS" => FALSE, "MSG" => $th->getMessage()];
        }
    }

    static function CambiarEstado($datos)
    {
        try {
            $estado = $datos["ESTADO"] == "A" ? "I" : "A";
            $resp = db()->query('CALL CAMBIAR_ESTADO(?,?,?)')->bind(
                $datos["TABLA"],
                $datos["ID"],
                $estado
            )->obj();
            return (json_decode($resp->JSON_ROW_OUT));
            db()->close();
        } catch (\Throwable $th) {
            return ["STATUS" => FALSE, "MSG" => $th->getMessage()];
        }
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
}
