<?php 
// Esta va a ser la clase principal y sobre esta van a heredar las demas

namespace App;

class ActiveRecord {
        // Base de datos
        protected static $db;
        // Sanitizar los datos
        protected static $columnasDB = [];
        protected static $tabla = '';
        // Errores o Validacion
        protected static $errores = [];
    
        // Definir la conexion a la base de datos
        public static function setDB($database){
            self::$db = $database;
        }
       
        
       
        public function guardar() {
            if(!is_null($this->id)) {
                // actualizar
                $this->actulizar();
            } else {
                // Creando un nuevo registro
                $this->crear();
            }
        }
        public function crear() {
    
            // Sanitizar los datos
            $atributos = $this->sanitizarDatos();
    
            // Insertar los datos en la base de datos
            // Forma larga y facil
            // $query = 
            // "INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado, vendedores_id)
            // VALUES ('$this->titulo', '$this->precio', '$this->imagen', '$this->descripcion', '$this->habitaciones', '$this->wc', '$this->estacionamiento', '$this->creado', '$this->vendedores_id')
            //  ";
    
            // Forma corta y mas complicada
            // join(', ', array_keys($atributos)) para obtener una cadena que contiene los nombres de las columnas en la tabla "propiedades". $atributos parece ser un arreglo asociativo donde las claves son los nombres de las columnas y los valores son los valores que se desean insertar en esas columnas. array_keys($atributos) obtiene todas las claves (nombres de columnas) del arreglo y las une en una cadena separada por comas y espacios. Esto proporciona la parte de la consulta SQL que enumera las columnas en las que se insertarán datos.
            // join(',', array_values($atributos)) para obtener una cadena que contiene los valores que se insertarán en las columnas correspondientes. array_values($atributos) obtiene todos los valores del arreglo $atributos y los une en una cadena separada por comas. Esto proporciona la parte de la consulta SQL que enumera los valores que se insertarán en las columnas de la tabla.
            $query = "INSERT INTO " . static::$tabla . " ( ";
            $query .= join(', ', array_keys($atributos));
            $query .= " ) VALUES (' ";
            $query .= join("','", array_values($atributos));
            $query .= " ') ";
    
            $resultado = self::$db->query($query);
    
            // Mensaje de exito
            if($resultado) {
                // Redireccionar a el usuario
                header('Location: /admin?resultado=1');
            }      
        }
    
        public function actulizar() {
           // Sanitizar los datos
           $atributos = $this->sanitizarDatos();
    
           $valores = [];
           foreach($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
           }
           $query = "UPDATE " . static::$tabla . " SET ";
           $query .=  join(', ', $valores);
           $query .= " WHERE id = '" . self::$db->escape_string($this->id) ."' ";
           $query .= " LIMIT 1 ";
    
           $resultado = self::$db->query($query);
    
           if($resultado) {
            // Redireccionar a el usuario
            header('Location: /admin?resultado=2');
        }
        }
    
        // Eliminar un registro
        public function eliminar() {
            //  Eliminar el registro   
            // Hacemos la peticion a la base de datos,        Escape_string se utilizar para que no se pueda usar un codigo malicioso
             $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1 ";
             $resultado = self::$db->query($query);
    
    
            if($resultado) {
                // Eliminar la imagen de la propieda que hemos eliminado
                $this->borrarImagen();
    
                header('location: /admin?resultado=3');
            }
        }
    
    
        // Esplicacion 1
        // Este va a iterar sobre columnasDB
        // Su funcion es identificar y unir los atributos a la DB
        public function datos() {
            $datos = [];
            // Utilizamos el foreach por que itera sobre un arreglo 
            foreach(static::$columnasDB as $columna) {
                // Este nos sirve para que cuando se ejecuto la condicion saltea al siguiente ya que el id se asigna en la base datos
                if($columna === 'id') continue;
                // Hacemos referencia a el objeto que tenemos en memoria (En el constuctor de el objeto)
                $datos[$columna] = $this->$columna;
            }
    
            return $datos;
        }
    
