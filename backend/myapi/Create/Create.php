<?php

namespace MYAPI\Create;

use MYAPI\DataBase;

class Create extends DataBase
{
    public function __construct($db)
    {
        parent::__construct('root', 'adylene', $db);
    }

    public function add($obj)
    {
        $nombre = $this->conexion->real_escape_string($obj['nombre'] ?? '');
        $autor = $this->conexion->real_escape_string($obj['autor'] ?? '');
        $departamento = $this->conexion->real_escape_string($obj['departamento'] ?? '');
        $empresa = $this->conexion->real_escape_string($obj['empresa'] ?? '');
        $fecha_creacion = $this->conexion->real_escape_string($obj['fecha_creacion'] ?? '');
        $descripcion = $this->conexion->real_escape_string($obj['descripcion'] ?? '');
        $tipo = $this->conexion->real_escape_string($obj['tipo'] ?? '');
        $lenguaje = $this->conexion->real_escape_string($obj['lenguaje'] ?? '');

        // ---------- ARCHIVO ----------
        $archivoNombre = "";

        if (isset($_FILES['archivo'])) {
            $archivoNombre = $_FILES['archivo']['name'];
            $tmp = $_FILES['archivo']['tmp_name'];

            $destino = __DIR__ . "/../../../assets/uploads/" . $archivoNombre;
            move_uploaded_file($tmp, $destino);
        }

        $archivoNombre = $this->conexion->real_escape_string($archivoNombre);

        $sql = "INSERT INTO recursos
                (nombre, autor, departamento, empresa, fecha_creacion, descripcion, tipo, lenguaje, archivo, eliminado)
                VALUES
                ('$nombre', '$autor', '$departamento', '$empresa', '$fecha_creacion',
                 '$descripcion', '$tipo', '$lenguaje', '$archivoNombre', 0)";

        if ($this->conexion->query($sql)) {
            $this->data = array('status' => 'success', 'message' => 'Recurso agregado');
        } else {
            $this->data = array('status' => 'error', 'message' => $this->conexion->error);
        }

        $this->conexion->close();
    }
}
