<?php

class ControladorMaterias
{
    static public function ctrMostrarMateria($item, $valor)
    {

        $tabla = "vista_materias_grupos";

        $respuesta = ModeloMateria::mdlMostrarMateria($tabla, $item, $valor);

        return $respuesta;
    }


    static public function ctrMostrarToadasMateriasEstudiante($valor)
    {
        //$valor1=52;
        $item = 'ID_ESTUDIANTE';

       // $item2 = 'ID_ESTADO_MATERIA';

        $tabla = 'vista_materias_estudiante';

        //$valor2 = 2; //ID DE MATERIAS APROBADAS

        // $tabla = 'vista_materia_estudiante';

        $respuesta = ModeloMateria::mdlMostrarMatriasTodasEstudiante($tabla, $item, $valor);

        return $respuesta;
    }

       /*=============================================
    MOSTRAR TODAS LAS MATERIAS probadas DEL ETUDIANTE
=============================================*/
static public function ctrMostrarMateriasAprobadasEstudiante($valor1)
{


    $item1 = 'ID_ESTUDIANTE';

    $item2 = 'ID_ESTADO_MATERIA';

    $tabla = 'vista_estudiante_materia';

    $valor2 = 2; //ID DE MATERIAS MATRICULADAS

    //$tabla = 'vista_materia_estudiante';

    $respuesta = ModeloMateria::mdlMostrarMatriasAprobadasEstudiante($tabla, $item1, $valor1, $item2, $valor2);

    return $respuesta;
}


/*=============================================
    MOSTRAR TODAS LAS MATERIAS MATRICULADAS DEL ETUDIANTE
=============================================*/
static public function ctrMostrarMateriasMatriculadasEstudiante($valor1)
{


    $item1 = 'ID_ESTUDIANTE';

    $item2 = 'ID_ESTADO_MATERIA';

    $tabla = 'vista_estudiante_materia';

    $valor2 = 3; //ID DE MATERIAS MATRICULADAS

    //$tabla = 'vista_materia_estudiante';

    $respuesta = ModeloMateria::mdlMostrarMatriasMatriculadasEstudiante($tabla, $item1, $valor1, $item2, $valor2);

    return $respuesta;
}

 /*=============================================
    MOSTRAR TODAS LAS PENDIENTES MATERIAS DEL ETUDIANTE
=============================================*/


static public function ctrMostrarMateriasEstudiante($valor1)
{

    $item1 = 'ID_ESTUDIANTE';

    $item2 = 'ID_ESTADO_MATERIA';

    $tabla = 'vista_estudiante_materia';

    $valor2 = 1; //ID DE MATERIAS PENDIENTES

    $respuesta = ModeloMateria::mdlMostrarMateriasEstudiante($tabla, $item1, $valor1, $item2, $valor2);

    return $respuesta;
}
 
}