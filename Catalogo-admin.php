<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

    <!-- sweerAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap");

        body {
            background-image: url(../FRESAS_ARTURO/resource/img/index/fondonitido.png);
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            font-family: 'Poppins', sans-serif;
        }

        .TITULO {
            margin-top: 60px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            text-shadow: 2px 2px 4px #888888;
            font-family: 'Poppins', sans-serif;
        }

        .tabla-container {
            width: 70%;
            /* Ajustar el ancho del contenedor de la tabla */
            margin: 0 auto;
            z-index: -999;
            font-family: 'Poppins', sans-serif;
        }

        .tabla-productos {
            width: 100%;
            border-collapse: collapse;
        }

        .tabla-productos th,
        .tabla-productos td {
            border: 1px solid #d40748;
            padding: 8px;
            text-align: center;
            font-family: 'Poppins', sans-serif;
        }

        .tabla-productos th {
            background-color: #f8eaef;
            color: black;
        }

        .tabla-productos img {
            max-width: 100px;
            display: block;
            margin: auto;
        }

        .btn-custom {
            background-color: #f8eaef;
            color: black;
            border-radius: 5%;
            border: 1px solid #d22c5d;
            padding: 2px 2px;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s;
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
        }

        .btn-custom a {
            transition: background-color 0.3s, color 0.3s;
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
            color: black;
        }

        .btn-custom:hover {
            color: white;
            background-color: #d22c5d;
            cursor: pointer;
        }

        .btn-custom a:hover {
            color: white;
            background-color: #d22c5d;
            cursor: pointer;
        }

        .btn-custom:active {
            transform: translateY(1px);
        }

        input[type="text"] {
            width: 65px;
        }

        .dataTables_wrapper .dataTables_info {
            display: none;
        }

        .dataTables_wrapper .dataTables_filter input {
            margin-bottom: 5%;
        }
    </style>
    <style>
        body .uwy.userway_p1 .userway_buttons_wrapper {
            top: 150px !important;
        }
    </style>
    <script src="https://cdn.userway.org/widget.js" data-account="BD1vuC76ZG"></script>
    <title>CATALOGO | FRESAS DON ARTURO</title>
</head>

<script class="access" src="https://cdn.userway.org/widget.js" data-account="BD1vuC76ZG"></script>

<body>

    <?php
    require_once '../FRESAS_ARTURO/controller/conexion.php';
    include_once '../FRESAS_ARTURO/View/layout/navs/nav-admin-redirect.php';
    echo "<br><br><br>";

    if (isset($_GET['msj_exito'])) {
        $msj_exito = $_GET['msj_exito'];
    }
    ?>

    <div class="TITULO">CATÁLOGO</div>
    <br><br>

    <div class="tabla-container">
        <table id="tabla-productos" class="tabla-productos">
            <thead>
                <tr>
                    <th style="width: 150px;">Categoria</th>
                    <th>Foto</th>
                    <th>Precio</th>
                    <th style="width: 170px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $conexion = new mysqli("localhost", "root", "", "proyecto");

                if ($conexion->connect_error) {
                    die("Error de conexión: " . $conexion->connect_error);
                }

                $sql = "SELECT id_producto, nombre_producto, categoria_producto, precio_producto, imagen FROM productos";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {

                    while ($row = $result->fetch_assoc()) {
                        $nombre_imagen = 'FRESA_' . strtoupper($row['categoria_producto']) . '.jpeg';
                        $ruta_imagen = './model/uploads/' . $nombre_imagen;

                        echo '<tr>';
                        echo '<td>' . $row["categoria_producto"] . '</td>';
                        echo '<td>';
                        if (file_exists($ruta_imagen)) {
                            echo '<img src="' . $ruta_imagen . '" alt="' . $row['categoria_producto'] . '" class="img-item">';
                        } else {
                            echo '<img src="ruta/imagen/por/defecto.jpg" alt="Imagen por defecto" class="img-item">';
                        }
                        echo '</td>';
                        echo '<td>$' . $row["precio_producto"] . '</td>';
                        echo '<td>';
                        echo '<button type="button" class="btn-custom"><a href="../../../FRESAS_ARTURO/model/interfaz_admin/Editar_catalogo.php?id_producto=' . $row['id_producto'] . '">Actualizar</a></button>';
                        echo '</td>';
                        echo '</tr>';
                    }

                    echo '</tbody>';
                    echo '</table>';
                } else {
                    echo "<p>No se encontraron productos.</p>";
                }

                $conexion->close();
                ?>

    </div>
    <br><br><br>
    <br><br><br>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tabla-productos').DataTable({
                "paging": false, // Deshabilitar paginación
                "ordering": false // Deshabilitar ordenamiento
            });
        });

        if (window.location.search.includes('msj_exito')) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Producto actualizado exitosamente",
                showConfirmButton: false,
                timer: 1500
            });
        }
    </script>

    <?php include_once '../FRESAS_ARTURO/view/layout/footers/footer-admin.php'; ?>

</body>

</html>