        // Esplicacion 2
        // Sanitizar datos
        public function sanitizarDatos() {
            // Llamamos a los datos que hemos obtenido para sanitizarlos
            $datos = $this->datos();
            $sanitizando = [];
    
            // Usamos key y value para iterar sobre la clave, valor
            foreach($datos as $key => $value) {
                $sanitizando[$key] = self::$db->escape_string($value);
            }
    
            return $sanitizando;
        }
    
        // Subida de archivos
        public function setImagen($imagen) {
            // Eliminar la imagen previa
            if(!is_null($this->id)) {
                $this->borrarImagen();
            }
    
            // Asignar al atributo de imagen el nombre de la imagen
            if($imagen) {
                $this->imagen = $imagen;
            }
        }
    
        // Eliminar archivo (Imagen)
        public function borrarImagen() {
            //Comprobar si existe el archivo
            $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
            if($existeArchivo) {
                unlink(CARPETA_IMAGENES . $this->imagen);
            }
        }
    
        // Validacion
        public static function getErrores() {
            return self:: $errores;
        }
    
        public function validar() {
            if(!$this->titulo) {
                self::$errores[] = 'Debes añadir un titulo';
            }
    
            if(!$this->precio) {
                self::$errores[] = 'Debes añadir un precio';
            }
    
            if(strlen($this->descripcion) < 10) {
                self::$errores[] = 'Debes añadir una descripción o debe contener más de cincuenta caracteres';
            }
    
            if(!$this->habitaciones) {
                self::$errores[] = 'Debes añadir un numero de habitaciones';
            }
    
            if(!$this->wc) {
                self::$errores[] = 'Debes añadir un numero de wc';
            }
    
            if(!$this->estacionamiento) {
                self::$errores[] = 'Debes añadir un numero de estacionamiento';
            }
    
            if(!$this->vendedores_id) {
                self::$errores[] = 'Debes añadir elegir un vendedor';
            }
    
            if(!$this->imagen) {
               self::$errores[] = 'La Imagen es Obligatoria o pesa mas de dos megas';
            }
    
            return self::$errores;
        }
    
        // Lista todas las propiedaes
        public static function all() {
            //                          static hereda el metodo y busca el atributo en la clase que hereda
            $query = "SELECT * FROM " . static::$tabla;
    
           $resultado = self::consularSQL($query);
    
           return $resultado;
        }

        // Obtiene determinado nùmero de registros
        public static function get($cantidad) {
            //                          static hereda el metodo y busca el atributo en la clase que hereda
            $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;

            $resultado = self::consularSQL($query);
    
            return $resultado;
        }
    
        // Busca un registro por su id
        public static function find($id) {
            $query = "SELECT * FROM " . static::$tabla . " WHERE id = $id";
    
            $resultado = self::consularSQL($query);
            return array_shift($resultado);
        }
    
        public static function consularSQL($query) {
            // Consultar la base de datos
            $resultado = self::$db->query($query);
    
            // Iterar los resultados
            $array = [];
            while($registro = $resultado->fetch_assoc()) {
                $array[] = static::crearObjeto($registro);
            }
            
            // Liberar la memoria
            $resultado->free();
    
            // Retornar los resultados
            return $array;
        }
        
        // Este va a tomar los arreglos que vienen de la base de datos y los pasa a objetos
        protected static function crearObjeto($registro) {
            // new self crea una nueva propiedad (Es la clase padre Poo es decir todos el objeto)
            $objeto = new static;
            
            foreach($registro as $key => $value ) {
                // Porperty_exists, verifica si una propiedad existe
                if( property_exists($objeto, $key)) {
                    $objeto->$key = $value;
                }
            }
            return($objeto);
        }
    
        // Sincroniza el objeto en memoria con los cambios realizados por el usuario
        public function sincronizar( $args = [] ) {
            foreach($args as $key => $value) {
                if(property_exists($this, $key) && !is_null($value)) {
                    $this->$key = $value;
                }
            }
        }
}

