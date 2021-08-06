<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Nueva solicitud de amistad de {{ $data->username }} ({{ $data->name }})</title>
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
                        <h2 style="text-align: center; color: #ED6744;margin: 20px 0;">Nueva solicitud de amistad de {{ $data->username }} ({{ $data->name }})</h2>
                        <div style="width: 100%; text-align: center; margin-bottom: 4rem 0;">
                            <a style="font-family: sans-serif;text-decoration:none;border-radius:5px;padding:11px 23px;color:white;background-color: #0D0D0D;"target="_blank" href="http://127.0.0.1:8000/users/{{ $data->slug }}/profile">Revisar perfíl</a>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </body>
</html>