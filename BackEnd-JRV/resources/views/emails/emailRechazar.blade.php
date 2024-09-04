<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificación de Rechazo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333333;
            line-height: 1.6;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #dddddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        h1 {
            color: #d9534f;
        }
        p {
            margin-bottom: 20px;
        }
        a {
            color: #337ab7;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .footer {
            margin-top: 40px;
            font-size: 0.9em;
            color: #777777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Notificación de Rechazo de Solicitud</h1>
        <p>Estimado/a <strong> {{$details}} </strong>,</p>
        <p>Lamentamos informarle que su solicitud enviada a través de nuestro sitio web ha sido RECHAZADO. Tras una revisión detallada, hemos determinado que su solicitud no cumple con los requisitos necesarios establecidos por nuestra junta directiva.</p>
        <p>Para obtener más información sobre los motivos específicos del rechazo, le sugerimos revisar su perfil en la sección correspondiente de la junta directiva en nuestro sitio web.</p>
        <p>Agradecemos su interés y le animamos a seguir participando en futuras oportunidades con nosotros.</p>
        <div class="footer">
            <p>Atentamente JUNTA DIRECTIVA,<br>
        </div>
    </div>
</body>
</html>