// Esplicacion 1
// El fragmento de código que proporcionaste es una función llamada datos() que parece estar diseñada para obtener los datos de un objeto en forma de un arreglo asociativo. Aquí está la explicación paso a paso:

//     Se define una función llamada datos() dentro de una clase. Esta función probablemente forma parte de una clase que tiene una serie de propiedades (atributos) definidas en ella.
    
//     Se crea una variable llamada $datos como un arreglo vacío ([]). Esta variable se usará para almacenar los datos del objeto en un formato diferente.
    
//     Se utiliza un bucle foreach para iterar sobre un arreglo llamado self::$columnasDB. Esto parece indicar que la clase tiene una propiedad estática llamada $columnasDB, que es un arreglo que contiene los nombres de las columnas de una base de datos. El bucle foreach recorre este arreglo.
    
//     En cada iteración del bucle foreach, se toma el valor de la variable $columna (que representa un nombre de columna de la base de datos) y se utiliza como una clave para el arreglo $datos. Luego, se asigna el valor correspondiente de la propiedad del objeto actual ($this->$columna) a esa clave en el arreglo $datos. Esto significa que se está creando un arreglo asociativo donde las claves son los nombres de las columnas de la base de datos y los valores son los valores de esas columnas en el objeto actual.
    
//     Una vez que se ha completado el bucle foreach, el arreglo $datos contiene todos los datos del objeto en un formato que puede ser fácilmente utilizado o manipulado.
    
//     Finalmente, la función devuelve el arreglo $datos que contiene los datos del objeto en forma de un arreglo asociativo.
    
//     En resumen, esta función toma las propiedades de un objeto y las almacena en un arreglo asociativo donde las claves son los nombres de las columnas de la base de datos y los valores son los valores correspondientes de esas columnas en el objeto. Esto puede ser útil, por ejemplo, al interactuar con bases de datos o al necesitar una representación de los datos del objeto en forma de arreglo.


// Esplicacion 2
// La función sanitizarDatos() parece estar diseñada para "sanitizar" o limpiar los datos contenidos en un objeto. La sanitización de datos es un proceso importante en la programación para evitar problemas de seguridad, como la inyección de SQL o ataques de scripting malicioso (XSS). Aquí está una explicación paso a paso de cómo funciona esta función:

// La función sanitizarDatos() se define dentro de una clase. En esta función, se asume que ya se han obtenido los datos del objeto llamando a la función datos(), que probablemente sea una función definida en la misma clase o en una clase relacionada.

// Se llama a la función datos() para obtener los datos del objeto. Esto se hace asignando los datos del objeto a la variable $datos.

// Se crea una variable llamada $sanitizando como un arreglo vacío. Esta variable se usará para almacenar los datos sanitizados.

// Se utiliza un bucle foreach para iterar a través de cada par clave-valor en el arreglo $datos. En este bucle, $key representa la clave (nombre de la columna de la base de datos) y $value representa el valor correspondiente del objeto.

// Dentro del bucle foreach, se llama a self::$db->escape_string($value). Esto parece indicar que $db es una propiedad estática de la clase actual que representa una conexión a la base de datos (probablemente un objeto mysqli). La función escape_string() se utiliza para escapar o limpiar el valor $value para que sea seguro utilizarlo en una consulta de base de datos.

// El valor escapado resultante se asigna a la clave correspondiente en el arreglo $sanitizando. Esto significa que se está creando un nuevo arreglo llamado $sanitizando, que contiene los mismos nombres de columnas que $datos, pero con los valores escapados y seguros para usar en una consulta de base de datos.

// Finalmente, la función sanitizarDatos() devuelve el arreglo $sanitizando que contiene los datos del objeto sanitizados y listos para ser utilizados en consultas de base de datos u otros contextos donde se requiera seguridad.

// En resumen, la función sanitizarDatos() toma los datos del objeto y los limpia o sanitiza para evitar problemas de seguridad en una base de datos u otros lugares donde se utilicen los datos. Esto es una buena práctica para prevenir ataques de seguridad.