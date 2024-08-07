<main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>

        <?php

use Controllers\VendedorController;
use Model\Vendedor;

        if($resultado) :
            $mensaje = mostrarNotificacion(intval($resultado));
            if($mensaje): ?>
                <p class="alerta exito"> <?php echo s($mensaje); ?></p>  
                
            <?php endif; ?>
        <?php endif; ?>
        
        <div class="botones_nuevo">
            <a href="/propiedades/crear" class="boton boton-verde">Nueva Propiedad</a>
            <a href="/vendedores/crear" class="boton boton-amarillo">Nuevo Vendedor</a>
        </div>


        <h2>Propiedades</h2>    

        <table class="propiedades">
            <thead>
                <tr>
                    <th class="hidden_element_xs">ID</th>
                    <th>Titulo</th>
                    <th class="hidden_element_xs">Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody> <!-- mostrar los resultados -->
                <?php foreach( $propiedades as $propiedad ): ?>
                    <tr>
                        <td class="hidden_element_xs"><?php echo $propiedad->id ?></td>
                        <td><?php echo $propiedad->titulo; ?></td>
                        <td class="hidden_element_xs">  <img src="/imagenes/<?php echo $propiedad->imagen; ?>" alt="img prueba" class="imagen-tabla">  </td>
                        <td>$<?php echo $propiedad->precio; ?></td>
                        <td>
                            <form method="POST" class="W-100" action="/propiedades/eliminar">

                                <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>">
                                <input type="hidden" name="tipo" value="propiedad">

                               <input type="submit" value="Eliminar" class="boton-rojo-block">
                            </form>
                            <a href="/propiedades/actualizar?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">Actualizar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Vendedores</h2>

        <table class="propiedades">
            <thead>
                <tr>
                    <th class="hidden_element_xs">ID</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Acciones</th>

                </tr>
            </thead>

            <tbody> <!-- mostrar los resultados -->
                <?php foreach( $vendedores as $vendedor ): ?>
                    <tr>
                        <td class="hidden_element_xs"><?php echo $vendedor->id ?></td>
                        <td><?php echo $vendedor->nombre . " " . $vendedor->apellido; ?></td>
                        <td><?php echo $vendedor->telefono; ?></td>
                        <td>
                            <form method="POST" class="W-100" action="/vendedores/eliminar">
                                <input type="hidden" name="id" value="<?php echo $vendedor->id; ?>">
                                <input type="hidden" name="tipo" value="vendedor">

                               <input type="submit" value="Eliminar" class="boton-rojo-block">
                            </form>
                            <a href="vendedores/actualizar?id=<?php echo $vendedor->id; ?>" class="boton-amarillo-block">Actualizar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

</main>