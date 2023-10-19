<?php


namespace App;
            // Extends hace referencia a heredar seguido de la clase
class Propiedad extends ActiveRecord {
    // Hace referencia a la base de datos a la tabla porpiedades 
    protected static $tabla = 'propiedades';
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedores_id' ];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedores_id;

    // Definimos el constructor
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? NULL; 
        $this->titulo = $args['titulo'] ?? ''; 
        $this->precio = $args['precio'] ?? ''; 
        $this->imagen = $args['imagen'] ?? ''; 
        $this->descripcion = $args['descripcion'] ?? ''; 
        $this->habitaciones = $args['habitaciones'] ?? ''; 
        $this->wc = $args['wc'] ?? ''; 
        $this->estacionamiento = $args['estacionamiento'] ?? ''; 
        $this->creado = date('Y-m-d'); 
        $this->vendedores_id = $args['vendedores_id'] ?? ''; 
    }


}




