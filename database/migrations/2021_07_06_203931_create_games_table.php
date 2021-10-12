<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateGamesTable extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up () {
            Schema::create('games', function (Blueprint $table) {
                $table->increments('id_game');
                $table->string('name');
                $table->string('alias');
                $table->string('folder');
                $table->string('slug');
                $table->json('colors');
                $table->boolean('active')->default(1);
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down () {
            Schema::dropIfExists('games');
        }
    }