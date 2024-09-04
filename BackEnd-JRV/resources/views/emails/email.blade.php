<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificación de Junta Directiva</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #ED555A;
            color: #ffffff;
            padding: 10px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            padding: 20px;
        }
        .content p {
            margin: 0 0 10px;
        }
        .footer {
            text-align: center;
            color: #777;
            margin-top: 20px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Notificacion de junta directiva</h1>
        </div>
        <div class="content">
            <p>Estimado miembro de la Junta Directiva FIA, {{$details}}. </p>
            <p>Esta semana se llevará a cabo una reunión para tratar la agenda semanal.</p>
            <p>Por favor, estén atentos a la confirmación del día y la hora exacta.</p>
            <p>¡Gracias por su atención!</p>
            
        </div>
        <div class="footer">
            <p>&copy; Estudiantes de la FIA para horas sociales</p>
        </div>
    </div>
</body>
</html>