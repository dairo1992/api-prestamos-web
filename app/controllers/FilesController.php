<?php

namespace App\Controllers;

use Leaf\FS;
use PhpParser\Node\Stmt\TryCatch;

class FilesController extends Controller
{
    public function index()
    {

        $file = request()->files("file");
        // response()->json($file);
        FS::uploadFile($file, "./temp/", [
            "unique" => false,
            "verify_dir" => true,
            "verify_file" => true,
            "max_file_size" => 10000,
            "file_type" => 'spreadsheet',
            "validate" => true
        ]);
        $errors = FS::errors();

        if (empty($errors)) {
        } else {
            response()->json($errors);
        }
    }

    public function conectFtp()
    {
        // $ftp_server = "127.0.0.1";
        $server = "127.0.0.1";
        // $ftp_user_name = "dairo";
        // $ftp_user_pass = "123456";
        // $file = ""; //tobe uploaded
        // $remote_file = "";
        // $conn_id = ftp_connect($ftp_server) or die("Error");
        // $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

        try {
            ftp_connect($server);
        } catch (\Throwable $e) {
            response()->json($e->getMessage());
        }
    }
}
