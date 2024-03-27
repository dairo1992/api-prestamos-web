<?php
app()->config('debug', false);

use Leaf\Helpers\Authentication;

app()->registerMiddleware('verify-token', function () {
    // $data = Authentication::validateToken(_env('APP_KEY'));
    // if (!$data) {
    //     $errors = Authentication::errors();
    //     exit(response()->json($errors));
    // }
    return true;
});

app()->group('/', function () {
    app()->get('/', function () {
        response()->json(["message" => "Bienvenido"]);
    });
    app()->post('/', 'LoginsController@index');
    app()->post('/registrarcliente', ['middleware' => 'verify-token', 'LoginsController@registrarCliente']);
    app()->post('/registrarusuario', ['middleware' => 'verify-token', 'LoginsController@registrarUsuario']);
    app()->post('/reset-password', ['middleware' => 'verify-token', 'LoginsController@resetPassword']);
    app()->post('/valida-token', 'LoginsController@validaToken');
});

app()->group('/', ['middleware' => 'verify-token', function () {
    app()->get("/usuarios", 'UsuariosController@index');
    app()->get("/usuario", 'UsuariosController@obtenerUsuario');
    app()->post("/editar-usuario", 'UsuariosController@editarUsuario');
    app()->get("/clientes", 'UsuariosController@obtenerClientes');
    app()->get("/cliente", 'UsuariosController@obtenerCliente');
    app()->post("/editar-cliente", 'UsuariosController@editarCliente');
    app()->post("/cambiar-estado", 'UsuariosController@CambiarEstado');
}]);

app()->group('/', function () {
    app()->post("/uploadfile", 'FilesController@index');
    app()->get("/readfile", 'FilesController@readFile');
    app()->post("/createtxt", 'FilesController@crearTXT');
    app()->post("/createtxt2", 'FilesController@crearTXT2');
    app()->get("/tipodoc", 'UtilitiesController@obtenerTipoDocumento');
    app()->get("/tipolicencia", 'UtilitiesController@obtenerTipoLicencia');
});
