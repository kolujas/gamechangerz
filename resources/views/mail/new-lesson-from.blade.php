<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Se reservó una nueva clase ({{ $data->lesson->type->name }}) por {{ $data->lesson->users->to->username }}</title>
    </head>
    <body style="background-color: #0D0D0D;">
        <img src={{ asset("img/logos/028-logotipo_original.png") }} style="
        width: 100%;
        height: 10rem;
        object-fit: contain;" alt="Gamechangerz logo">
        <table style="max-width: 600px; padding: 10px; margin:0 auto; border-collapse: collapse;">
            <tr>
                <td style="background-color: #281B2D;">
                    <div style="color: #34495e; margin: 4% 10% 2%; text-align: justify;font-family: sans-serif; border-radius: 0.25rem;">
                        @switch($data->lesson->type->id_type)
                            @case(1)
                            @case(3)
                                <h2 style="text-align: center; color: #ED6744;margin: 20px 0;">Felicitaciones! Se reservó una nueva clase (1on1) por el alumno {{ $data->lesson->users->to->username }}</h2>
                                <p style="margin: 2px;padding-top: 2rem;text-align: center;font-family: sans-serif;font-size: 17px;min-height: 70px;background-color: #f8f8f8;padding: 1rem 1rem;margin-bottom: 2.5rem;">Recordá que deberás encontrarte con el usuario en el canal <i>SalaDeEspera</i> de nuestro canal de Discord a la hora de inicio de la clase. Vas a poder identificar a tu alumno con el nick de Discord  {{ $data->lesson->users->to->discord }}. Luego de eso podrás mover al alumno a cualquiera de los canales de <i>"Coaching Rooms"</i> para asegurarte de que nadie más pueda entrar e interrumpir la clase.</p>
                                <p style="margin: 2px;padding-top: 2rem;text-align: center;font-family: sans-serif;font-size: 17px;min-height: 70px;background-color: #f8f8f8;padding: 1rem 1rem;margin-bottom: 2.5rem;">Es importante remarcar que si deseás cambiar, suspender o posponer una clase, deberás hacerlo por lo menos con 24hs de anticipación escribiendo a <b>soporte@gamechangerz.gg</b>, de lo contrario se considerará como que te ausentaste de la misma y el dinero deberá ser reembolsado.</p>
                                <p style="margin: 2px;padding-top: 2rem;text-align: center;font-family: sans-serif;font-size: 17px;min-height: 70px;background-color: #f8f8f8;padding: 1rem 1rem;margin-bottom: 2.5rem;">Cualquier duda o inconveniente, podés ponerte en contacto con nosotros a través del canal <i>#soporte</i> de Discord o enviando una mail a <b>soporte@gamechangerz.gg</b></p>
                                @break
                            @case(2)
                                <h2 style="text-align: center; color: #ED6744;margin: 20px 0;">Felicitaciones! Se reservo un Seguimiento Online por el alumno {{ $data->lesson->users->to->username }}. </h2>
                                <p style="margin: 2px;padding-top: 2rem;text-align: center;font-family: sans-serif;font-size: 17px;min-height: 70px;background-color: #f8f8f8;padding: 1rem 1rem;margin-bottom: 2.5rem;">Recordá que el Seguimiento Online se hace únicamente a través de nuestra web y las respuestas a cada Assignment que te envíen tienen que enviarse dentro de las 48hs hábiles.</p>
                                <p style="margin: 2px;padding-top: 2rem;text-align: center;font-family: sans-serif;font-size: 17px;min-height: 70px;background-color: #f8f8f8;padding: 1rem 1rem;margin-bottom: 2.5rem;">Cualquier duda o inconveniente, podés ponerte en contacto con nosotros a través del canal  <i>#soporte</i> de Discord o enviando una mail a <b>soporte@gamechangerz.gg</b></p>
                                <p style="margin: 2px;padding-top: 2rem;text-align: center;font-family: sans-serif;font-size: 17px;min-height: 70px;background-color: #f8f8f8;padding: 1rem 1rem;margin-bottom: 2.5rem;">Preparate para <i>#CambiarElJuego</i>.</p>
                                <p style="margin: 2px;padding-top: 2rem;text-align: center;font-family: sans-serif;font-size: 17px;min-height: 70px;background-color: #f8f8f8;padding: 1rem 1rem;margin-bottom: 2.5rem;">Un saludo, el equipo de GCZ</b>.</p>
                                @break
                        @endswitch
                    </div>
                </td>
            </tr>
        </table>
    </body>
</html>