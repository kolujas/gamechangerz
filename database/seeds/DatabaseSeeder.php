<?php
    use Illuminate\Database\Seeder;

    class DatabaseSeeder extends Seeder {
        /**
         * Seed the application's database.
         *
         * @return void
         */
        public function run () {
            $this->call(GameSeeder::class);
            $this->call(AbilitySeeder::class);
            $this->call(AssigmentSeeder::class);
            $this->call(ChatSeeder::class);
            $this->call(LessonSeeder::class);
            $this->call(PostSeeder::class);
            $this->call(ReviewSeeder::class);
            $this->call(UserSeeder::class);
            $this->call(FriendSeeder::class);
        }
    }