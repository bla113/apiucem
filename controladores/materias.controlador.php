<?php

class ControladorMaterias
{
    static public function ctrMostrarMateria($item, $valor)
    {

        $tabla = "vista_materias_grupos";

        $respuesta = ModeloMateria::mdlMostrarMateria($tabla, $item, $valor);

        return $respuesta;
    }
}