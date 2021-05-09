<?php
    namespace Database\Seeders;

    use App\Models\Friend;
    use Illuminate\Database\Seeder;

    class FriendsSeeder extends Seeder {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run () {
            if (count(Friend::all())) {
                foreach(Friend::all() as $friend){
                    //
                }
            } else {
                Friend::create( [
                    "id_user_from"=>3,
                    "id_user_to"=>5,
                    "accepted"=>1,
                ] );
                Friend::create( [
                    "id_user_from"=>3,
                    "id_user_to"=>7,
                    "accepted"=>0,
                ] );
            }
        }
    }