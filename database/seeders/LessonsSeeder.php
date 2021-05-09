<?php
    namespace Database\Seeders;

    use App\Models\Lesson;
    use Illuminate\Database\Seeder;

    class LessonsSeeder extends Seeder {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run () {
            if (count(Lesson::all())) {
                foreach(Lesson::all() as $lesson){
                    //
                }
            } else {
                Lesson::create( [
                    "id_user_from"=>4,
                    "id_user_to"=>3,
                    "days"=>"[{\"date\":\"2021-04-05\",\"hour\":{\"id_hour\":15}},{\"date\":\"2021-04-13\",\"hour\":{\"id_hour\":1}}]",
                ] );
            }
        }
    }