<?php

namespace App\Controllers;
// se debe llamar igual al archivo creado en models
use App\Models\Usuarios;
use Leaf\Auth;


class UsuariosController extends Controller
{
    public function index()
    {
        Usuarios::obtenerUsuarios();
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
            "NOMBRE" => ['required', 'text'],
            "CONTRASENA" => ['required', 'min:5'],
            "TIPO" => ['required', 'text', 'max:1'],
        ]);
        if (!$validatedData) {
            response()->json(request()->errors());
        } else {
            $datos = request()->body();
            Usuarios::editarUsuario($datos);
        }
    }

    public function CambiarEstadoUsuario()
    {
        $validatedData = request()->validate([
            "ID" => ['required', 'number'],
            "ESTADO" => ['required', 'text', 'max:1']
        ]);
        if (!$validatedData) {
            response()->json(request()->errors());
        } else {
            $datos = request()->body();
            Usuarios::CambiarEstadoUsuario($datos);
        }
    }
    // CONSULTAS CLIENTES

    public function obtenerClientes()
    {
        Usuarios::obtenerClientes();
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
            "ID_CLIENTE" => ['required', 'number', 'min:1'],
            "NOMBRE" => ['required', 'text'],
            "NEGOCIO" => ['required', 'alphaDash'],
            "LICENCIAS" => ['required', 'number', 'min:1'],
            "FECHA_FIN" => ['required', 'date'],
        ]);
        if (!$validatedData) {
            response()->json(request()->errors());
        } else {
            $datos = request()->body();
            Usuarios::editarCliente($datos);
        }
    }

    public function CambiarEstadoCliente()
    {
        $validatedData = request()->validate([
            "ID" => ['required', 'number'],
            "ESTADO" => ['required', 'text']
            // "ESTADO" => ['required', 'text', 'max:1']
        ]);
        if (!$validatedData) {
            response()->json(request()->errors());
        } else {
            $datos = request()->body();
            Usuarios::CambiarEstadoCliente($datos);
        }
    }
}
