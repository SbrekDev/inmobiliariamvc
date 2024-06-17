<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManager as Image;
use Intervention\Image\Drivers\Gd\Driver;

class PropiedadController{
    public static function index(Router $router){

        $propiedades = Propiedad::all();

        $vendedores = Vendedor::all();

        // muestra mensaje condicional
        $resultado = $_GET['resultado'] ?? null;

        $router->render("propiedades/admin", [
            'propiedades' => $propiedades,
            'resultado' => $resultado,
            'vendedores' => $vendedores
        ]);
    }
    public static function crear(Router $router){

        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();
        $errores = Propiedad::getErrores();

        if($_SERVER["REQUEST_METHOD"] === "POST") {

            // crea una nueva instancia
        
            $propiedad = new Propiedad($_POST['propiedad']);
        
        
            // subida de archivos
            
        
            // generar nombre unico
        
            $nombreImagen = md5( uniqid(rand(), true) ) . ".jpg";
        
            // setear la img
        
            // realiza un resize a la img con intervetion
            if($_FILES['propiedad']['tmp_name']['imagen']){
                $manager = new Image(Driver::class);
                $image = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->resize(800,600);
                $propiedad->setImagen($nombreImagen);
            }
        
            // validar
            $errores = $propiedad->validar();
            
        
        
            if (empty($errores)){
        
                // crear carpeta 
                if(!is_dir(CARPETA_IMAGENES)){
                    mkdir(CARPETA_IMAGENES);
                }
        
                // guardar la imagen en el servidor
        
                $image->save(CARPETA_IMAGENES . $nombreImagen);
        
                // guarda en la db
        
                $propiedad->guardar(); 
        
            }
        
        
        
        
        }
       
        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }
    public static function actualizar(Router $router){
        
        $id = validarORredireccionar('/admin');

        $propiedad = Propiedad::find($id);
        $vendedores = Vendedor::all();
        $errores = Propiedad::getErrores();

        // metodo post para actualizar
        if($_SERVER["REQUEST_METHOD"] === "POST") {


            // asignar los atributos
        
            $args = $_POST['propiedad'];
        
            $propiedad->sincronizar($args);
        
            // validacion
            $errores = $propiedad->validar();
        
            // subida de archivos **
        
            // generar nombre unico
            $nombreImagen = md5( uniqid(rand(), true) ) . ".jpg";
        
            if($_FILES['propiedad']['tmp_name']['imagen']){
                $manager = new Image(Driver::class);
                $image = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->resize(800,600);
                $propiedad->setImagen($nombreImagen);
            }
        
            // revisar que el array de errores este vacio
            if (empty($errores)){
                if($_FILES['propiedad']['tmp_name']['imagen']){
                     // almacenar la imagen
                    $image->save(CARPETA_IMAGENES . $nombreImagen);
                }
                $propiedad->guardar();
            }
        
        }

        $router->render('/propiedades/actualizar', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }

    public static function eliminar(){
        
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                // validar id
                $id = $_POST['id'];
                $id = filter_var($id, FILTER_VALIDATE_INT);
            
                if($id){
            
                    $tipo = $_POST['tipo'];
            
                    if(validarTipoContenido($tipo)){
                        $propiedad = Propiedad::find($id);
                        $propiedad->eliminar();
                    }
                }                   
        }
    }
}