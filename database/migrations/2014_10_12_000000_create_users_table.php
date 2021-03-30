<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateUsersTable extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up () {
            Schema::create('users', function (Blueprint $table) {
                $table->increments('id_user');
                $table->string('username')->unique();
                $table->string('email')->unique();
                $table->string('password');
                $table->string('slug');
                $table->json('achievements')->nullble()->default("[]");
                $table->date('date_of_birth');
                $table->text('description')->nullble();
                $table->json('games')->nullble()->default("[]");
                $table->string('folder')->nullble();
                $table->json('idioms')->nullble()->default('[{\"id_idiom\":1}]');
                $table->json('lessons')->nullble()->default("[]");
                $table->string('name')->nullble();
                $table->tinyInteger('id_role')->default(0);
                $table->tinyInteger('id_teampro')->nullble();
                $table->json('prices')->nullble()->default("[]");
                $table->boolean('teammate')->default(1);
                $table->string('video')->nullable();
                $table->rememberToken();
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down () {
            Schema::dropIfExists('users');
        }
    }
