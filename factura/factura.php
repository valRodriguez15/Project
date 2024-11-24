<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura de Pedido</title>
    <link rel="stylesheet" href="../css/factura.css">
    <style>
        .btn-custom {
            background-color: #dc3545; /* Color de fondo */
            color: white; /* Color del texto */
            border: none; /* Sin borde */
            padding: 10px 20px; /* Espaciado interno */
            font-size: 16px; /* Tamaño de fuente */
            border-radius: 5px; /* Bordes redondeados */
            cursor: pointer; /* Cambia el cursor al pasar sobre el botón */
            transition: background-color 0.3s ease; /* Transición suave para el cambio de color */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra */
            position: fixed; /* Fijar posición */
            z-index: 1000; /* Asegurar que esté por encima de otros elementos */
        }

        .btn-back {
            top: 20px; /* Espaciado desde arriba */
            left: 20px; /* Espaciado desde la izquierda */
        }

        .btn-pdf {
            top: 20px; /* Espaciado desde arriba */
            right: 20px; /* Espaciado desde la derecha */
            background-color: #28a745; /* Color de fondo */
        }

        .btn-custom:hover {
            background-color: #c82333; /* Color de fondo al pasar el cursor */
        }

        .btn-pdf:hover {
            background-color: #218838; /* Color de fondo al pasar el cursor */
        }

        .btn-custom:focus,
        .btn-pdf:focus {
            outline: none; /* Sin borde de enfoque */
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.5); /* Sombra al enfocar */
        }

        .progress-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: conic-gradient(green 0% 0%, lightgray 0% 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Botón de Atrás -->
    <button class="btn btn-custom btn-back" type="button" onclick="window.location.href='../pedidosAdmin/indexAdmin.php'">Atrás</button>

    <div class="factura-container">
        <h1>Factura final</h1>
        
        <!-- Encabezado -->
        <?php
        require_once "read.php";
        ?>
    </div>
</body>
</html>