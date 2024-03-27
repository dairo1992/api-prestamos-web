<?php

namespace App\Controllers;

use App\Models\Auth;

class LoginsController extends Controller
{
  public function index()
  {

    $validatedData = request()->validate([
      'USUARIO' => ['required'],
      'PASSWORD' => ['required', 'min:5'],
    ]);
    if (!$validatedData) {
      response()->json(request()->errors());
    } else {
      $datos = request()->body();
      Auth::login($datos);
    }
  }

  public function registrarCliente()
  {
    // try {
    $validatedData = request()->validate([
      'NOMBRE' => ['required'],
      'TIPO_DOCUMENTO' => ['required', 'min:2', 'max:2'],
      'DOCUMENTO' => ['required', 'number', 'min:5'],
      'NEGOCIO' => ['required'],
      'LICENCIA' => ['required', 'number', 'min:1', 'max:2'],
      'FECHA_INICIO' => ['required', 'date'],
      'FECHA_FIN' => ['required', 'date']
    ]);
    if (!$validatedData) {
      response()->json(request()->errors());
    } else {
      $datos = request()->body();
      $resp = Auth::registrarCliente($datos);
      response()->json($resp);
    }
    // } catch (\Throwable $th) {
    // response()->json("ERROR: " . $th->getMessage());
    // }
  }

  public function registrarUsuario()
  {
    try {
      $validatedData = request()->validate([
        'CLIENTE' => ['required', 'number'],
        'NOMBRE' => ['required'],
        'TIPO_DOCUMENTO' => ['required'],
        'DOCUMENTO' => ['required', 'number'],
        'DIRECCION' => [],
        'CIUDAD' => [],
        'SEXO' => [],
        'OCUPACION' => [],
        'TELEFONO' => ['required'],
        'NACIMIENTO' => [],
        'EDAD' => [],
        'EMAIL' => [],
        'TIPO_PRECIO_VENTA' => ['required'],
        'NOTA' => [],
      ]);
      if (!$validatedData) {
        response()->json(request()->errors());
      } else {
        $datos = request()->body();
        $resp = Auth::registrarUsuario($datos);
        response()->json($resp);
      }
    } catch (\Throwable $th) {
      //throw $th;
      return ["STATUS" => FALSE, "MSG" => $th->getMessage()];
    }
  }

  public function resetPassword()
  {
    $validatedData = request()->validate([
      'ID_USUARIO' => ['required'],
      'PASSWORD' => ['required', 'min:5'],
      'PASSWORD_CONFIRM' => ['required', 'min:5'],
    ]);
    if (!$validatedData) {
      response()->json(request()->errors());
    } else {
      $datos = request()->body();
      if ($datos['PASSWORD'] === $datos['PASSWORD_CONFIRM']) {
        Auth::resetPassword($datos);
      } else {
        response()->json(["STATUS" => false, "RESP" => "LAS CONTRASEÑAS NO COINCIDEN"]);
      }
    }
  }

  public function validaToken()
  {
    $validatedData = request()->validate([
      'TOKEN' => ['required']
    ]);
    if (!$validatedData) {
      response()->json(false);
    } else {
      $datos = request()->body();
      Auth::validaToken($datos);
    }
  }
}
