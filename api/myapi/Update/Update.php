<?php

namespace MYAPI\Update;

use MYAPI\DataBase;

class Update extends DataBase
{
    public function __construct($db)
    {
        // MODIFICACIÓN: Sin credenciales
        parent::__construct();
    }

    public function edit($obj)
    {
        $id = intval($obj['id'] ?? 0);
        $nombre = $this->conexion->real_escape_string($obj['nombre'] ?? '');
        $autor = $this->conexion->real_escape_string($obj['autor'] ?? '');
        $departamento = $this->conexion->real_escape_string($obj['departamento'] ?? '');
        $empresa = $this->conexion->real_escape_string($obj['empresa'] ?? '');
        $fecha_creacion = $this->conexion->real_escape_string($obj['fecha_creacion'] ?? '');
        $descripcion = $this->conexion->real_escape_string($obj['descripcion'] ?? '');
        $tipo = $this->conexion->real_escape_string($obj['tipo'] ?? '');
        $lenguaje = $this->conexion->real_escape_string($obj['lenguaje'] ?? '');

        $extraArchivo = "";

        if (isset($_FILES['archivo'])) {
            $archivoNombre = $_FILES['archivo']['name'];
            $tmp = $_FILES['archivo']['tmp_name'];

            // MODIFICACIÓN: Ruta actualizada
            $destino = __DIR__ . "/../../../app/assets/uploads/" . $archivoNombre;
            move_uploaded_file($tmp, $destino);

            $archivoNombre = $this->conexion->real_escape_string($archivoNombre);
            $extraArchivo = ", archivo='$archivoNombre'";
        }

        $sql = "UPDATE recursos SET
                    nombre='$nombre',
                    autor='$autor',
                    departamento='$departamento',
                    empresa='$empresa',
                    fecha_creacion='$fecha_creacion',
                    descripcion='$descripcion',
                    tipo='$tipo',
                    lenguaje='$lenguaje'
                    $extraArchivo
                WHERE id_recurso=$id";

        if ($this->conexion->query($sql)) {
            $this->data = array('status' => 'success', 'message' => 'Recurso modificado');
        } else {
            $this->data = array('status' => 'error', 'message' => $this->conexion->error);
        }

        $this->conexion->close();
    }
}