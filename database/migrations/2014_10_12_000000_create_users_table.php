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
                $table->json('achievements')->nullable()->default("[]");
                $table->date('date_of_birth')->nullable();
                $table->text('description')->nullable();
                $table->json('games')->nullable()->default("[]");
                $table->string('folder')->nullable();
                $table->json('languages')->default('[{\"id_language\":1}]');
                $table->json('days')->nullable()->default("[]");
                $table->string('name')->nullable();
                $table->tinyInteger('id_role')->default(0);
                $table->tinyInteger('id_teampro')->nullable();
                $table->json('prices')->nullable()->default("[]");
                $table->boolean('teammate')->nullable()->default(1);
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
