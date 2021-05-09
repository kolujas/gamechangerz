<?php
    namespace Database\Seeders;

    use App\Models\Assigment;
    use Illuminate\Database\Seeder;

    class AssigmentsSeeder extends Seeder {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run () {
            if (count(Assigment::all())) {
                foreach(Assigment::all() as $assigment){
                    //
                }
            } else {
                Assigment::create( [
                    "abilities"=>"[{\"id_ability\":4}]",
                    "description"=>"Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus, adipisci itaque praesentium tempore, alias minus nesciunt aliquam consequatur sed fugiat quo ad. Nostrum repudiandae dolorum expedita aut, minima ratione velit.",
                    "id_lesson"=>1,
                    "slug"=>"como-mejorar-tu-punteria",
                    "title"=>"Como mejorar tu puntería",
                    "url"=>"https://www.youtube.com/watch?v=GCGesFZFjX0",
                ] );
            }
        }
    }