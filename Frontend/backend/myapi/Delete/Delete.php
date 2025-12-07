<?php

namespace MYAPI\Delete;

use MYAPI\DataBase;

class Delete extends DataBase
{
    public function __construct($db)
    {
        parent::__construct('root', 'adylene', $db);
    }

    public function delete($id)
    {
        $id = intval($id);

        $sql = "UPDATE recursos SET eliminado = 1 WHERE id_recurso = $id";

        if ($this->conexion->query($sql)) {
            $this->data = array('status' => 'success', 'message' => 'Recurso eliminado');
        } else {
            $this->data = array('status' => 'error', 'message' => $this->conexion->error);
        }

        $this->conexion->close();
    }
}
