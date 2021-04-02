<?php
    namespace Database\Seeders;

    use Illuminate\Database\Seeder;

    class DatabaseSeeder extends Seeder {
        /**
         * Seed the application's database.
         *
         * @return void
         */
        public function run () {
            $this->call(AssigmentsSeeder::class);
            $this->call(ChatsSeeder::class);
            $this->call(LessonsSeeder::class);
            $this->call(PostsSeeder::class);
            $this->call(ReviewsSeeder::class);
            $this->call(UsersSeeder::class);
        }
    }