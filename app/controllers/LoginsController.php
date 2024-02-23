<?php

namespace App\Controllers;

use App\Models\Auth;




class LoginsController extends Controller
{
  public function index()
  {
    $validatedData = request()->validate([
      'USUARIO' => ['required'],
      'PASSWORD' => ['required'],
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
      'CONTRASENA' => ['required'],
      'TIPO' => ['required', 'text', 'max:1'],
    ]);
    if (!$validatedData) {
      response()->json(request()->errors());
    } else {
      $datos = request()->body();
      Auth::registrarUsuario($datos);
    }
  }
}
