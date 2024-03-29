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
                $table->json('achievements')->nullable();
                $table->json('credentials')->nullable();
                $table->date('date_of_birth')->nullable();
                $table->text('description')->nullable();
                $table->json('games')->nullable();
                $table->string('folder')->nullable();
                $table->json('languages')->nullable();
                $table->json('days')->nullable();
                $table->string('name')->nullable();
                $table->tinyInteger('id_role')->default(0);
                $table->json('teampro')->nullable();
                $table->json('prices')->nullable();
                $table->boolean('teammate')->nullable()->default(1);
                $table->string('video')->nullable();
                $table->tinyInteger('important')->nullable()->default(0);
                $table->float('stars')->nullable()->default(0);
                $table->tinyInteger('id_status')->nullable()->default(0);
                $table->integer('credits')->nullable()->default(0);
                $table->string('discord')->nullable();
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
