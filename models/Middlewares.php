<?php

namespace Model;

class Middlewares
{
    // $this->errores = [];
    private $msg = 'msg';
    private $success = 'success';

    public  function responseJSON(int $code = 200, bool $response = true,  $mensaje): void
    {
        http_response_code($code);
        echo json_encode([$this->success => $response, $this->msg => $mensaje]);
        die();
    }

    public function validarRequired($value, string $nombre): void
    {
        if (!$value) {
            $this->responseJSON(500, false, "$nombre es obligatorio, si lo hiciste bien. comuniquese con el desarrollador");
        }
    }

    public function validarEmail(string $email = '', string $msg = 'Este email no es valido')
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->responseJSON(500, false, $msg . " : $email");
        }
    }

    public function validarMaxLength($texto = '', $max)
    {
        if (strlen($texto)  > $max) {
            $this->responseJSON(400, false, "$texto es demasiado largo, max:$max carácteres");
        }
    }
    public function validarMinLength($texto = '', $max)
    {
        if (strlen($texto)  < $max) {
            $this->responseJSON(400, false, "$texto es demasiado corto, min:$max carácteres");
        }
    }

    public function validarOnlyText(string $texto = '')
    {
        $pattern = "/^[a-zA-Z\sñáéíóúÁÉÍÓÚ]+$/";
        if (!preg_match($pattern, $texto)) {
            $this->responseJSON(400, false, "Este campo permite solo letras: $texto");
        }
    }

    public function validarOnlyNumber($texto = '')
    {
        $pattern = "/[^0-9]/";
        if (preg_match($pattern, $texto)) {
            $this->responseJSON(400, false, "$texto no es valido: solo numeros");
        }
    }
    public function validarOnlyID($texto = '')
    {
        $pattern = "/[^0-9]/";
        if (preg_match($pattern, $texto)) {
            $this->responseJSON(400, false, "ID: $texto inválido ");
        }
    }

    public function validarIsFILE($file, $type = 'imagen')
    {
        if ($file['error'] === 4) {
            $this->responseJSON(400, false, "Solo está permitido $type");
        }
    }

    public function validarArchivoType($FILES, $extensionesPermitidos = ["jpg", "jpeg", "png", "webp"])
    {
        $extension = explode('/', $FILES['type']);
        if (!in_array($extension[1], $extensionesPermitidos)) {
            $this->responseJSON(400, false, "Este archivo no es válido " . $FILES['name'] . "");
        }
    }

    public function validarArchivosType($FILES, $extensionesPermitidos = ["jpg", "jpeg", "png", "webp"])
    {
        for ($i = 0; $i < count($FILES); $i++) {
            $imagen = $FILES["imagen$i"];
            $extension = explode('/', $imagen['type']); //[0]image,[1]png
            if (!in_array($extension[1], $extensionesPermitidos)) {
                $this->errores['validateImagenExtension'] = "Este archivo no es válido " . $imagen['name'];
            }
        }
    }

    public function validarArchivoSize($FILES, $peso = 1000000)
    {

        if ($FILES['size'] > $peso) {
            http_response_code(400);
            $mb = $peso / 1000000;
            $this->responseJSON(400, false, "Este archivo es pesado MAX: $mb mb ");
        }
    }
}