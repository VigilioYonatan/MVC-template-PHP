<?php

namespace App;

use PDO;

abstract class ActiveRecord extends Validaciones
{
    protected static $tabla = '';
    protected static $db;
    protected static $columnasDB = [];

    public static function setDb($database)
    {
        self::$db = $database;
    }
    // Crea el objeto en memoria que es igual al de la BD
    protected static function crearObjeto($registro)
    {
        $objeto = new static;

        foreach ($registro as $key => $value) {

            if (property_exists($objeto, $key)) {

                $objeto->$key = $value;
            }
        }

        return $objeto;
    }
    // Consulta SQL para crear un objeto en Memoria
    public static function consultarSQL($query)
    {
        // Consultar la base de datos
        $stmt = self::$db->prepare($query);
        $stmt->execute();


        // Iterar los resultados
        $array = [];
        while ($registro = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $array[] = static::crearObjeto($registro);
        }
        $stmt->closeCursor();
        return $array;
    }
    public function closeServidor()
    {
        self::$db = null;
    }



    // Identificar y unir los atributos de la BD
    public function atributos()
    {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            if ($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    // Sanitizar los datos antes de guardarlos en la BD
    public function sanitizarAtributos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach ($atributos as $key => $value) {

            $sanitizado[$key] = self::$db->quote($value);
        }
        return $sanitizado;
    }

    // Sincroniza BD con Objetos en memoria
    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

    // Registros - CRUD
    public function guardar()
    {
        $resultado = '';
        if (!is_null($this->id)) {
            // actualizar
            $resultado = $this->actualizar();
        } else {
            // Creando un nuevo registro
            $resultado = $this->crear();
        }
        return $resultado;
    }

    // Todos los registros
    public static function all()
    {
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busca un registro por su id
    public static function find($id)
    {
        $query = "SELECT * FROM " . static::$tabla  . " WHERE id = ${id}";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    // Obtener Registros con cierta cantidad
    public static function get($limite)
    {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT ${limite}";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    // Busca un registro por su id
    public static function where($columna, $token)
    {
        $query = "SELECT * FROM " . static::$tabla  . " WHERE ${columna} = '${token}'";
        $resultado = self::consultarSQL($query);

        return array_shift($resultado);
    }

    // crea un nuevo registro
    public function crear()
    {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (";
        $query .= join(", ", array_values($atributos));
        $query .= ") ";
        // Resultado de la consulta


        $resultado = self::$db->exec($query);
        return [
            'resultado' =>  $resultado,
            'id' => self::$db->lastInsertId()
        ];
    }

    // Actualizar el registro
    public function actualizar()
    {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Iterar para ir agregando cada campo de la BD
        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key}={$value}";
        }

        // Consulta SQL
        $query = "UPDATE " . static::$tabla . " SET ";
        $query .=  join(', ', $valores);
        $query .= " WHERE id = " . self::$db->quote($this->id) . " ";
        $query .= " LIMIT 1 ";

        // Actualizar BD
        $stmt = self::$db->prepare($query);

        $resultado = $stmt->execute();

        return  $resultado;
    }

    // Eliminar un Registro por su ID
    public function eliminar()
    {
        $query = "DELETE FROM "  . static::$tabla . " WHERE id = " . self::$db->quote($this->id) . " LIMIT 1";
        $resultado = self::$db->exec($query);
        return $resultado;
    }

    public function buscador($columna, $buscar)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE  $columna LIKE '%$buscar%'";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
}