<?php

namespace App\Models;

db()->autoConnect();

class Utility extends Model
{
    static function obtenerTipoDocumento()
    {
        try {
            $resp = db()->query("CALL OBTENER_TIPO_DOCUMENTO()")->obj();
            db()->close();
            return json_decode($resp->JSON_ROW_OUT);
            // return $resp->JSON_ROW_OUT;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    static function obtenerTipoLicencia()
    {
        try {
            $resp = db()->query("CALL OBTENER_LICENCIAS()")->obj();
            db()->close();
            // response()->json(json_decode($resp->JSON_ROW_OUT));
            return json_decode($resp->JSON_ROW_OUT);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
