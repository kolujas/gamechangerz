<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Reservaste una nueva clase ({{ $data->lesson->type->name }}) de {{ $data->lesson->users->from->username }}</title>
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
                        @switch($data->lesson->type->id_type)
                            @case(1)
                            @case(3)
                            <h2 style="text-align: center; color: #ED6744;margin: 20px 0;">Felicitaciones! Se reservó una nueva clase (1on1) por con el coach -----</h2>
                                <p style="margin: 2px;padding-top: 2rem;text-align: center;font-family: sans-serif;font-size: 17px;min-height: 70px;background-color: #f8f8f8;padding: 1rem 1rem;margin-bottom: 2.5rem;">Recordá que deberás encontrarte con él en el canal <b>“Sala de espera para clases”</b> de nuestro canal de Discord a la hora de inicio de la clase. Vas a poder identificar a tu coach con el nick de Discord  ----. Luego de eso, él te redirigirá a uno de nuestros <b>"Coaching Rooms"</b> para asegurarte de que nadie más pueda entrar e interrumpir la clase. </p>
                                <p style="margin: 2px;padding-top: 2rem;text-align: center;font-family: sans-serif;font-size: 17px;min-height: 70px;background-color: #f8f8f8;padding: 1rem 1rem;margin-bottom: 2.5rem;">Es importante remarcar que si deseas cambiar, suspender o posponer una clase, deberás hacerlo por lo menos con 24hs de anticipación escribiendo a <p>soporte@gamechangerz.gg</p>, de lo contrario se considerará como que te ausentaste de la misma y ni el dinero ni la clase serán reembolsados.</p>
                                <p style="margin: 2px;padding-top: 2rem;text-align: center;font-family: sans-serif;font-size: 17px;min-height: 70px;background-color: #f8f8f8;padding: 1rem 1rem;margin-bottom: 2.5rem;">Cualquier duda o inconveniente, podés ponerte en contacto con nosotros a través del canal <b>#soporte de Discord</b> o enviando una mail a <b>soporte@gamechangerz.gg</b></p>
                                <p style="margin: 2px;padding-top: 2rem;text-align: center;font-family: sans-serif;font-size: 17px;min-height: 70px;background-color: #f8f8f8;padding: 1rem 1rem;margin-bottom: 2.5rem;">Mucha suerte y preparate para <b>#CambiarElJuego</b></p>                                
                                @break
                            @case(2)
                            <h2 style="text-align: center; color: #ED6744;margin: 20px 0;">Felicitaciones! Reservaste un Seguimiento Online con el coach ----</h2>
                                <p style="margin: 2px;padding-top: 2rem;text-align: center;font-family: sans-serif;font-size: 17px;min-height: 70px;background-color: #f8f8f8;padding: 1rem 1rem;margin-bottom: 2.5rem;">En el caso que sea tu primera vez con esta modalidad, podés encontrar en esta guía cómo sacarle el mayor provecho y usarlo correctamente: https://bit.ly/3lyJAyo</p>  
                                <p style="margin: 2px;padding-top: 2rem;text-align: center;font-family: sans-serif;font-size: 17px;min-height: 70px;background-color: #f8f8f8;padding: 1rem 1rem;margin-bottom: 2.5rem;">Recordá que el Seguimiento Online se hace únicamente a través de nuestra web y las respuestas de cada Assignment que envíes pueden demorar hasta 48hs hábiles.</p>  
                                <p style="margin: 2px;padding-top: 2rem;text-align: center;font-family: sans-serif;font-size: 17px;min-height: 70px;background-color: #f8f8f8;padding: 1rem 1rem;margin-bottom: 2.5rem;">Cualquier duda o inconveniente, podés ponerte en contacto con nosotros a través del canal <b>#soporte de Discord</b> o enviando una mail a <b>soporte@gamechangerz.gg</b></p>  
                                <p style="margin: 2px;padding-top: 2rem;text-align: center;font-family: sans-serif;font-size: 17px;min-height: 70px;background-color: #f8f8f8;padding: 1rem 1rem;margin-bottom: 2.5rem;">Mucha suerte y preparate para <b>#CambiarElJuego</b></p>
                                <p style="margin: 2px;padding-top: 2rem;text-align: center;font-family: sans-serif;font-size: 17px;min-height: 70px;background-color: #f8f8f8;padding: 1rem 1rem;margin-bottom: 2.5rem;">Un saludo, el equipo de GCZ</p>
                                @break
                        @endswitch
                    </div>
                </td>
            </tr>
        </table>
    </body>
</html>



