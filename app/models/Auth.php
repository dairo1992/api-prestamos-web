<?php

namespace App\Models;

use Leaf\Helpers\Authentication;
use Leaf\Helpers\Password;

db()->autoConnect();

class Auth extends Model
{
    static function login($datos)
    {
        try {
            $users = db()->query('SELECT * FROM usuario')->all();
            response()->json($users);
        } catch (\Throwable $th) {
            response()->json($th);
        }

        // $resp = json_decode($users->JSON_ROW_OUT);
        // if ($resp->STATUS) {
        //     $dataResponse = ($resp->RESP);

        //     $validPass = Password::verify($datos['PASSWORD'], $dataResponse->PASSWORD);

        //     if ($validPass) {
        //         $token = Authentication::generateToken(
        //             [
        //                 'user_id' => $dataResponse->ID_CLIENTE,
        //                 'iat' => time(),
        //                 'iss' => 'localhost',
        //                 // 'exp' => time() + 1,
        //                 'exp' => time() + 3600,
        //             ],
        //             _env('APP_KEY')
        //         );
        //         response()->json(["STATUS" => true, "RESP" => ["ID_CLIENTE" => $dataResponse->ID_CLIENTE, "ID_USUARIO" => $dataResponse->ID_USUARIO, "NOMBRE" => $dataResponse->NOMBRE, "TIPO" => $dataResponse->TIPO_USUARIO, "TOKEN" => $token]]);
        //     } else {
        //         response()->json(["STATUS" => false, "RESP" => "CONTRASEÑA INCORRECTA"]);
        //     }
        // } else {
        //     response()->json($resp);
        // }
        db()->close();
    }

    static function registrarCliente($datos)
    {
        try {
            date_default_timezone_set('UTC');

            $users = db()->query('CALL NUEVO_CLIENTE(?,?,?,?,?,?,?,?)')->bind(
                $datos['NOMBRE'],
                $datos['TIPO_DOCUMENTO'],
                $datos['DOCUMENTO'],
                $datos['NEGOCIO'],
                $datos['LICENCIA'],
                $datos['FECHA_INICIO'],
                $datos['FECHA_FIN'],
                Password::hash($datos['DOCUMENTO']),
            )->obj();
            return response()->json(json_decode($users->JSON_ROW_OUT));
            db()->close();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    static function registrarUsuario($datos)
    {
        try {
            $users = db()->query('CALL REGISTRAR_USUARIO(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)')->bind(
                intval($datos['CLIENTE']),
                $datos['NOMBRE'],
                $datos['TIPO_DOCUMENTO'],
                $datos['DOCUMENTO'],
                $datos['DIRECCION'] == null ? '' : $datos['DIRECCION'],
                $datos['CIUDAD'] == null ? '' : $datos['CIUDAD'],
                $datos['SEXO'] == null ? '' : $datos['SEXO'],
                $datos['OCUPACION'] == null ? '' : $datos['OCUPACION'],
                $datos['TELEFONO'],
                $datos['NACIMIENTO'] == null ? '' : $datos['NACIMIENTO'],
                $datos['EDAD'] == null ? '' : $datos['EDAD'],
                $datos['EMAIL'],
                $datos['TIPO_PRECIO_VENTA'],
                $datos['NOTA'] == null ? '' : $datos['NOTA'],
                Password::hash($datos['DOCUMENTO']),
            )->obj();
            return (json_decode($users->JSON_ROW_OUT));
            db()->close();
        } catch (\Throwable $th) {
            return ["STATUS" => FALSE, "MSG" => $th->getMessage()];
        }
    }

    static function resetPassword($datos)
    {
        // response()->json(["ID" => $datos['ID_USUARIO'], "PASSWORD-HASH" =>Password::hash($datos['PASSWORD']), "PASSWORD" => $datos['PASSWORD']]);
        $users = db()->query('CALL CAMBIAR_PASSWORD(?,?)')->bind(
            $datos['ID_USUARIO'],
            Password::hash($datos['PASSWORD'])
        )->obj();
        response()->json(json_decode($users->JSON_ROW_OUT));
        db()->close();
    }

    static function validaToken($datos)
    {
        $resp = Authentication::validate($datos['TOKEN'], _env('APP_KEY'));
        response()->json($resp === null ? false : true);
    }
}
