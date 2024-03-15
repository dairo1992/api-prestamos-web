<?php

namespace App\Controllers;

use App\Models\Utility;

class UtilitiesController extends Controller
{
    public function obtenerTipoDocumento()
    {
        $resp = Utility::obtenerTipoDocumento();
        response()->json($resp);
    }
    public function obtenerTipoLicencia()
    {
        $resp = Utility::obtenerTipoLicencia();
        response()->json($resp);
    }
}
