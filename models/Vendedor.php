<?php

namespace Model;

class Vendedor extends ActiveRecord {
    protected static $tabla = 'vendedores';

    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono'];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';

    }

    public function validar()
    {
        //VALIDACIONES DEL FORMULARIO
        if (!$this->nombre) {
            self::$errores[] = "Debes añadir un nombre";
        }

        if (!$this->apellido) {
            self::$errores[] = "El apellido es obligatorio";
        }

        if (!$this->telefono) {
            self::$errores[] = "El telefono es obligatorio";
        }

        //expresion regular busca un patron dentro de un texto para validar un nuemro telefonico o correo

        if (!preg_match('/[0-9]{9}/', $this->telefono)) {
            self::$errores[] = "Formato no valido";
        }

        return self::$errores;
    }
    
}