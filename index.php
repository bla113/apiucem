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

/*=============================================
	FIN FUNCION CREAR  TOKEN
	=============================================*/


Flight::route('/', function () {

    try {

        validaToken(); // MANDAMOS A LLAMAR LA FUNCIO DE CREAR EL TOKEN
    } catch (\Throwable $th) {
        $messaje = [
            'error' => $th->getMessage(),
            'status' => 'Necesita credenciales validas para ingresar'
        ];
        Flight::halt(403, json_encode($messaje));
    }
});





Flight::route('POST /auth', function () {//ESTA URL CREA UNA SESION CON NUEVO TOKEN  paramatros( ususario y password)


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
            'status' => 'Usuario no encontrado'
        ];
        Flight::halt(403, json_encode($messaje));
    }
});





Flight::route('GET /usuario', function () {// Obtiene la infirmacion del usuario

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

/*=============================================
	INICIO FUNCION MOSTRAR MATERIAS ESTUDIANTE
	=============================================*/

Flight::route('GET /materias', function () {// Obtiene la infirmacion del usuario

    if (validaToken()) {

        $token = validaToken();
        
       

        $identificacion= $token->user_id;

        $item = 'id';


        $id= $token->user_id;

        $item = 'id';


        $valor = $id;

        $usuarios = ControladorUsuarios::ctrUsuarioParaMateria($item, $valor);
        foreach ($usuarios as $key => $usuarioM) {

           
        }

        $valor = $usuarioM['usuario'];

         $item = 'IDENTIFICACION_ESTUDIANTE';
        
         $itemU='usuario';

         $estudiante = ControladorEstudiante::ctrMostrarEstudiante($item, $valor);

         //$usuarios = ControladorUsuarios::ctrUsuarioParaMateria($itemU, $valor);
      

         $MateriasEstudiante = ControladorMaterias::ctrMostrarToadasMateriasEstudiante($estudiante[0][0]);
         
       

        Flight::json( $MateriasEstudiante );
    } else {


        $message = [
            'error' => 'Unauthorized',
            'status' => 'nauthorize fail'
        ];
        Flight::halt(403, json_encode($message));
    }
});



/*=============================================
	FIN FUNCION MOSTRAR MATERIAS ESTUDIANTE
	=============================================*/



    
/*=============================================
	INICIO FUNCION MOSTRAR MATERIAS A´PROBADAS ESTUDIANTE
	=============================================*/

Flight::route('GET /materias/aprobadas', function () {// Obtiene la infirmacion del usuario

    if (validaToken()) {

        $token = validaToken();
        
       

        $identificacion= $token->user_id;

        $item = 'id';


        $id= $token->user_id;

        $item = 'id';


        $valor = $id;

        $usuarios = ControladorUsuarios::ctrUsuarioParaMateria($item, $valor);
        foreach ($usuarios as $key => $usuarioM) {

           
        }

        $valor = $usuarioM['usuario'];

         $item = 'IDENTIFICACION_ESTUDIANTE';
        
         $itemU='usuario';

         $estudiante = ControladorEstudiante::ctrMostrarEstudiante($item, $valor);

         //$usuarios = ControladorUsuarios::ctrUsuarioParaMateria($itemU, $valor);
      

         $MateriasAprobadas = ControladorMaterias::ctrMostrarMateriasAprobadasEstudiante($estudiante[0][0]);
         
       

        Flight::json( $MateriasAprobadas );
    } else {


        $message = [
            'error' => 'Unauthorized',
            'status' => 'nauthorize fail'
        ];
        Flight::halt(403, json_encode($message));
    }
});



/*=============================================
	FIN FUNCION MOSTRAR MATERIAS ESTUDIANTE
	=============================================*/



        
/*=============================================
	INICIO FUNCION MOSTRAR MATERIAS MATRICULADAS ESTUDIANTE
	=============================================*/

Flight::route('GET /materias/matriculadas', function () {// Obtiene la infirmacion del usuario

    if (validaToken()) {

        $token = validaToken();
        
       

        $identificacion= $token->user_id;

        $item = 'id';


        $id= $token->user_id;

        $item = 'id';


        $valor = $id;

        $usuarios = ControladorUsuarios::ctrUsuarioParaMateria($item, $valor);
        foreach ($usuarios as $key => $usuarioM) {

           
        }

        $valor = $usuarioM['usuario'];

         $item = 'IDENTIFICACION_ESTUDIANTE';
        
         $itemU='usuario';

         $estudiante = ControladorEstudiante::ctrMostrarEstudiante($item, $valor);

         //$usuarios = ControladorUsuarios::ctrUsuarioParaMateria($itemU, $valor);
      

         $MateriasMatriculadas = ControladorMaterias::ctrMostrarMateriasMatriculadasEstudiante($estudiante[0][0]);
         
       

        Flight::json( $MateriasMatriculadas );
    } else {


        $message = [
            'error' => 'Unauthorized',
            'status' => 'nauthorize fail'
        ];
        Flight::halt(403, json_encode($message));
    }
});



/*=============================================
	FIN FUNCION MOSTRAR MATRICULADAS ESTUDIANTE
	=============================================*/




    /*=============================================
	INICIO FUNCION MOSTRAR MATERIAS MATRICULADAS ESTUDIANTE
	=============================================*/

Flight::route('GET /materias/pendientes', function () {// Obtiene la infirmacion del usuario

    if (validaToken()) {

        $token = validaToken();
        
       

        $identificacion= $token->user_id;

        $item = 'id';


        $id= $token->user_id;

        $item = 'id';


        $valor = $id;

        $usuarios = ControladorUsuarios::ctrUsuarioParaMateria($item, $valor);
        foreach ($usuarios as $key => $usuarioM) {

           
        }

        $valor = $usuarioM['usuario'];

         $item = 'IDENTIFICACION_ESTUDIANTE';
        
         $itemU='usuario';

         $estudiante = ControladorEstudiante::ctrMostrarEstudiante($item, $valor);

         //$usuarios = ControladorUsuarios::ctrUsuarioParaMateria($itemU, $valor);
      

         
         $MateriasPendiantes = ControladorMaterias::ctrMostrarMateriasEstudiante($estudiante[0][0]);
       

        Flight::json( $MateriasPendiantes );
    } else {


        $message = [
            'error' => 'Unauthorized',
            'status' => 'nauthorize fail'
        ];
        Flight::halt(403, json_encode($message));
    }
});



/*=============================================
	FIN FUNCION MOSTRAR MATRICULADAS ESTUDIANTE
	=============================================*/



    /*=============================================
	INICIO FUNCION MOSTRAR  ESTUDIANTE
	=============================================*/


   

    Flight::route('GET /estudiante', function () {// Obtiene la infirmacion del usuario

        if (validaToken()) {
    
            $token = validaToken();
            
           
    
            $identificacion= $token->user_id;
    
            $item = 'id';
    
    
            $id= $token->user_id;
    
            $item = 'id';
    
    
            $valor = $id;
    
            $usuarios = ControladorUsuarios::ctrUsuarioParaMateria($item, $valor);
            foreach ($usuarios as $key => $usuarioM) {
    
               
            }
    
            $valor = $usuarioM['usuario'];
    
             $item = 'IDENTIFICACION_ESTUDIANTE';
            
             $itemU='usuario';
    
             $estudiante = ControladorEstudiante::ctrMostrarEstudiante($item, $valor);
    
            Flight::json( $estudiante );
        } else {
    
    
            $message = [
                'error' => 'Unauthorized',
                'status' => 'nauthorize fail'
            ];
            Flight::halt(403, json_encode($message));
        }
    });
    



 /*=============================================
	FIN FUNCION MOSTRAR  ESTUDIANTE
	=============================================*/






Flight::start();
