<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Nueva tarea de parte de {{ $data->username }} ({{ $data->name }})</title>
    </head>
    <body>
        <img src={{ asset("img/logos/028-logotipo_original.png") }} style="
        width: 100%;
        height: 10rem;
        object-fit: contain;" alt="GameChangerZ logo">
        <table style="max-width: 600px; padding: 10px; margin:0 auto; border-collapse: collapse;">
            <tr>
                <td style="background-color: #ecf0f1">
                    <div style="color: #34495e; margin: 4% 10% 2%; text-align: justify;font-family: sans-serif">
                        <h2 style="text-align: center; color: #0F1626;margin: 20px 0;">Nueva tarea de parte de {{ $data->username }} ({{ $data->name }})</h2>
                        <div style="width: 100%; text-align: center">
                            <a style="font-family: sans-serif;text-decoration:none;border-radius:5px;padding:11px 23px;color:white;background-color: #0F1626;"target="_blank" href="http://127.0.0.1:8000/users/{{ $data->slug }}/profile#chat">Revisar</a>
                        </div>
                        <p style="color: #ffffff;font-size: 1.1rem;text-align:center;margin:30px 0 0;padding: 1rem;background-color: #0F1626;font-family: sans-serif;">© Copyright</p>
                    </div>
                </td>
            </tr>
        </table>
    </body>
</html>