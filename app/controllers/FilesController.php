<?php

namespace App\Controllers;

use Leaf\FS;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
// use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

class FilesController extends Controller
{
    public function index()
    {

        try {
            $file = request()->files("file");
            // response()->json($file);
            if ($file != null) {
                $resp = FS::uploadFile($file, "./temp/", [
                    "unique" => false,
                    "verify_dir" => true,
                    "verify_file" => false,
                    "max_file_size" => 10000000,

                ]);
                $errors = FS::errors();

                if (empty($errors)) {
                    $profileInfo = FS::uploadInfo($resp);
                    response()->json(["STATUS" => true, "MSG" => $profileInfo['name']]);
                } else {
                    response()->json(["STATUS" => false, "MSG" => $errors]);
                }
            } else {
                response()->json(["STATUS" => false, "MSG" => "NO SE ENCONTRARON SOPORTES"]);
            }
        } catch (\Throwable $th) {
            return ["STATUS" => FALSE, "MSG" => $th->getMessage()];
        }
    }

    public function readFile()
    {
        try {
            $validatedData = request()->validate([
                "NOMBRE" => ['required'],
            ]);
            if (!$validatedData) {
                response()->json(request()->errors());
            } else {
                $datos = request()->body();
                header("Content-disposition: attachment; filename=" . $datos['NOMBRE'] . "csv");
                header("Content-type: MIME");
                readfile("./temp/" . $datos['NOMBRE']);
            }
        } catch (\Throwable $th) {
            return ["STATUS" => FALSE, "MSG" => $th->getMessage()];
        }
    }

    public function crearTXT()
    {
        FS::deleteFile("./temp/items.txt");
        $datos = request()->body();
        if (count($datos) < 1) {
            response()->json(["STATUS" => FALSE, "MSG" => "ARRAY VACIO"]);
        } else {
            FS::createFile("./temp/items.txt");
            $errors = FS::errors();
            for ($i = 0; $i < count($datos); $i++) {
                $linea =
                    intval($datos[$i]['nit']) . ','
                    . trim($datos[$i]['modalidad']) . ','
                    . trim($datos[$i]['tipo_medicamento']) . ','
                    . intval(trim($datos[$i]['ips_origen'])) . ','
                    . trim($datos[$i]['nombre_ips']) . ','
                    . trim($datos[$i]['tipo_documento']) . ','
                    . intval(trim($datos[$i]['documento'])) . ','
                    . trim($datos[$i]['direccion']) . ','
                    . intval(trim($datos[$i]['dane'])) . ','
                    . intval(trim($datos[$i]['telefono'])) . ','
                    . intval(trim($datos[$i]['cum'])) . ','
                    . trim($datos[$i]['atc']) . ','
                    . trim($datos[$i]['descripcion_med']) . ','
                    . trim($datos[$i]['administracion']) . ','
                    . intval(trim($datos[$i]['frecuencia'])) . ','
                    . intval(trim($datos[$i]['dureacion_tratamiento'])) . ','
                    . trim($datos[$i]['lote']) . ','
                    . trim($datos[$i]['fecha_vencimiento']) . ','
                    . intval(trim($datos[$i]['cant_prescrita'])) . ','
                    . intval(trim($datos[$i]['cant_solicitada'])) . ','
                    . intval(trim($datos[$i]['cant_entregada'])) . ','
                    . intval(trim($datos[$i]['valor_unitario'])) . ','
                    . trim($datos[$i]['dx']) . ','
                    . trim($datos[$i]['fecha_prescripcion']) . ','
                    . trim($datos[$i]['fecha_aut']) . ','
                    . trim($datos[$i]['fecha_sol']) . ','
                    . trim($datos[$i]['fecha_entrega']) . ','
                    . intval(trim($datos[$i]['num_aut'])) . ','
                    . trim($datos[$i]['num_formula']) . ','
                    . trim($datos[$i]['autoriza_entrega']) . ','
                    . trim($datos[$i]['entrega_docimicilio']) . ','
                    . trim($datos[$i]['tipo_entrega']) . "\r";
                FS::append("./temp/items.txt", $linea);
            }
            if (empty($errors)) {
                header('Content-Description: File Transfer');
                header('Content-Disposition: attachment; filename=archivo.txt');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header("Content-Type: text/plain");
                readfile("./temp/items.txt");
            } else {
                response()->json(["STATUS" => false, "MSG" => $errors]);
            }
        }
    }

