<?php
    namespace Database\Seeders;

    use App\Models\Review;
    use Illuminate\Database\Seeder;

    class ReviewsSeeder extends Seeder {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run () {
            if (count(Review::all())) {
                foreach(Review::all() as $review){
                    //
                }
            } else {
                Review::create( [
                    "title"=>"TREMENDO!!!",
                    "description"=>"Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quasi non maiores hic, nisi quo earum est, voluptatum voluptates provident suscipit delectus itaque ut corrupti debitis quos a aliquid impedit deleniti?",
                    "abilities"=>"[{\"id_ability\":1,\"stars\":3},{\"id_ability\":2,\"stars\":1},{\"id_ability\":3,\"stars\":5},{\"id_ability\":4,\"stars\":5}]",
                    "id_user_from"=>3,
                    "id_user_to"=>4,
                    "id_lesson"=>1,
                    "slug"=>"tremendo",
                ] );
                Review::create( [
                    "title"=>"Tiene que mejorar",
                    "description"=>"Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quasi non maiores hic, nisi quo earum est, voluptatum voluptates provident suscipit delectus itaque ut corrupti debitis quos a aliquid impedit deleniti?",
                    "abilities"=>"[{\"id_ability\":5,\"stars\":2},{\"id_ability\":6,\"stars\":3}]",
                    "id_user_from"=>4,
                    "id_user_to"=>3,
                    "id_lesson"=>1,
                    "slug"=>"tiene-que-mejorar",
                ] );
            }
        }
    }