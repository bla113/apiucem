<?php

class ControladorEstudiante
{
    static public function ctrMostrarEstudiante($item, $valor)
    {

        $tabla = "estudiante";

        $respuesta = ModeloEstudiante::mdlMostrarEstudiante($tabla, $item, $valor);

        return $respuesta;
    }
}