    public function crearTXT2()
    {
        // FS::deleteFile("./temp/items.txt");
        $datos = request()->body();
        if (count($datos) < 1) {
            response()->json(["STATUS" => FALSE, "MSG" => "ARRAY VACIO"]);
        } else {
            response()->json($datos);
            // FS::createFile("./temp/items.txt");
            // $errors = FS::errors();
            // for ($i = 0; $i < count($datos); $i++) {
            //     $linea =
            //         intval($datos[$i]['nit']) . ','
            //         . trim($datos[$i]['modalidad']) . ','
            //         . trim($datos[$i]['tipo_medicamento']) . ','
            //         . intval(trim($datos[$i]['ips_origen'])) . ','
            //         . trim($datos[$i]['nombre_ips']) . ','
            //         . trim($datos[$i]['tipo_documento']) . ','
            //         . intval(trim($datos[$i]['documento'])) . ','
            //         . trim($datos[$i]['direccion']) . ','
            //         . intval(trim($datos[$i]['dane'])) . ','
            //         . intval(trim($datos[$i]['telefono'])) . ','
            //         . intval(trim($datos[$i]['cum'])) . ','
            //         . trim($datos[$i]['atc']) . ','
            //         . trim($datos[$i]['descripcion_med']) . ','
            //         . trim($datos[$i]['administracion']) . ','
            //         . intval(trim($datos[$i]['frecuencia'])) . ','
            //         . intval(trim($datos[$i]['dureacion_tratamiento'])) . ','
            //         . trim($datos[$i]['lote']) . ','
            //         . trim($datos[$i]['fecha_vencimiento']) . ','
            //         . intval(trim($datos[$i]['cant_prescrita'])) . ','
            //         . intval(trim($datos[$i]['cant_solicitada'])) . ','
            //         . intval(trim($datos[$i]['cant_entregada'])) . ','
            //         . intval(trim($datos[$i]['valor_unitario'])) . ','
            //         . trim($datos[$i]['dx']) . ','
            //         . trim($datos[$i]['fecha_prescripcion']) . ','
            //         . trim($datos[$i]['fecha_aut']) . ','
            //         . trim($datos[$i]['fecha_sol']) . ','
            //         . trim($datos[$i]['fecha_entrega']) . ',' 
            //         . intval(trim($datos[$i]['num_aut'])) . ','
            //         . trim($datos[$i]['num_formula']) . ','
            //         . trim($datos[$i]['autoriza_entrega']) . ','
            //         . trim($datos[$i]['entrega_docimicilio']) . ','
            //         . trim($datos[$i]['tipo_entrega']) . "\r";
            //     FS::append("./temp/items.txt", $linea);
            // }
            // if (empty($errors)) {
            //     header('Content-Description: File Transfer');
            //     header('Content-Disposition: attachment; filename=archivo.txt');
            //     header('Expires: 0');
            //     header('Cache-Control: must-revalidate');
            //     header('Pragma: public');
            //     header("Content-Type: text/plain");
            //     readfile("./temp/items.txt");
            // } else {
            //     response()->json(["STATUS" => false, "MSG" => $errors]);
            // }
        }
    }


    public function conectFtp()
    {
        try {
            $path = 'temp/file.csv';
            # open the file
            $reader = ReaderEntityFactory::createXLSXReader();
            $reader->open($path);
            # read each cell of each row of each sheet
            foreach ($reader->getSheetIterator() as $sheet) {
                foreach ($sheet->getRowIterator() as $row) {
                    foreach ($row->getCells() as $cell) {
                        var_dump($cell->getValue());
                    }
                }
            }
            $reader->close();
        } catch (\Throwable $th) {
            response()->json($th->getMessage());
        }
    }
}
