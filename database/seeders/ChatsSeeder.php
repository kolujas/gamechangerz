<?php
    namespace Database\Seeders;

    use App\Models\Chat;
    use Illuminate\Database\Seeder;

    class ChatsSeeder extends Seeder {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run () {
            if (count(Chat::all())) {
                foreach(Chat::all() as $chat){
                    //
                }
            } else {
                Chat::create( [
                    "id_user_from"=>4,
                    "id_user_to"=>3,
                    "messages"=>"[{\"id_user\":4,\"says\":\"Hi there\"},{\"id_user\":3,\"says\":\"Hi!, How are you?\"},{\"id_user\":4,\"says\":\"Fine :D\"},{\"id_user\":4,\"id_assigment\":1}]",
                ] );
            }
        }
    }