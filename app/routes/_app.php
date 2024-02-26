<?php
app()->config('debug', false);

use Leaf\Helpers\Authentication;

app()->registerMiddleware('verify-token', function () {
    $data = Authentication::validateToken(_env('APP_KEY'));
    if (!$data) {
        $errors = Authentication::errors();
        exit(response()->json($errors));
    }
});
app()->get('/', 'LoginsController@index');
app()->group('/auth', function () {
    app()->post('/', 'LoginsController@index');
    app()->post('/registrarcliente', ['middleware' => 'verify-token', 'LoginsController@registrarCliente']);
    app()->post('/registrarusuario', ['middleware' => 'verify-token', 'LoginsController@registrarUsuario']);
    app()->post('/prueba', ['middleware' => 'verify-token', 'LoginsController@registrarUsuario']);
});

app()->group('/usuarios', ['middleware' => 'verify-token', function () {
    app()->get("/", 'UsuariosController@index');
    app()->get("/usuario", 'UsuariosController@obtenerUsuario');
    app()->post("/editar-usuario", 'UsuariosController@editarUsuario');
    app()->post("/estado-usuario", 'UsuariosController@CambiarEstadoUsuario');
    app()->get("/clientes", 'UsuariosController@obtenerClientes');
    app()->get("/cliente", 'UsuariosController@obtenerCliente');
    app()->post("/editar-cliente", 'UsuariosController@editarCliente');
    app()->post("/estado-cliente", 'UsuariosController@CambiarEstadoCliente');
}]);
