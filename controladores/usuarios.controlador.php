<?php

class ControladorUsuarios
{
    static public function ctrMostrarUsuarios($item, $valor)
    {

        $tabla = "usuarios";

        $respuesta = ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);

        return $respuesta;
    }

    static function ctrCrearToken($usuario, $token)
    {

        $tabla = 'usuarios_token';
        $datos = [
            'usuario' => $usuario,
            'token' => $token
        ];

        $respuesta = ModeloUsuarios::mdlCrearToken($tabla, $datos);
    }



    static public function eliminarTokenUsuario($id)
    {

        $tabla = 'usuarios_token';
        $datos = $id;
        $respuesta = ModeloUsuarios::mdlElimininarTokenUsuario($tabla, $datos);
        return $respuesta;
    }
}
