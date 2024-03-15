<?php

namespace App\Controllers;

use Leaf\FS;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
// use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

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
