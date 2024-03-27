<?php

namespace App\Controllers;
// se debe llamar igual al archivo creado en models
use App\Models\Usuarios;
use Leaf\Auth;


class UsuariosController extends Controller
{
    public function index()
    {
        $resp = Usuarios::obtenerUsuarios();
        response()->json($resp);
    }

    public function obtenerUsuario()
    {
        $validatedData = request()->validate([
            'id' => ['required', 'number', 'min:1'],
        ]);
        if (!$validatedData) {
            response()->json(request()->errors());
        } else {
            $datos = request()->get('id');
            Usuarios::obtenerUsuario($datos);
        }
    }

    public function editarUsuario()
    {
        $validatedData = request()->validate([
            "ID" => ['required', 'number'],
            "NOMBRE" => [],
            "DIRECCION" => [],
            "CIUDAD" => [],
            "SEXO" => [],
            "OCUPACION" => [],
            "TELEFONO" => [],
            "NACIMIENTO" => [],
            "EDAD" => [],
            "EMAIL" => [],
            "TIPO_PRECIO_VENTA" => [],
            "NOTA" => [],
        ]);
        if (!$validatedData) {
            response()->json(request()->errors());
        } else {
            $datos = request()->body();
            $resp = Usuarios::editarUsuario($datos);
            response()->json($resp);
        }
    }

    // CONSULTAS CLIENTES

    public function obtenerClientes()
    {
        $resp = Usuarios::obtenerClientes();
        response()->json($resp);
    }

    public function obtenerCliente()
    {
        $validatedData = request()->validate([
            'id' => ['required', 'number', 'min:1'],
        ]);
        if (!$validatedData) {
            response()->json(request()->errors());
        } else {
            $datos = request()->get('id');
            Usuarios::obtenerCliente($datos);
        }
    }

    public function editarCliente()
    {
        $validatedData = request()->validate([
            "ID" => ['required', 'number', 'min:1'],
            "NOMBRE" => ['required'],
            "DOCUMENTO" => ['required', 'number', 'min:1'],
            "NEGOCIO" => ['required'],
            "LICENCIA" => ['required', 'number', 'min:1'],
            "FECHA_INICIO" => ['required', 'date'],
            "FECHA_FIN" => ['required', 'date']
        ]);
        if (!$validatedData) {
            response()->json(request()->errors());
        } else {
            $datos = request()->body();
            $resp = Usuarios::editarCliente($datos);
            response()->json($resp);
        }
    }

    public function CambiarEstado()
    {
        $validatedData = request()->validate([
            "ID" => ['required', 'number'],
            "ESTADO" => ['required', 'text'],
            "TABLA" => ['required']
        ]);
        if (!$validatedData) {
            response()->json(request()->errors());
        } else {
            $datos = request()->body();
            $resp = Usuarios::CambiarEstado($datos);
            response()->json($resp);
        }
    }
}
