<?php

namespace App\Models;

use Leaf\Helpers\Authentication;

db()->autoConnect();

class Auth extends Model
{
    static function login($datos)
    {
        $users = db()->query('CALL LOGIN(?,?)')->bind(
            $datos['USUARIO'],
            $datos['PASSWORD']
        )->obj();
        $resp = json_decode($users->JSON_ROW_OUT);
        if ($resp->STATUS) {
            $datos = json_decode($resp->RESP);
            $token = Authentication::generateToken(
                [
                    'user_id' => $datos->ID_CLIENTE,
                    'iat' => time(),
                    'iss' => 'localhost',
                    // 'exp' => time() + 1,
                    'exp' => time() + 3600,
                ],
                _env('APP_KEY')
            );
            response()->json(["STATUS" => true, "RESP" => ["NOMBRE" => $datos->NOMBRE, "TIPO" => $datos->TIPO_USUARIO, "TOKEN" => $token]]);
        } else {
            response()->json($resp);
        }
        db()->close();
    }

    static function registrarCliente($datos)
    {
        $users = db()->query('CALL REGISTRAR_CLIENTE(?,?,?,?,?,?)')->bind(
            $datos['NOMBRE'],
            $datos['DOCUMENTO'],
            $datos['NEGOCIO'],
            $datos['LICENCIAS'],
            $datos['FECHA_INICO'],
            $datos['FECHA_FIN']
        )->obj();
        response()->json(json_decode($users->JSON_ROW_OUT));
        db()->close();
    }

    static function registrarUsuario($datos)
    {
        $users = db()->query('CALL REGISTRAR_USUARIO(?,?,?,?,?)')->bind(
            $datos['CLIENTE'],
            $datos['NOMBRE'],
            $datos['USUARIO'],
            $datos['CONTRASENA'],
            $datos['TIPO']
        )->obj();
        response()->json(json_decode($users->JSON_ROW_OUT));
        db()->close();
    }
}
