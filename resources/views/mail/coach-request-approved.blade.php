<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Solicitud de profesor aprobada</title>
    </head>
    <body>
        <img src={{ asset("img/logos/028-logotipo_original.png") }} style="
        width: 100%;
        height: 10rem;
        object-fit: contain;" alt="Gamechangerz logo">
        <table style="max-width: 600px; padding: 10px; margin:0 auto; border-collapse: collapse;">
            <tr>
                <td style="background-color: #ecf0f1">
                    <div style="color: #34495e; margin: 4% 10% 2%; text-align: justify;font-family: sans-serif">
                        <h2 style="text-align: center; color: #0F1626;margin: 20px 0;">Solicitud de profesor aprobada</h2>
                        <p style="margin: 2px;padding-top: 2rem;text-align: center;font-family: sans-serif;font-size: 17px;min-height: 70px;background-color: #f8f8f8;padding: 1rem 1rem;margin-bottom: 2.5rem;">Para continuar haga click en el siguiente enlace.<br />Lo redirigira a MercadoPago para que acepte para ingresar a nuestro sistema de cobro.</p>
                        {{-- TODO: replace URL --}}
                        <div style="width: 100%; text-align: center">
                            <a style="font-family: sans-serif;text-decoration:none;border-radius:5px;padding:11px 23px;color:white;background-color: #0F1626;"target="_blank" href="{{ $data->link }}">MercadoPago</a>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </body>
</html>