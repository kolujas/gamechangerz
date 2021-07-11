<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateReviewsTable extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up () {
            Schema::create('reviews', function (Blueprint $table) {
                $table->increments('id_review');
                $table->unsignedInteger('id_user_from');
                $table->unsignedInteger('id_user_to');
                $table->unsignedInteger('id_lesson');
                $table->unsignedInteger('id_game');
                $table->string('title');
                $table->text('description')->nullble();
                $table->json('abilities')->nullble()->default('[]');
                $table->string('slug');
                $table->float('stars')->nullable()->default(0);
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down () {
            Schema::dropIfExists('reviews');
        }
    }
