<?php

namespace Model;

class Middlewares
{
    // $this->errores = [];
    public function __construct($api = true)
    {
        $this->api = $api;
        $this->errores = [];
    }



    public  function response($nombreError, $mensaje, $code = 200, $response = true,): void
    {
        if ($this->api) {
            $this->responseJSON(
                $code,
                $response,
                $mensaje,
            );
        } else {
            $this->responseError($nombreError, $mensaje);
        }
    }
    protected  function responseError($nombreError, $mensaje): void
    {

        $this->errores[$nombreError] = $mensaje;
    }

    public  function responseJSON($code = 200, $response = true, $mensaje = '',)
    {
        http_response_code($code);
        echo json_encode(["success" => $response, "mensaje" => $mensaje]);
        die();
    }

    public function validarRequired($value, $nombreError, $mensaje = '')

    {
        $nombre = str_replace('Error', '', $nombreError);
        if (!$value) {
            $this->response($nombreError, $mensaje ? $mensaje : $mensaje = "Este campo es obligatorio: $nombre", 401, false);
        }
    }

    public function validarEmail($email, $nombreError,  $mensaje = 'Este email no es valido')
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->response($nombreError, $mensaje, 401, false);
        }
    }

    public function validarMaxLength($max, $texto, $nombreError, $mensaje = '')
    {
        if (strlen($texto)  > $max) {
            $textoSubtr = $texto < 8 ? substr($texto, 0, 5) . "..." : $texto;
            $this->response($nombreError, $mensaje ? $mensaje : "$textoSubtr es demasiado largo, max:$max carácteres", 401, false);
        }
    }
    public function validarMinLength($min, $texto, $nombreError, $mensaje = '')
    {
        if (strlen($texto)  < $min) {
            $textoSubtr = $texto < 8 ? substr($texto, 0, 5) . "..." : $texto;
            $this->response($nombreError, $mensaje ? $mensaje : "$textoSubtr es demasiado corto, min: $min carácteres", 401, false);
        }
    }

    public function validarOnlyText($texto, $nombreError, $mensaje = '')
    {
        $pattern = "/^[a-zA-Z\sñáéíóúÁÉÍÓÚ]+$/";
        if (!preg_match($pattern, $texto)) {
            $this->response($nombreError, $mensaje ? $mensaje : "Este campo solo permite letras: $texto", 401, false);
        }
    }

    public function validarOnlyNumber($numero, $nombreError, $mensaje = '')
    {
        $pattern = "/[^0-9]/";
        if (preg_match($pattern, $numero)) {
            $this->response($nombreError, $mensaje ? $mensaje : "Este campo solo permite numeros: $numero", 401, false);
        }
    }
    public function validarAge($numero, $nombreError, $mensaje = '')
    {
        $pattern = "/[^0-9]/";
        if (preg_match($pattern, $numero) && strlen($numero)  > 3) {
            $this->response($nombreError, $mensaje ? $mensaje : "Esta edad no es válida: $numero", 401, false);
        }
    }
    public function validarOnlyID($id, $nombreError, $mensaje = '')
    {
        $pattern = "/[^0-9]/";
        if (preg_match($pattern, $id)) {
            $this->response($nombreError, $mensaje ? $mensaje : "Este id no es válido: $id", 401, false);
        }
    }

    public function validarIsFILE($file, $nombreError, $mensaje = '')
    {
        if ($file['error'] === 4) {
            $this->response($nombreError, $mensaje ? $mensaje : "Tuvimos un error con este archivo: $file[name]", 401, false);
        }
    }

    public function validarArchivoType($FILES, $nombreError, $extensionesPermitidos = ["jpg", "jpeg", "png", "webp"], $mensaje = '')
    {
        $extension = explode('/', $FILES['type']);
        if (!in_array($extension[1]  ?? '', $extensionesPermitidos)) {
            $this->response($nombreError, $mensaje ? $mensaje : "Este archivo no es válido " . $FILES['name'] . "", 401, false);
        }
    }

    public function validarArchivosType($FILES, $nombreError, $extensionesPermitidos = ["jpg", "jpeg", "png", "webp"],  $mensaje = '')
    {
        for ($i = 0; $i < count($FILES); $i++) {
            $imagen = $FILES["imagen$i"];
            $extension = explode('/', $imagen['type']); //[0]image,[1]png
            if (!in_array($extension[1], $extensionesPermitidos)) {
                $this->response($nombreError, $mensaje ? $mensaje : "Este archivo no es válido " . $FILES['name'][$i] . "", 401, false);
            }
        }
    }

    public function validarArchivoSize($FILES, $nombreError, $peso = 1000000, $mensaje = '')
    {

        if ($FILES['size'] > $peso) {
            $mb = $peso / 1000000;
            $this->response($nombreError, $mensaje ? $mensaje : "Este archivo es pesado MAX: $mb mb ", 401, false);
        }
    }
}