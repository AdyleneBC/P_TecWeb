<?php

namespace MYAPI\Read;

use MYAPI\DataBase;

class Read extends DataBase
{
    public function __construct($db)
    {
        // MODIFICACIÓN: Sin credenciales
       parent::__construct();
    }

    public function list()
    {
        $this->data = array();

        if ($result = $this->conexion->query("SELECT * FROM recursos WHERE eliminado = 0")) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);

            if (!is_null($rows)) {
                foreach ($rows as $num => $row) {
                    foreach ($row as $key => $value) {
                        $this->data[$num][$key] = $value;
                    }
                }
            }

            $result->free();
        } else {
            die('Query Error: ' . $this->conexion->error);
        }

        $this->conexion->close();
    }

    public function search($string)
    {
        $q = $this->conexion->real_escape_string($string);
        $condId = '';

        if (is_numeric($string)) {
            $id = intval($string);
            $condId = " OR id_recurso = $id ";
        }

        $sql = "SELECT * FROM recursos
                WHERE eliminado = 0 AND (
                    nombre LIKE '%$q%' OR
                    autor LIKE '%$q%' OR
                    departamento LIKE '%$q%' OR
                    empresa LIKE '%$q%' OR
                    descripcion LIKE '%$q%' OR
                    tipo LIKE '%$q%' OR
                    lenguaje LIKE '%$q%'
                    $condId
                )";

        $this->data = array();

        if ($result = $this->conexion->query($sql)) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);

            if (!is_null($rows)) {
                foreach ($rows as $num => $row) {
                    foreach ($row as $key => $value) {
                        $this->data[$num][$key] = $value;
                    }
                }
            }

            $result->free();
        } else {
            die('Query Error: ' . $this->conexion->error);
        }

        $this->conexion->close();
    }

    public function single($string)
    {
        $id = intval($string);
        $sql = "SELECT * FROM recursos WHERE id_recurso = $id LIMIT 1";

        $this->data = array();

        if ($result = $this->conexion->query($sql)) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);

            if (!is_null($rows)) {
                foreach ($rows as $num => $row) {
                    foreach ($row as $key => $value) {
                        $this->data[$num][$key] = $value;
                    }
                }
            }

            $result->free();
        } else {
            die('Query Error: ' . $this->conexion->error);
        }

        $this->conexion->close();
    }
}