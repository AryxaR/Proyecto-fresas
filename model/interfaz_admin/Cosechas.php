<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['Id_cliente'])) {
    // Si no ha iniciado sesión, redirigir al usuario a la página de inicio de sesión
    header("Location: ../login_usuarios.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COSECHAS | FRESAS DON ARTURO</title>
    <link rel="icon" href="../../resource/img/icons/strawberry.png" type="image/png">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <link rel="stylesheet" href="../../resource/css/consult.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" />


    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap");


        body {
            background-image: url(../../resource/img/index/fondoborroso.png);
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            font-family: 'Poppins', sans-serif;
        }

        body .uwy.userway_p1 .userway_buttons_wrapper {
            top: 120px !important;
            right: auto;
            bottom: auto;
            left: calc(100vw - 21px);
            transform: translate(-100%);
        }


        .TITULO {
            margin-top: 60px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            text-shadow: 2px 2px 4px #888888;
            font-family: 'Poppins', sans-serif;
        }


        .dataTables_wrapper {
            margin-top: -2%;
        }

        .dataTables_length {
            margin-left: -51.5%;
        }

        .dataTables_filter {
            margin-right: 20%;
            margin-bottom: 1%;
        }

        .dataTables_info {
            margin-left: 1%;
        }

        .dataTables_paginate {
            margin-top: 0.8%;
            margin-right: 11%;
        }


        div.dt-buttons {
            margin-top: 3%;
            margin-left: 19%;
            border: none;
            margin-bottom: -1.5%;

        }

        #proveedores-table_wrapper .btn-pdf {
            background-color: #F44336;
            color: #ffffff;
            padding: 8px 12px;
            font-size: 18px;
            border-radius: 7%;
            border: 0.01px solid black;
        }

        #proveedores-table_wrapper .btn-print {
            background-color: #448AFF;
            color: #ffffff;
            padding: 8px 12px;
            font-size: 18px;
            border-radius: 7%;
            border: 0.01px solid black;
        }

        #proveedores-table_wrapper .btn-pdf:hover,
        #proveedores-table_wrapper .btn-print:hover {
            color: black;
            cursor: pointer;
        }

        .usuarios-table {
            width: 95%;
            max-width: 1200px;
            border-collapse: collapse;
        }

        .usuarios-table th,
        .usuarios-table td {
            padding: 8px;
            text-align: left;
            border: 1px solid #666666;
            font-family: 'Poppins', sans-serif;
        }

        .usuarios-table th {
            background-color: #f2f2f2;
        }



        .btn-icon {
            background-color: #f8eaef;
            color: black;
            border-radius: 5%;
            border: 1px solid #d22c5d;
            padding: 2px 8px;
            /* Espaciado interno */
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s;
            font-size: 1rem;
            cursor: pointer;
        }

        .btn-icon:hover {
            background-color: #d22c5d;
            color: #f8eaef;
        }


        .acciones-container {
            display: flex;
            justify-content: space-evenly;
        }

        .btn-icon-container {
            padding: 12px;
            display: flex;
            justify-content: center;
            font-size: 0.4em;
        }

        .contenedor-cosechas {
            background-color: white;
            z-index: -1000;
            margin-bottom: 30px;
        }

        .btn-subtitle {
            display: none;
            margin-left: 5px;
        }

        .buton {
            text-decoration: none;

        }

        .btn-icon:hover .btn-subtitle {
            display: inline-block;
        }

        td:nth-child(8) {
            width: 300px;
            height: 100%;
        }

        .breadcrumbs-container {
            display: flex;
            margin-top: -1%;
            margin-left: 7%;
            padding: 10px;
            font-family: 'Poppins', sans-serif;
        }

        .breadcrumb {
            display: flex;
            padding: 0;
            margin: 0;
        }

        .breadcrumb-item {
            display: flex;
            align-items: center;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: "/";
            margin: 0 5px;
        }

        .breadcrumb-item a {
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
            color: #007bff;
        }

        .breadcrumb-item a:hover {
            text-decoration: underline;
        }

        .modal-body .form-group{
            margin-right: 2%;
            text-align: center;

        }

        .modal-body .form-group input[type="number"] {
            width: 100%;
            padding: 5px;
            text-align: center;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .modal-body .boton {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            background-color: #28a745;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .modal-body .boton:hover {
            background-color: #218838;
        }
    </style>
</head>

<?php
$conexion = new mysqli("localhost", "sonnak", "sonnak2024", "proyecto");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>

<script class="access" src="https://cdn.userway.org/widget.js" data-account="BD1vuC76ZG"></script>

<body>

    <?php
    require_once '../../controller/conexion.php';
    include_once '../../view/layout/navs/nav-admin-redirect.php';
    echo "<br><br><br><br>";

    if (isset($_GET['msj_exito'])) {
        $mensaje_exito = $_GET['msj_exito'];
    }

    if (isset($_GET['msj_cosecha'])) {
        $mensaje_exito = $_GET['msj_cosecha'];
    }

    ?>

    <!-- Modal -->
    <div class="modal fade" id="modalLotes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registro de Cosechas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form class="contenedor_modal" action="../../controller/controlers-admin/procesar_lotes.php" method="post">
                        <div class="form-group">
                            <label for="cantidad_extra">Fresas Extra: </label>
                            <input type="number" id="cantidad_extra" name="cantidad_extra" placeholder="Kg" required class="ms-2 mb-3 input-cantidad" min="1" max="999" oninput="this.value = this.value.slice(0, 3)">
                        </div>
                        <div class="form-group">
                            <label for="cantidad_primera">Fresas Primera:</label>
                            <input type="number" id="cantidad_primera" name="cantidad_primera" placeholder="Kg" required class="ms-2 mb-3 input-cantidad" min="1" max="999" oninput="this.value = this.value.slice(0, 3)">
                        </div>
                        <div class="form-group">
                            <label for="cantidad_segunda">Fresas Segunda:</label>
                            <input type="number" id="cantidad_segunda" name="cantidad_segunda" placeholder="Kg" required class="ms-2 mb-3 input-cantidad" min="1" max="999" oninput="this.value = this.value.slice(0, 3)">
                        </div>
                        <div class="form-group">
                            <label for="cantidad_riche">Fresas Riche:</label>
                            <input type="number" id="cantidad_riche" name="cantidad_riche" placeholder="Kg" required class="ms-2 mb-3 input-cantidad" min="1" max="999" oninput="this.value = this.value.slice(0, 3)">
                        </div>
                        <div class="form-group">
                            <input class="boton" type="submit" value="Enviar">
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>



    <div class="breadcrumbs-container">
        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../../inicio_admin.php">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Cosechas</li>
            </ol>
        </nav>
    </div>

    <div class="contenedor-cosechas">
        <div class="TITULO">REGISTRO DE COSECHAS</div>
        <?php

        $sqselect = "SELECT id, fecha, cantidad_extra, cantidad_primera, cantidad_segunda, cantidad_riche  FROM lotes";
        $result = $conexion->query($sqselect);

        if ($result->num_rows > 0) {
            echo "<br><br>";
            echo "<div class='table-responsive'>";
            echo "<table id='proveedores-table' class='usuarios-table table'>";
            echo "<thead>
        <tr>
            <th><i class='bi bi-person-badge-fill'></i> ID</th>
            <th><i class='bi bi-calendar-check'></i> Fecha de Recogida</th>
            <th><i class='bi bi-basket'></i> Cantidad Recogida Extra</th>
            <th><i class='bi bi-basket'></i> Cantidad Recogida Primera</th>
            <th><i class='bi bi-basket'></i> Cantidad Recogida Segunda</th>
            <th><i class='bi bi-basket'></i> Cantidad Recogida Riche</th>
            <th style='text-align: center;'><i class='bi bi-shield-lock'></i> Acciones</th>
        </tr>
        </thead>";
            echo "<tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["fecha"] . "</td>";
                echo "<td>" . $row["cantidad_extra"] . " Kg" . "</td>";
                echo "<td>" . $row["cantidad_primera"] .  " Kg" . "</td>";
                echo "<td>" . $row["cantidad_segunda"] .  " Kg" . "</td>";
                echo "<td>" . $row["cantidad_riche"] .   " Kg" . "</td>";
                echo "<td class='acciones-container'>";
                echo "<div class='btn-icon-container'><a href='Editar_Cosechas.php?id=" . $row["id"] . "' class='btn-icon' title='Editar'><i class='bi bi-pencil-square'></i><span class='btn-subtitle'>Editar</span></a></div>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>"; // Cierre de la clase table-responsive

        echo "<div class='text-center mt-4'>
                <button class='btn btn-success' data-bs-toggle='modal' data-bs-target='#modalLotes'>
                  <i class='bi bi-basket'></i> Añadir cosecha
                </button>
              </div>";
        } else {
            echo "No se encontraron resultados";
        }

    $conexion->close();
    ?>
</div>

    <?php
    echo "<br><br><br><br>";
    include_once '../../view/layout/footers/footer-admin.php';
    ?>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.11.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>

    <script>
        // Función para evitar que se ingresen números negativos manualmente
        function evitarNumerosNegativos(input) {
            // Obtener el valor actual del input y convertirlo a un número
            let valor = parseFloat(input.value);

            // Verificar si el valor es un número válido
            if (!isNaN(valor)) {
                // Si el valor es menor que 1 o no es un número, establecerlo como 1
                if (valor < 1) {
                    input.value = 1;
                }
                // Si el valor es mayor que 99, establecerlo como 99
                else if (valor > 99) {
                    input.value = 99;
                }
            } else {
                // Si el valor no es un número válido, establecerlo como 1
                input.value = 1;
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#proveedores-table').DataTable({
                dom: 'Blfrtip',
                buttons: [

                    {
                        extend: 'excelHtml5', // Cambiado a 'excelHtml5' para usar la extensión de Excel
                        text: '<i class="bi bi-file-excel"></i>', // Cambiado a icono de Excel
                        titleAttr: 'Excel', // Cambiado a 'Excel' para el atributo del título
                        className: 'btn-excel', // Clase personalizada para el botón de Excel
                    },


                    {
                        extend: 'pdfHtml5',
                        text: '<i class="bi bi-file-pdf"></i>',
                        titleAttr: 'PDF',
                        className: 'btn-pdf',
                        customize: function(doc) {

                            var logo = 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAMCAgICAgMCAgIDAwMDBAYEBAQEBAgGBgUGCQgKCgkICQkKDA8MCgsOCwkJDRENDg8QEBEQCgwSExIQEw8QEBD/2wBDAQMDAwQDBAgEBAgQCwkLEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBD/wAARCAQ4BDgDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD9U6KKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAqK6uIrO2lurhwkUKGR2PQKBkn8qlrI8X6PL4h8KazoMExhk1GwntUkBwUZ4yoP4E0LUT2Pzw+Kf/AAVi1rT/ABXeaZ8L/h/p1zpFlM8K3eqXTpJc7WKllRFO1SQcZ59q9K+AH/BTz4d/Ea+g8N/FLSV8F6tOwSK7M3m6fKx6DzMAxk9t4Ga/L34ieAfE/wAMfF2qeDfF2l3FjqenXDxTRSqQSNx2yA/xKwwQw45rmuPYg+vINfWQyjDVqacPvPBqZjWo1GpLQ/o9s7y1v7aO8s7iOeCZQ8ckbBldT0II4IqavxZ/ZV/bm+If7Pt9BoOuTXXiXwW7qr6bNLmWzXPLWzt0wP8AlmTtPbbX6/fDX4leDfi14PsfHHgXWodS0q/TckkZ5Rv4o3XqrqeCp5BrwMZgamDlae3c9bDYqniY3idRRSA0tcR0hRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAeSfHj9mH4U/tDaSbPx1ogGowxlLPV7TEd7a+yvj5lz1RsqfSvyO/aq/ZH8cfsw+IIBqVyur+HNUkK6dq0UPlqxHPlSrkhJMehw3OPSv3Mrj/ix8K/B/xl8C6n4A8baYl5p2pRFP8Abhk/hljP8LqeQRXo4HMamDlbePY4sVgoYiPmfz5fZnaH7RDh0H3sH7v1r3H9lL9qnxh+zX40TULKSW/8NahIq6zo5f5Z0HHmx5OEmUdD/Fja3Yjmvjd8H/FX7OPxU1PwN4mtTLDE/mWd0yYj1GyY/LKvbPZgOjemRXEa3oqwqmqaf81rN83+7X006lLFR9nU1jLZnzcZ1MDW8z+gX4f+PvC3xO8H6X488F6pHqOj6xALi2nT0PVWHVWU5VlPIIINdHX4+f8ABPn9rCb4LePIvhv4w1Tb4J8UXCxky9NN1Byqxzg/wxucJJ6Eo/ADE/sBHIJFyPTNfJ4zCTwdTklt0PqsNiI4iHNEfRRRXIbhRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAfNP7df7Ndr8fPhLc3mj2sf/CW+GEkv9JlxzKAv7y3bg5V149jgjkV+PPhm8wbjQ75GG7O2OVcPG44ZCDypHIIPQg1/Q2wDAqwyDX42/wDBQv4IJ8Gfjy/ibQrMwaH4xDatb7Fwkd0pAuIxgYGcq4Hu9exltX2sZYWfXVeTPGzfC+0h7SO6Pl/XtJfTbgKUDRyZZCRwR6Gv12/4JyftIP8AGL4V/wDCB+Jr8z+K/A8MNrNJKzNJe2DAi3uGY/ecBTG5zndHk/fFflzfW8Wt6asZwSyB429GrV/Zn+NV1+zz8atB+IbPJHYWc/2PXYVJ/e6dIwE4x324SUccmIDvXdO+YYZwn8cTzMrxTpVOWXU/e6iq+n31pqljbalp9wk9rdwpPDKhyskbKGVgfQgg1Yr5k+sCiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAK+U/8AgpJ8K0+IX7N+q6/a2wfUvBsi65bsFyxij4nQY5+aIuK+rKyPF2h2viTwvq3h+9jEkGoWc1tIpGch0I/rWtGo6VSM10IqQU4uLPwJ8MXHnab5eeYG2Z9R2NZ3irT1huE1ONRiQbX/AN4dM+xq5p+myeGvE2seE5GYtpV3PYMW6k28rQ5PudgNamoWiX1lLauM71+U+jDoa9qc/q2K5lsz4WqnRrH6d/8ABMf40t8RPgOPAGrXvm6v4AmXTVDn5305wXtG9wqZiz6wmvsLdX4r/wDBPr4tyfCX9pPRbK+uPK0rxcreHdQDNhVdzvtZD9JhsH/Xc1+0w7VwZlQ9hWfLs9T7LBVvb0VLqPooorzzrCiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAoopKAForx/wCOn7VXwd/Z9tAfHXiENqUq7oNLsx5t3L/wAdB7nFfK+s/8FLviZ4mZv+FT/s/3L2jE+VdatcEK49SEwR9K2VCbjzS0Xd6fmZVK1Ol8TsfoPuoPrX5vt+3r+1/a4nuPgn4ZliX5mSKabJHoOa29H/4KmatpM0MfxO+AesaZEWCyz2c28KO5CsMn86cKDq/w5RfpJX/MyWNoN25j9BN1Gc8Hoa8i+D37VXwR+OFun/CD+NLR74j95p10whukPpsbr+Ga9cytZThKlLlmrM6VKMtYs/DL9obSYNA/ap+JGl2yBY/7euJFX08yKKY/+PSE1zW2u0/awkx+2J8RVXkHWsf+SNtXG162Ofweh8Pj1avI47WlvNJ16HUtKmNvdoyXVrKP4LhGDRt+DqjfhX70fAz4jWnxc+EPhL4kWfC69pdvdOn9yQoN6n3Dbh+FfhV4ttWlsUuUHzW7Z/A4/wABX6Tf8EnviOdc+EfiH4b3Vxvm8Lau1xbKTyLW7/ejj0EpmUf7tXil9ZwcavWOh6+SV96bPuuik3CuC+I3x4+EfwltWufiB480nSSoz5Ms4Mx+kYy36V4sYuTtFXPobpHfUV8X+LP+Cq37PGhzTW3h/TvEGvvHkLJBbCKJz7M56fhXnFx/wV609v8Ajw+COospPBk1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fdUnsrjoPrXp1fH5nlWJymt7HExt2fR+h+58LcXZZxfg/rmWzul8UXpKL7SX5PVPo9GFcxrU3mXz/wCz8tdP061xlxJ5kzvn7zE1jg43lc9+vKysOs5mtrmK5XaWikWQBhkEqwYA+2RzX6RaB8W/gv8AtCfAi+sfGl7pul/Y7TytQtLiZUe0lRcLJHnGQSAVI9cV+a1H8LLjh+G969mlX9i3pdM+E4u4RpcURoz9o6VWlK8ZR3W1/wAtH0ZPex28NxNDaSGSFJGWNz/EoY4P4jFZOrH91GndpBV+szUstfWcI7turknpE+tS5YJM0l+6PpS0UVotC7HmvjiZZPERGeI441/9CNft1+x3pZ0f9lz4YWbJtJ8N2c5HvJGJP/Zq/DXxPI15r188PzbmKLj1C4/nX9BXw40NfDPw98MeHY12rpej2dmB6eXCi/0r9Lxa9lgaFHskf5/57ilj+IMdio7SqS/M6OiiivJOIKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAa3Svyg/4KxaBNY/HXw3r+39zrHhlIgf9u3uJN36TLX6wGvgH/grZ4Je+8D+B/iBDExOk6lPpc7DosdzGHXP/A4AP+Be9ehlUlDFRb66HNi4c9GSPkz4c3a3ngvSpFIPlw+S31Xj+ldJXnnwT1AXHhm4sSfmtLg/kw3f1r0Ovk84o+xx1WPnc/sLgPHLMOHcJWX8iX3aEN0uUB9DVWr8i7lK1RIwcelfMY6NpKR+n5TVvB0+wL1p1NWnVwtnr2CiiikMKKKKQBWZ4l1hdA0O71VgC0EeUU93PAH51p15/wDGm6ki8O20CEgTXQVvcBSa9PJsJHHZhSw8tm9fRas+W43zeeRcO4zMKWkoQfL5Sfup/JtM8cvLye+vJby6keWWZ97MfU17x+wn4b8H+Kf2oPB+l+No7eawBuLiKC4x5ct1GoMSkHg87jj2rwFhuBHrU+m6hqGlXtvqWnXk1rd2kqzQTwuU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KKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACkbpS0UAVryztdQtZrG+t47i3uEMcsUihldCMFSDwQRX5S/txfsLX3wlv7r4tfCDT57jwk8hnvNPt1LS6O5OSyAcmDPp9z6dP1ibpUNxbW95byWt1Ck0MylJI3UFXU8EEHqK3w+Inhp80TGtRVaNtn0fY/Cv4d/FKHUFh0fxE4juj8kNyWwsvoG9/fvXYeKpmjt4I4+CzbhXu37bH/BPV9DW/wDit8CdLkksdzXOpaBbrloe7S247r1JT8vSvijQfiBqVusWleIC8sNuSiO4Ikj7EHPPHoeRWGZ5NTx0HiMDv1j/AJH7Z4eeKjwVWnlnEUtNo1fyUv8AP7+56jp/iDy18u8yQO/cVqLrGmsu5bj8CDXIxzW91GtxbyLIjchlp1fB1cHFStJWZ/VNDFKcFUpu6ezOnk16xT7rMx9hWddeIJ5MrAoQHv3rJoqYYWEdSpVZMdJJJI26RiTTaKK3UbGb1CnwzS28izQyNHIhyrKcEH2NMopg1clmuLi6le4up5JpX+88jZY8ep61FRRQlYNgooZdjbWBBPrwf1opgFFFct4u8Uf2erabp8gNyw+dv+eY/wAa68FgquPrKjRWr/A8HiTiLA8L5fPMMfK0Y7LrJ9EvNlfxh4p8vfpOmvh8fvpB2B/hH9a+z/8Agnz+xSuvSWPx2+LWklrCFluPD+l3CcTsOVu5FP8ACDyinqfmPavN/wBgn9jyT46eIB8SviBYOPBWkXGEikBH9q3C87Ae8an7x7nj1r9d7OztrG2is7OBIYYUEccaLhUUDAAA6AV95NUcqo/UsNv9p93/AF9x/EXEPEOO4yzKWaY9+7tCPSMe3+b6kijbhewp1FFeaeatAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooo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rnU/jRYCzRSUtIAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigBrlgpK9e1chqc2qG4eO9Z1Xso+6R/I12B6VHJHHMuyWNXX0YZoA4ag9K6+XR9Om+9bKv8Au8VVk8NWb/6qaRPrzQBzGaM1uSeF5v8AllcIf94YqFvDOoL91oW/4Ef8KAMnNGa0H0HVF/5d93+6wqJtI1JetnIcenNAFTJozVj+ztQ/58Z/++DUTW9wn37eRfqpoAZ1pGVWUoygqeCD0NO8uT/nm/8A3yaPLk/55v8A98mri7AcB4q+AXwS8byNceKvhX4Z1Cdl2Gd9PjWbHJ/1igN3PfvXnFx+wH+yrcyGQfDy5t9zbtsOsXarn2HmcfhX0Ntb+43/AHzSbW/un8q2VepHZsh04y3R4t4d/Yw/Zf8ADMglsfhLpd24Od2pPJefpKzCvXtH0bRPDtmmneHdFsdLtYxtSGzt1hRR7BQKt7W/un8qXy5P+ebflSnXqT+J3GoRjshKKXa/9xvypRDM33YXP4VkUNoqVbO8b7trIf8AgNO/s+//AOfOX/vmgCCiriaPqUn3bVh9eKkXQNUPWED/AIFQBn0ZrWTw1ft95kX8anTwrJ/y0ugPoKQGFQCR0JFdPF4ZtF/1kjtV2LSdPhAAtUb/AHlzRcDG0CXU3m+Z3aBeu/oPpXS00KqgBVAA6e1OpNgFFFFIAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKAE2r/dFG1f7opaKAE2r/dFG1f7opaKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA/9k=';
                            doc.content.splice(0, 0, {
                                image: logo,
                                width: 100,
                                alignment: 'left',
                                margin: [null, 10, 10, null]
                            });

                            // Agregar los datos de la empresa
                            doc.content.splice(1, 0, {
                                text: 'FRESAS DON ARTURO',
                                style: 'header',
                                alignment: 'left',
                                margin: [10, null, null, 10]
                            });
                            doc.content.splice(2, 0, {
                                text: 'Cuitiva-Boyacá',
                                style: 'subheader',
                                alignment: 'left',
                                margin: [10, null, null, 10]
                            });
                            doc.content.splice(3, 0, {
                                text: 'Vereda llano de Alarcón',
                                style: 'normal',
                                alignment: 'left',
                                margin: [10, null, null, 10]
                            });

                            var styles = {
                                header: {
                                    fontSize: 18,
                                    bold: true,
                                    margin: [0, 0, 0, 10]
                                },
                                subheader: {
                                    fontSize: 14,
                                    bold: true,
                                    margin: [0, 10, 0, 5]
                                },
                                normal: {
                                    fontSize: 12,
                                    margin: [0, 5, 0, 10]
                                }
                            };

                            // Aplicar estilos a los textos
                            for (var key in styles) {
                                if (styles.hasOwnProperty(key)) {
                                    doc.styles[key] = styles[key];
                                }
                            }
                        },
                        exportOptions: {
                            columns: ':not(:last-child)'
                        },
                    },
                    {
                        extend: 'print',
                        text: '<i class="bi bi-printer"></i>',
                        titleAttr: 'Imprimir',
                        className: 'btn-print',
                    }
                ],
                "language": {
                    "buttons": {
                        "excel": "Excel",
                        "pdf": "PDF",
                        "print": "Imprimir",
                    }
                },
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Todos"]
                ],
                "pagingType": "simple",
                "lengthChange": false,
                "info": false,
                "paging": true,
                "searching": true,
                "ordering": true,
                "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "language": {
                    "paginate": {
                        "previous": "Anterior",
                        "next": "Siguiente"
                    },
                    "search": "Buscar:",
                    "zeroRecords": "No se encontraron registros coincidentes",
                    "emptyTable": "No hay datos disponibles en la tabla"
                }

            });
        });

        if (window.location.search.includes('msj_exito')) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Registro actualizado",
                showConfirmButton: false,
                timer: 1500
            });
        }
        if (window.location.search.includes('msj_cosecha')) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Datos de recolección insertados correctamente.",
                showConfirmButton: false,
                timer: 1500
            });
        }
    </script>

</body>

</html>