<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController {
    public static function index(Router $router){

        $propiedades = Propiedad::get(3);


        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => true
        ]);
    }
    public static function nosotros(Router $router){
        $router->render('paginas/nosotros', []);
    }
    public static function propiedades(Router $router){

        $propiedades = Propiedad::all();

        $router->render('paginas/propiedades', [
            'propiedades' => $propiedades

        ]);
    }
    public static function propiedad(Router $router){

        $id = validarORredireccionar('/propiedades');

        // buscar la propiedad por su id
        $propiedad = Propiedad::find($id);

        $router->render('paginas/propiedad', [
            'propiedad' => $propiedad

        ]);
    }
    public static function blog(Router $router){
        $router->render('paginas/blog', []);
    }
    public static function entrada(Router $router){
        $router->render('paginas/entrada', []);
    }
    public static function contacto(Router $router){

        $mensaje = null;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $respuestas = $_POST['contacto'];
           
            // crear una instancia de phpmailer
            $mail = new PHPMailer();

            // configurar SMTP
            $mail->isSMTP();
            $mail->Host = $_ENV['MAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Port = $_ENV['MAIL_PORT'];
            $mail->Username = $_ENV['MAIL_USER'];
            $mail->Password = $_ENV['MAIL_PASSWORD'];
            $mail->SMTPSecure = 'tls';
;

            // configurar el contenido del email
            $mail->setFrom('admin@bienesraices.com');
            $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com');
            $mail->Subject = 'Tienes un nuevo mensaje';

            // habilitar html

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
           
            // definir el contenido
            $contenido = '<html>';
            $contenido .= '<p>Tienes un Nuevo Mensaje</p>';
            $contenido .= '<p>Nombre: ' . $respuestas['nombre'] . ' </p>';
            //enviar de forma condicional algunos campos
            if($respuestas['contacto'] === 'telefono'){
                $contenido .= '<p>Eligió ser contactado por telefono</p>';
                $contenido .= '<p>Telefono: ' . $respuestas['telefono'] . ' </p>';
                $contenido .= '<p>Fecha de contacto: ' . $respuestas['fecha'] . ' </p>';
                $contenido .= '<p>Hora de contacto: ' . $respuestas['hora'] . ' </p>';

            } else {
                // es email, entonces agregamos campos de email
                $contenido .= '<p>Eligió ser contactado por email</p>';
                $contenido .= '<p>Email: ' . $respuestas['email'] . ' </p>';
            }
            $contenido .= '<p>Mensaje: ' . $respuestas['mensaje'] . ' </p>';
            $contenido .= '<p>Vende o Compra: ' . $respuestas['tipo'] . ' </p>';
            $contenido .= '<p>Precio o Presupuesto: $' . $respuestas['precio'] . ' </p>';
            $contenido .= '</html>';

            $mail->Body = $contenido;
            $mail->AltBody = 'texto alternativo sin html';

            // enviar el email
            if($mail->send()){
                $mensaje = "Mensaje Enviado Correctamente";
            } else{
                $mensaje = "El Mensaje No Se Pudo Enviar";
            }

        }

        $router->render('paginas/contacto', [
            'mensaje' => $mensaje
        ]);
    }
}
