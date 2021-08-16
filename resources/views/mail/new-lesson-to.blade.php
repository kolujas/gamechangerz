<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Reservaste una nueva clase ({{ $data->lesson->type->name }}) de {{ $data->lesson->users->from->username }} ({{ $data->lesson->users->from->name }})</title>
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
                        <h2 style="text-align: center; color: #ED6744;margin: 20px 0;">Reservaste una nueva clase ({{ $data->lesson->type->name }}) de {{ $data->lesson->users->from->username }} ({{ $data->lesson->users->from->name }})</h2>
                        @switch($data->lesson->type->id_type)
                            @case(1)
                            @case(3)
                                <p style="margin: 2px;padding-top: 2rem;text-align: center;font-family: sans-serif;font-size: 17px;min-height: 70px;background-color: #f8f8f8;padding: 1rem 1rem;margin-bottom: 2.5rem;">Encuentra al usuario dentro de nuestro Discord con el nombre de <b>{{ $data->lesson->users->from->discord }}</b></p>
                                <ul style="margin: 2px;padding-top: 2rem;text-align: center;font-family: sans-serif;font-size: 17px;min-height: 70px;background-color: #f8f8f8;padding: 1rem 1rem;margin-bottom: 2.5rem;">
                                    @foreach ($data->lesson->days as $day)
                                        @foreach ($day->hours as $hour)
                                            <li><b>{{ $day->date }}:</b> entre <b>{{ $hour->from }}</b> - <b>{{ $hour->to }}</b></li>
                                        @endforeach
                                    @endforeach
                                </ul>
                                <div style="width: 100%; text-align: center; margin: 2rem 0;">
                                    <a style="font-family: sans-serif;text-decoration:none;border-radius:5px;padding:11px 23px;color:white;background-color: #0D0D0D;"target="_blank" href="{{ $data->link }}">Discord</a>
                                </div>
                                @break
                            @case(2)
                                <ul style="margin: 2px;padding-top: 2rem;text-align: center;font-family: sans-serif;font-size: 17px;min-height: 70px;background-color: #f8f8f8;padding: 1rem 1rem;margin-bottom: 2.5rem;">
                                    <li>Entre <b>{{ $data->lesson->started_at->format("Y-m-d") }}</b> y <b>{{ $data->lesson->ended_at->format("Y-m-d") }}</b></li>
                                </ul>
                                {{-- TODO: replace URL --}}
                                <div style="width: 100%; text-align: center; margin: 2rem 0;">
                                    <a style="font-family: sans-serif;text-decoration:none;border-radius:5px;padding:11px 23px;color:white;background-color: #0D0D0D;"target="_blank" href="http://127.0.0.1:8000/users/{{ $data->lesson->users->to->slug }}/profile#chat">Entrar al chat</a>
                                </div>
                                @break
                        @endswitch
                    </div>
                </td>
            </tr>
        </table>
    </body>
</html>