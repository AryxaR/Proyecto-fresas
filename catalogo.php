<?php
session_start();
require_once('../FRESAS_ARTURO/controller/conexion.php');
if ($conn === null) {
    die("Error de conexión: " . mysqli_connect_error());
}
include_once('../FRESAS_ARTURO/view/layout/navs/nav-usuario.php');

// Inicializar el carrito en la sesión si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}

// Función para obtener la ruta de la imagen
function obtenerRutaImagen($categoria)
{
    $nombre_imagen = 'FRESA_' . strtoupper($categoria) . '.jpeg';
    return './model/uploads/' . $nombre_imagen;
}

// Función para mostrar el modal con los productos del carrito
function mostrarModalCarrito()
{
    echo '<div class="modal fade" id="modal-carrito" tabindex="-1" aria-labelledby="modal-carrito-label" aria-hidden="true">';
    echo '<div class="modal-dialog modal-dialog-centered modal-lg">';
    echo '<div class="modal-content">';
    echo '<div class="modal-header">';
    echo '<h5 class="modal-title" id="modal-carrito-label">Carrito de Compras</h5>';
    echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
    echo '</div>';
    echo '<div class="modal-body">';

    // Verificar si hay productos en el carrito
    if (!empty($_SESSION['carrito'])) {
        echo '<div class="table-responsive">';
        echo '<table class="table table-striped">';
        echo '<thead>';
        echo '<tr>';
        echo '<th></th>';
        echo '<th>Producto</th>';
        echo '<th>Categoría</th>';
        echo '<th>Precio Unitario</th>';
        echo '<th>Cantidad</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $total = 0;

        foreach ($_SESSION['carrito'] as $id_producto => $producto) {
            echo '<tr>';
            echo '<td><img src="' . obtenerRutaImagen($producto['categoria']) . '" alt="' . $producto['categoria'] . '" class="img-fluid" style="max-width: 60px;"></td>';
            echo '<td>' . $producto['nombre'] . '</td>';
            echo '<td>' . $producto['categoria'] . '</td>';
            echo '<td>$' . $producto['precio'] . '</td>';
            echo '<td>' . $producto['cantidad'] . '</td>';

            echo '<td><form method="post" action="../FRESAS_ARTURO/controller/eliminar_producto.php">';
            echo '<input type="hidden" name="id_producto" value="' . $id_producto . '">';
            echo '<button type="submit" class="btn btn-link"><i class="bi bi-trash"></i></button>';
            echo '</form></td>';
            echo '</tr>';
            $subtotal = $producto['precio'] * $producto['cantidad'];
            $total += $subtotal;
        }


        echo '<tr>';
        echo '<td colspan="3"></td>'; // Espacio para las primeras tres columnas
        echo '<td><strong>Total:</strong></td>';
        echo '<td>$' . number_format($total, 2) . '</td>'; // Mostrar el total formateado con dos decimales
        echo '</tr>';

        echo '</tbody>';
        echo '</table>';
        echo '</div>'; // Cerrar table-responsive
    } else {
        echo 'El carrito está vacío.';
    }

    echo '</div>'; // Cerrar modal-body
    echo '<div class="modal-footer">';
    echo '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CATÁLOGO</title>
    <!-- Enlace al archivo CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="../FRESAS_ARTURO/resource/css/Style-catalogo.css">
</head>

<body>

    <div class="TITULO">
        <h1>CATÁLOGO</h1>
    </div>
    <br><br>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-carrito">
        <i class="bi bi-cart"></i>
    </button>
    <section class="contenedor-general">
        <div class="contenedor-items">
            <?php
            // Mostrar los productos
            $sql = "SELECT id_producto, nombre_producto, categoria_producto, precio_producto FROM productos";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $ruta_imagen = obtenerRutaImagen($row['categoria_producto']);
            ?>
                    <div class="item">
                        <input type="hidden" name="id_producto" value="<?php echo $row['id_producto']; ?>">
                        <span class="titulo-item"><?php echo $row['categoria_producto']; ?></span>
                        <?php if (file_exists($ruta_imagen)) { ?>
                            <img src="<?php echo $ruta_imagen; ?>" alt="<?php echo $row['categoria_producto']; ?>" class="img-item">
                        <?php } else { ?>
                            <img src="ruta/imagen/por/defecto.jpg" alt="Imagen por defecto" class="img-item">
                        <?php } ?>
                        <h6>*EL PRECIO DE VENTA ES POR "CANASTILLA = 8KG"</h6>
                        <span class="precio-item">$<?php echo $row['precio_producto']; ?></span>
                        <!-- Input para ingresar la cantidad -->
                        <form method="post" action="../FRESAS_ARTURO/controller/Detalleventa.php">
                            <input type="hidden" name="id_producto" value="<?php echo $row['id_producto']; ?>">
                            <input type="number" name="cantidad" placeholder="Cantidad (Canastilla)" required>
                            <button type="submit" class="btn btn-primary">Agregar al carrito</button>
                        </form>
                    </div>
            <?php
                }
            } else {
                echo "No se encontraron productos.";
            }
            $conn->close();
            ?>
        </div>
    </section>

    <!-- Incluir el modal del carrito -->
    <?php mostrarModalCarrito(); ?>

    <!-- Incluir los scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#modal-carrito').modal('show'); // Abrir el modal al cargar la página
        });
    </script>
</body>

</html>