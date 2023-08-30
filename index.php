<?php
date_default_timezone_set("America/Costa_Rica");

$mifecha = date('Y-m-d H:i:s');
require 'vendor/autoload.php';
require 'jwt/vendor/autoload.php';

require 'modelos/usuarios.modelo.php';
require 'controladores/usuarios.controlador.php';

require 'controladores/estudiante.controlador.php';
require 'modelos/estudiante.modelo.php';

require 'controladores/materias.controlador.php';
require 'modelos/materia.modelo.php';


use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/*=============================================
	FUNCION CREAR  TOKEN
	=============================================*/

function validaToken()
{
    try {
        $headers = apache_request_headers();

        $authorization = $headers['Authorization'];

        $authorizationarray = explode(" ", $authorization); //Quita el espacio dejando solo el token

        $token =  $authorizationarray[1]; //posicion donde esta el token



        $token =  JWT::decode($token, new Key('JBRSOLUCIONES', 'HS256'));

        return $token;
    } catch (\Throwable $th) {

        $messaje = [
            'error' => $th->getMessage(),
            'status' => 'Error'
        ];
        Flight::halt(403, json_encode($messaje));
    }
}




Flight::route('/', function () {

    try {

        validaToken();
    } catch (\Throwable $th) {
        $messaje = [
            'error' => $th->getMessage(),
            'status' => 'Error'
        ];
        Flight::halt(403, json_encode($messaje));
    }
});





Flight::route('POST /auth', function () {


    try {



        $usuario = (Flight::request()->data->usuario);
        $password = (Flight::request()->data->password);

        $encriptar = crypt($password, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');



        $valor = $usuario;
        $item = 'usuario';

        $usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);



        if ($usuarios["usuario"] == $usuario && $usuarios["password"] == $encriptar) {

            $now = strtotime("now");


            $key = 'JBRSOLUCIONES';


            $payload = [
                'exp' => $now + 900, //15 minutos 
                'user_id' =>  $usuarios['id'],

            ];

            $jwt = JWT::encode($payload, $key, 'HS256');

            $eliminaToken = ControladorUsuarios::eliminarTokenUsuario($usuarios['id']);

            $guardaToken = ControladorUsuarios::ctrCrearToken($usuarios['id'], $jwt);

            $messaje = [
                'token' => $jwt,
                'user_id' => $usuarios['id']
            ];
            Flight::json($messaje);
        } else {

            //  $messaje = [
            //     'token' => json_encode($jwt),
            //     'user_id' => '1'
            // ];
            // Flight::json($messaje);

            Flight::halt(403, 'incorrect credentials');
        }
    } catch (\Throwable $th) {

        $messaje = [
            'error' => 'Unauthorized',
            'status' => 'User not found'
        ];
        Flight::halt(403, json_encode($messaje));
    }
});





Flight::route('GET /usuario', function () {

    if (validaToken()) {

        $token = validaToken();
        
       

       $id= $token->user_id;

        $item = 'id';


        $valor = $id;

        $usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

        //$user = json_encode($usuarios) ;

        Flight::json($usuarios);
    } else {


        $message = [
            'error' => 'Unauthorized',
            'status' => 'nauthorize fail'
        ];
        Flight::halt(403, json_encode($message));
    }
});



Flight::route('/estudiante/@identificacion', function ($identificacion) {
    if (!validaToken()) {


        $item = 'IDENTIFICACION_ESTUDIANTE';
        $valor = $identificacion;

        $estudiante = ControladorEstudiante::ctrMostrarEstudiante($item, $valor);

        if ($estudiante) {

            Flight::json($estudiante);
        } else {
            $message = [
                'error' => 'Not found',
                'status' => 'Error'
            ];
            Flight::halt(403, json_encode($message));
        }
    } else {
        $message = [
            'error' => 'Not found',
            'status' => 'Error'
        ];

        Flight::halt(403, json_encode($message));
    }
});

Flight::route('/materia/@IDMATERIA', function ($IDMATERIA) {

    if (!validaToken()) {



        $item = 'ID_MATERIA';
        $valor = $IDMATERIA;

        $materia = ControladorMaterias::ctrMostrarMateria($item, $valor);

        if ($materia) {

            Flight::json($materia);
        } else {
            Flight::json(array('MESSAGE' => 'MATERIA NO ENCONTRADA'));
        }
    } else {
        $message = [
            'error' => 'Not found',
            'status' => 'Error'
        ];

        Flight::halt(403, json_encode($message));
    }
});


/*=============================================
	ENVIAR PEFIL DEL USUARIO
	=============================================*/



Flight::route('/materias', function () {

    if (!validaToken()) {



        $item = NULL;
        $valor = null;

        $materia = ControladorMaterias::ctrMostrarMateria($item, $valor);

        if ($materia) {

            Flight::json($materia);
        } else {
            Flight::json(array('MESSAGE' => 'MATERIA NO ENCONTRADA'));
        }
    } else {
        $message = [
            'error' => 'Not found',
            'status' => 'Error'
        ];

        Flight::halt(403, json_encode($message));
    }
});




Flight::start();
