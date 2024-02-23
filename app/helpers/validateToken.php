<?php

// namespace App\ValidateToken;

use Leaf\Helpers\Authentication;

class ValidarJWT extends Leaf\Middleware
{
    public function call()
    {
        $data = Authentication::validateToken(_env('APP_KEY'));
        if (!$data) {
            $errors = Authentication::errors();
            exit(response()->json($errors));
        }

        return $this->next();
    }
}
