<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;



class VendedorController{
    public static function crear(Router $router){
        $errores = Vendedor::getErrores();
        $vendedor = new Vendedor;

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            // crear una nueva instancia
         
            $vendedor = new Vendedor($_POST['vendedor']);
         
            // validar campos 
            $errores = $vendedor->validar();
         
            // no hay errores
         
            if(empty($errores)){
                 $vendedor->guardar();
            }
         
         }

        $router->render('vendedores/crear', [
            'errores' => $errores,
            'vendedores' => $vendedor
        ]);
    }

    public static function actualizar(Router $router){

        $errores = Vendedor::getErrores();
        $id = validarORredireccionar('/admin');

        // obtener datos del vendedor a actualizar

        $vendedor = Vendedor::find($id);

        
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            
            // asignar los valores 
            $args = $_POST['vendedor'];

            // sincronizar obj en memoria con lo que el usuario escribe
            $vendedor->sincronizar($args);

            //validacion
            $errores = $vendedor->validar();

            if(empty($errores)){
                $vendedor->guardar();
            }
        }

        $router->render('vendedores/actualizar', [
            'errores' => $errores,
            'vendedor' => $vendedor

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
                    $vendedor = Vendedor::find($id);
                    $propiedades = Propiedad::all();
                    $match = false;

                    foreach($propiedades as $propiedad){
                        if($vendedor->id === $propiedad->vendedorId){
                            $match = true;
                            break;
                        } 
                    }

                    if(!$match){
                        $vendedor->eliminar();
                    } else{
                        header('Location: /admin');
                    }       
                }
            }                   
        }
    }
    
}