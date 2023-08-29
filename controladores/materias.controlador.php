<?php

class ControladorMaterias
{
    static public function ctrMostrarMateria($item, $valor)
    {

        $tabla = "materias";

        $respuesta = ModeloMateria::mdlMostrarMateria($tabla, $item, $valor);

        return $respuesta;
    }
}