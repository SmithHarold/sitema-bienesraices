<?php

namespace Model;

class ActiveRecord
{
    // base de datos 
    protected static $db;
    protected static $columnasDB = [];

    protected static $tabla = '';
    // (errores)
    protected static $errores = [];


    

    // definir la conexion a la BD
    public static function setDB($database)
    {
        self::$db = $database;
    }

    

    public function guardar()
    {

        if (!is_null($this->id)) {
            //actualizar
            $this->actualizar();
        } else {
            //creandu nuevo
            $this->crear();
        }
    }



    public function crear()
    {

        // sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        //insertar en la base de datos

        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        $resultado = self::$db->query($query);

        if ($resultado) {

            // redireciionamiento
            // header('Location: /bienesraices/admin/index.php?resultado=1');
            header('Location: /admin?resultado=1');
        }

        // return $resultado;


    }

    public function actualizar()
    {
        // sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }
        //actualizar en la base de datos
        $query = " UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";


        $resultado = self::$db->query($query);

        if ($resultado) {

            //se redirecciona al usuario
            header('Location: /admin?resultado=2');
        }
    }

    //Eliminar un registro
    public function eliminar()
    {
        //eliminar la propiedad
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);

        if ($resultado) {
            $this->borrarImagen();

            header('Location: /admin?resultado=3');
        }
    }


    //identifica los datos y los une
    public function atributos()
    {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            if ($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;

        // debugear($sanitizado);

    }

    // Subida de archivos
    public function setImagen($imagen)
    {
        if (!is_null($this->id)) {
            $this->borrarImagen();
        }

        if ($imagen) {
            $this->imagen = $imagen;
        }
    }

    //eliminar el archivo
    public function borrarImagen()
    {
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if ($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }


    //validacion
    public static function getErrores()
    {
        
        return static::$errores;
    }

    public function validar()
    {
        static::$errores = [];
        return static::$errores;
    }

    // lista todas los registros
    public static function all()
    {
        $query = "SELECT * FROM " . static::$tabla;
        // debugear($query);

        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    // obtener determinado numero de registros
    public static function get($cantidad)
    {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;
        // debugear($query);

        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    // buscar registro por ID
    public static function find($id)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = $id";

        $resultado = self::consultarSQL($query);

        return array_shift($resultado);
    }


    public static function consultarSQL($query)
    {
        //consultar la bd
        $resultado = self::$db->query($query);

        //iterarl los resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        //liberar la memoria
        $resultado->free();

        //retornar los resultados
        return $array;
    }

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

    //sincroniza el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}
