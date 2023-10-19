<?php

namespace App;

class Vendedor extends ActiveRecord {
    protected static $tabla = 'vendedores';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono'];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    // Definimos el constructor
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? NULL; 
        $this->nombre = $args['nombre'] ?? ''; 
        $this->apellido = $args['apellido'] ?? ''; 
        $this->telefono = $args['telefono'] ?? ''; 
    }

    public function validar() {
        if(!$this->nombre) {
            self::$errores[] = 'Debes añadir un nombre';
        }

        if(!$this->apellido) {
            self::$errores[] = 'Debes añadir un apellido';
        }

        if(!preg_match('/^[^\s]+$/i', $this->apellido)) {
            self::$errores[] = 'Solo puedes añadir un apellido y sin espacios';
        }

        if(!$this->telefono) {
            self::$errores[] = 'Debes añadir un teléfono';
        }

        // Utilizamos una expresión regular para que no se pueda añadir letras en el campo de telefono
        // Utilizamos preg_match que es nativa de php para expresiónes regulares
        if(!preg_match('/[0-9]{9}/', $this->telefono)) {
            self::$errores[] = 'Formato no Valido';
        }

        return self::$errores;
    }    
}