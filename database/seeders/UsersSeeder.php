<?php
    namespace Database\Seeders;

    use App\Models\User;
    use Illuminate\Database\Seeder;

    class UsersSeeder extends Seeder {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run () {
            if (count(User::all())) {
                foreach(User::all() as $user){
                    //
                }
            } else {
                User::create( [
                    "username"=>"Archimak",
                    "email"=>"juancarmentia@gmail.com",
                    // ! "$2y$10\$zuXgcoBu3XN7XtmY2yTtqOaDKpACfEf28LgGglUT6UHB7efuc4g7e" = 12345678
                    "password"=>"$2y$10\$zuXgcoBu3XN7XtmY2yTtqOaDKpACfEf28LgGglUT6UHB7efuc4g7e",
                    // ! Es lo mismo que el username, pero sin mayúsculas, los espacios son "-" y nada de caracteres especiales.
                    "slug"=>"archimak",
                    // ? Un array que tiene que estar en formato JSON (entre ""), es un valor opcional (sino querés que tenga pone "[]").
                    // ? Cada logro que quieras alegrar tiene como estructura:
                    // ?    "icon" = Ruta al SVG
                    // ?    "title" = Título del logro
                    // ?    "description" = Descripción del logro
                    "achievements"=>"[{\"icon\":\"components.svg.Premio2SVG\",\"title\":\"First admin created :D\",\"description\":\"Be the first User with Admin role\"}]",
                    "date_of_birth"=>"1997-08-12",
                    "description"=>"The best admin in the wooorl",
                    // ! Tiene que tener "users/" + el ID del Usuario
                    "folder"=>"users/1",
                    // ? Un array que tiene que estar en formato JSON (entre ""), ya que la web solo cuenta con el Counter Strike, el ID del juego tiene que ser el 1, pero las abilidades pueden variar, solo se establecieron 2, si quieren que haya más que nos pasen la info. 
                    // ? Lo que va dentro de "abilities" es:
                    // ?    "id_ability" = El ID de la abilidad (5 Precisión y 6 Punteria)
                    // ?    "stars" = Del 1-5
                    "games"=>"[{\"id_game\":1,\"abilities\":[{\"id_ability\":5,\"stars\":3.5},{\"id_ability\":6,\"stars\":4}]}]",
                    // ! El role que tiene (0 Usuario, 1 Profesor, 2 Admin)
                    "id_role"=>2,
                    // ! El teampro que tiene, aún falta definir que vamos hacer con esto
                    "id_teampro"=>1,
                    // ? Un array que tiene que estar en formato JSON (entre ""), existen 4 idiomas, si quieren que haya más que nos pasen la info. 
                    // ? Lo que va es:
                    // ?    "id_language" = El ID del idioma (1 Español, 2 Inglés, 3 Italiano y 4 Portugués)
                    "languages"=>"[{\"id_language\":1},{\"id_language\":2}]",
                    // ? Un array que tiene que estar en formato JSON (entre ""), los 7 días tienen su valor según su posición (pero empezando desde 0 "Domingo"). Las horas son un bardo, si querés te las paso por privado (Van desde ID 1 - 18).
                    // ? Lo que va es:
                    // ?    "id_day" = El ID del día
                    // ?    "hours" = Un array de horas donde cada uno tiene solo el ID
                    "days"=>"[{\"id_day\":1,\"hours\":[{\"id_hour\":1}]},{\"id_day\":2,\"hours\":[{\"id_hour\":1}]},{\"id_day\":3,\"hours\":[{\"id_hour\":1}]},{\"id_day\":4,\"hours\":[{\"id_hour\":1}]},{\"id_day\":5,\"hours\":[{\"id_hour\":1}]},{\"id_day\":6,\"hours\":[{\"id_hour\":1}]},{\"id_day\":7,\"hours\":[{\"id_hour\":1}]}]",
                    "name"=>"Juan Cruz Armentia",
                    // ? Un array que tiene que estar en formato JSON (entre ""), Son 2 precios, el primero es online, el segundo es offline y el tercero (pack) se calcula, no es necesario agregarlo.
                    // ? Lo que va es:
                    // ?    "id_lesson" = El tipo, 1 Online o 2 Offline (Si, ya sé, quizá lo cambie a id_type)
                    // ?    "price" = El valor
                    "prices"=>"[{\"id_lesson\":1,\"price\":700},{\"id_lesson\":2,\"price\":2500}]",
                    // ! Si busca compa o no, 0 es no y 1 es si
                    "teammate"=>1,
                    // ! Esto falta definir, dejalo en null
                    "video"=>null,
                ] );
                User::create( [
                    "username"=>"kolujAs",
                    "email"=>"fernando.deibe@gmail.com",
                    "password"=>"$2y$10\$zuXgcoBu3XN7XtmY2yTtqOaDKpACfEf28LgGglUT6UHB7efuc4g7e",
                    "slug"=>"kolujas",
                    "achievements"=>"[{\"icon\":\"components.svg.Premio2SVG\",\"title\":\"Jack Sparrow\",\"description\":\"Acquires everything like a hacker\"}]",
                    "date_of_birth"=>"1997-08-12",
                    "description"=>"El de los reflejos de yisus",
                    "folder"=>"users/2",
                    "games"=>"[{\"id_game\":1,\"abilities\":[{\"id_ability\":5,\"stars\":5},{\"id_ability\":6,\"stars\":5}]}]",
                    "id_role"=>2,
                    "id_teampro"=>1,
                    "languages"=>"[{\"id_language\":1},{\"id_language\":4}]",
                    "days"=>"[{\"id_day\":0,\"hours\":[{\"id_hour\":1},{\"id_hour\":2},{\"id_hour\":3},{\"id_hour\":4},{\"id_hour\":5},{\"id_hour\":6},{\"id_hour\":7},{\"id_hour\":8},{\"id_hour\":9},{\"id_hour\":10},{\"id_hour\":11},{\"id_hour\":12},{\"id_hour\":13},{\"id_hour\":14},{\"id_hour\":15},{\"id_hour\":16},{\"id_hour\":17},{\"id_hour\":18}]}]",
                    "name"=>"Federico Deibe",
                    "prices"=>"[{\"id_lesson\":1,\"price\":80000},{\"id_lesson\":2,\"price\":50000}]",
                    "teammate"=>0,
                    "video"=>"https://youtu.be/tvKKT_A461c",
                ] );
                User::create( [
                    "username"=>"Pepe",
                    "email"=>"nosoybatman@gmail.com",
                    "password"=>"$2y$10\$zuXgcoBu3XN7XtmY2yTtqOaDKpACfEf28LgGglUT6UHB7efuc4g7e",
                    "slug"=>"pepe",
                    "achievements"=>"[]",
                    "date_of_birth"=>"2015-03-01",
                    "description"=>"No soy batman...",
                    "folder"=>"users/3",
                    "games"=>"[{\"id_game\":1,\"abilities\":[{\"id_ability\":6,\"stars\":0.5}]}]",
                    "id_role"=>0,
                    "id_teampro"=>1,
                    "languages"=>"[{\"id_language\":1},{\"id_language\":2},{\"id_language\":3},{\"id_language\":4}]",
                    "days"=>"[]",
                    "name"=>"Pepe Díaz",
                    "prices"=>"[]",
                    "teammate"=>1,
                    "video"=>null,
                ] );
                User::create( [
                    "username"=>"Solo Manolo",
                    "email"=>"solomanolo@gmail.com",
                    "password"=>"$2y$10\$zuXgcoBu3XN7XtmY2yTtqOaDKpACfEf28LgGglUT6UHB7efuc4g7e",
                    "slug"=>"solo-manolo",
                    "achievements"=>"[{\"icon\":\"components.svg.Premio2SVG\",\"title\":\"Best barquito\",\"description\":\"Haber adquirido el barquito de belén\"}]",
                    "date_of_birth"=>"2015-03-01",
                    "description"=>":)",
                    "folder"=>"users/4",
                    "games"=>"[{\"id_game\":1,\"abilities\":[{\"id_ability\":5,\"stars\":1},{\"id_ability\":6,\"stars\":5}]}]",
                    "id_role"=>1,
                    "id_teampro"=>1,
                    "languages"=>"[{\"id_language\":1}]",
                    "days"=>"[{\"id_day\":1,\"hours\":[{\"id_hour\":1},{\"id_hour\":4},{\"id_hour\":5},{\"id_hour\":15}]},{\"id_day\":2,\"hours\":[{\"id_hour\":1}]},{\"id_day\":4,\"hours\":[{\"id_hour\":3},{\"id_hour\":17}]},{\"id_day\":6,\"hours\":[{\"id_hour\":1},{\"id_hour\":2},{\"id_hour\":3},{\"id_hour\":5},{\"id_hour\":6}]}]",
                    "name"=>"Manolo Lopez",
                    "prices"=>"[{\"id_lesson\":1,\"price\":600},{\"id_lesson\":2,\"price\":1500}]",
                    "teammate"=>0,
                    "video"=>null,
                ] );
                User::create( [
                    "username"=>"Image",
                    "email"=>"imaginate@gmail.com",
                    "password"=>"$2y$10\$zuXgcoBu3XN7XtmY2yTtqOaDKpACfEf28LgGglUT6UHB7efuc4g7e",
                    "slug"=>"image",
                    "achievements"=>"[{\"icon\":\"components.svg.Premio2SVG\",\"title\":\"Perdedor\",\"description\":\"Último lugar en el torneo local del ciber de acá a la vuelta\"},{\"icon\":\"components.svg.Premio2SVG\",\"title\":\"Path quién te conoce\",\"description\":\"Ser despedido de Path\"}]",
                    "date_of_birth"=>"2020-10-01",
                    "description"=>"No le digan a mi hermana que me cree una cuenta porque me la chafanea",
                    "folder"=>"users/5",
                    "games"=>"[{\"id_game\":1,\"abilities\":[{\"id_ability\":5,\"stars\":0.5}]}]",
                    "id_role"=>0,
                    "id_teampro"=>1,
                    "languages"=>"[{\"id_language\":1}]",
                    "days"=>"[]",
                    "name"=>"Hector Bargas de la fuente Vega Gonzales",
                    "prices"=>"[]",
                    "teammate"=>0,
                    "video"=>null,
                ] );
                User::create( [
                    "username"=>"Annton.io",
                    "email"=>"anntonio@gmail.com",
                    "password"=>"$2y$10\$zuXgcoBu3XN7XtmY2yTtqOaDKpACfEf28LgGglUT6UHB7efuc4g7e",
                    "slug"=>"annton.io",
                    "achievements"=>"[{\"icon\":\"components.svg.Premio2SVG\",\"title\":\"Maestro con el Sniper\",\"description\":\"Las kills que te hace este camper del orto\"}]",
                    "date_of_birth"=>"2020-04-01",
                    "description"=>"Soy alto kpo, así que ni te metas conmigo, GIL!",
                    "folder"=>"users/6",
                    "games"=>"[{\"id_game\":1,\"abilities\":[{\"id_ability\":5,\"stars\":5},{\"id_ability\":6,\"stars\":5}]}]",
                    "id_role"=>0,
                    "id_teampro"=>1,
                    "languages"=>"[{\"id_language\":1}]",
                    "days"=>"[]",
                    "name"=>"Antonio De la Mira",
                    "prices"=>"[]",
                    "teammate"=>0,
                    "video"=>null,
                ] );
                User::create( [
                    "username"=>"Schumacher19",
                    "email"=>"automovilesparatodos@gmail.com",
                    "password"=>"$2y$10\$zuXgcoBu3XN7XtmY2yTtqOaDKpACfEf28LgGglUT6UHB7efuc4g7e",
                    "slug"=>"schumacher19",
                    "achievements"=>"[]",
                    "date_of_birth"=>"2020-07-01",
                    "description"=>'',
                    "folder"=>"users/7",
                    "games"=>"[{\"id_game\":1,\"abilities\":[{\"id_ability\":5,\"stars\":0},{\"id_ability\":6,\"stars\":2.5}]}]",
                    "id_role"=>0,
                    "id_teampro"=>1,
                    "languages"=>"[{\"id_language\":1}]",
                    "days"=>"[]",
                    "name"=>"Fausto Carlson",
                    "prices"=>"[]",
                    "teammate"=>1,
                    "video"=>null,
                ] );
            }
        }
    }