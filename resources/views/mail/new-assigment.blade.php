<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        @if (isset($data->name) && $data->name)
            <title>Nueva tarea de parte de {{ $data->username }} ({{ $data->name }})</title>
        @endif
        @if (!isset($data->name) || !$data->name)
            <title>Nueva tarea de parte de {{ $data->username }}</title>
        @endif
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
                        @if (isset($data->name) && $data->name)
                            <h2 style="text-align: center; color: #ED6744;margin: 20px 0;">Nueva tarea de parte de {{ $data->username }} ({{ $data->name }})</h2>
                        @endif
                        @if (!isset($data->name) || !$data->name)
                            <h2 style="text-align: center; color: #ED6744;margin: 20px 0;">Nueva tarea de parte de {{ $data->username }}</h2>
                        @endif
                        <div style="width: 100%; text-align: center; margin: 4rem 0;">
                            <a style="font-family: sans-serif;text-decoration:none;border-radius:5px;padding:11px 23px;color:white;background-color: #0D0D0D; margin: 4rem 0;" target="_blank" href="https://plannet.space/users/{{ $data->slug }}/profile#chat">Revisar</a>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </body>
</html>