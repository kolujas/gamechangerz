<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        @if (isset($data->name) && $data->name)
            <title>Nuevo mensaje de {{ $data->username }} ({{ $data->name }})</title>
        @endif
        @if (!isset($data->name) || !$data->name)
            <title>Nuevo mensaje de {{ $data->username }}</title>
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
                    <div style="color: #34495e; margin: 4% 10% 2%; text-align: justify;font-family: sans-serif; border-radius: 0.25rem;">
                        @if (isset($data->name) && $data->name)
                            <h2 style="text-align: center; color: #ED6744;margin: 20px 0;">Nuevo mensaje de {{ $data->username }} ({{ $data->name }})</h2>
                        @endif
                        @if (!isset($data->name) || !$data->name)
                            <h2 style="text-align: center; color: #ED6744;margin: 20px 0;">Nuevo mensaje de {{ $data->username }}</h2>
                        @endif
                        <p style="margin: 2px;padding-top: 2rem;text-align: center;font-family: sans-serif;font-size: 17px;min-height: 70px;background-color: #f8f8f8;padding: 1rem 1rem;margin-bottom: 2.5rem;">{{ $data->message }}</p>
                        {{-- TODO: replace URL --}}
                        <div style="width: 100%; text-align: center; margin: 2rem 0;">
                            <a style="font-family: sans-serif;text-decoration:none;border-radius:5px;padding:11px 23px;color:white;background-color: #0D0D0D;"target="_blank" href="https://plannet.space/users/{{ $data->slug }}/profile#chat">Responder</a>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </body>
</html>