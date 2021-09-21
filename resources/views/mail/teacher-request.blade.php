<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Nueva solicitud de profesor</title>
    </head>
    <body style="background-color: #0D0D0D;">
        <img src={{ asset("img/logos/028-logotipo_original.png") }} style="
        width: 100%;
        height: 10rem;
        object-fit: contain;" alt="GameChangerZ logo">
        <table style="max-width: 600px; padding: 10px; margin:0 auto; border-collapse: collapse;">
            <tr>
                <td style="background-color: #281B2D;">
                    <div style="color: #34495e; margin: 4% 10% 2%; text-align: justify;font-family: sans-serif">
                        <h2 style="text-align: center; color: #ED6744;margin: 20px 0;">Nueva solicitud de profesor</h2>
                        <ul style="margin: 2px;padding-top: 2rem;text-align: center;font-family: sans-serif;font-size: 17px;min-height: 70px;background-color: #f8f8f8;padding: 1rem 1rem;margin-bottom: 2.5rem;">
                            <li>Correo: {{ $data->email_from }}</li>
                            <li>Nombre: {{ $data->name }}</li>
                            <li>Detalles: {{ $data->details }}</li>
                        </ul>
                        <div style="width: 100%; text-align: center; margin: 2rem 0;"">
                            <a style="font-family: sans-serif;text-decoration:none;border-radius:5px;padding:11px 23px;color:white;background-color: #0D0D0D;"target="_blank" href="https://gamechangerz.gg/panel/teachers/create">Registrar</a>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </body>
</html>