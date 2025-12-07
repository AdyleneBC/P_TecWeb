<?php

namespace MYAPI\Create;

use MYAPI\DataBase;

class Create extends DataBase
{
    public function __construct($db)
    {
        //inicializamos la conexion usando los datos del usuario root y la base recibida
        parent::__construct('root', 'adylene', $db);
    }

    public function add($obj)
    {
        //leemos los datos del formulario y se limpian para evitar caracteres raros en SQL
        $nombre = $this->conexion->real_escape_string($obj['nombre'] ?? '');
        $autor = $this->conexion->real_escape_string($obj['autor'] ?? '');
        $departamento = $this->conexion->real_escape_string($obj['departamento'] ?? '');
        $empresa = $this->conexion->real_escape_string($obj['empresa'] ?? '');
        $fecha_creacion = $this->conexion->real_escape_string($obj['fecha_creacion'] ?? '');
        $descripcion = $this->conexion->real_escape_string($obj['descripcion'] ?? '');
        $tipo = $this->conexion->real_escape_string($obj['tipo'] ?? '');
        $lenguaje = $this->conexion->real_escape_string($obj['lenguaje'] ?? '');

        //variable donde se guardara el nombre del archivo subido
        $archivoNombre = "";

        //si viene un archivo en la peticion se toma su nombre y se mueve a la carpeta uploads
        if (isset($_FILES['archivo'])) {
            $archivoNombre = $_FILES['archivo']['name'];
            $tmp = $_FILES['archivo']['tmp_name'];
            //uta fisica donde se guardara el archivo dentro del proyecto
            $destino = __DIR__ . "/../../../assets/uploads/" . $archivoNombre;
            move_uploaded_file($tmp, $destino);
        }


        //limpiamos el nombre final antes de insertarlo
        $archivoNombre = $this->conexion->real_escape_string($archivoNombre);

        //consulta para insertar el recurso con eliminado en 0 para borrado logico
        $sql = "INSERT INTO recursos
                (nombre, autor, departamento, empresa, fecha_creacion, descripcion, tipo, lenguaje, archivo, eliminado)
                VALUES
                ('$nombre', '$autor', '$departamento', '$empresa', '$fecha_creacion',
                 '$descripcion', '$tipo', '$lenguaje', '$archivoNombre', 0)";
        
        //si la consulta se ejecuta bien se manda mensaje de exito, si no, se manda el error de mysql
        if ($this->conexion->query($sql)) {
            $this->data = array('status' => 'success', 'message' => 'Recurso agregado');
        } else {
            $this->data = array('status' => 'error', 'message' => $this->conexion->error);
        }

        //se cierra la conexion al terminar
        $this->conexion->close();
    }
}
