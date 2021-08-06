<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Nueva solicitud de profesor</title>
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
                        <h2 style="text-align: center; color: #0F1626;margin: 20px 0;">Nueva solicitud de profesor</h2>
                        <p style="margin: 2px;padding-top: 2rem;text-align: center;font-family: sans-serif;font-size: 17px;min-height: 70px;background-color: #f8f8f8;padding: 1rem 1rem;margin-bottom: 2.5rem;">Un nuevo usuario llamado <b>{{ $data->username }}</b> solicitó ser profesor. <b>{{ $data->email_from }}</b> <b>{{ $data->password }}</b></p>
                        <p style="margin: 2px;padding-top: 2rem;text-align: center;font-family: sans-serif;font-size: 17px;min-height: 70px;background-color: #f8f8f8;padding: 1rem 1rem;margin-bottom: 2.5rem;">{{ $data->details }}</p>
                        {{-- TODO: replace URL --}}
                        <div style="width: 100%; text-align: center">
                            <a style="font-family: sans-serif;text-decoration:none;border-radius:5px;padding:11px 23px;color:white;background-color: #0F1626;"target="_blank" href="http://127.0.0.1:8000/panel/teachers/create">Registrar</a>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </body>
</html>