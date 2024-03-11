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
    $validatedData = request()->validate([
      'NOMBRE' => ['required'],
      'DOCUMENTO' => ['required', 'number'],
      'NEGOCIO' => ['required'],
      'LICENCIAS' => ['required', 'number'],
      'FECHA_INICO' => ['required', 'date'],
      'FECHA_FIN' => ['required', 'date']
    ]);
    if (!$validatedData) {
      response()->json(request()->errors());
    } else {
      $datos = request()->body();
      Auth::registrarCliente($datos);
    }
  }

  public function registrarUsuario()
  {
    $validatedData = request()->validate([
      'CLIENTE' => ['required', 'number'],
      'NOMBRE' => ['required'],
      'USUARIO' => ['required'],
      'PASSWORD' => ['required'],
      'TIPO' => ['required', 'text', 'max:1'],
    ]);
    if (!$validatedData) {
      response()->json(request()->errors());
    } else {
      $datos = request()->body();
      Auth::registrarUsuario($datos);
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
