<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateLessonsTable extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up () {
            Schema::create('lessons', function (Blueprint $table) {
                $table->increments('id_lesson');
                $table->unsignedInteger('id_user_from');
                $table->unsignedInteger('id_user_to');
                $table->unsignedInteger('id_type');
                $table->tinyInteger('status')->nullable()->default(2);
                $table->json('days')->nullble()->default('[]');
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down () {
            Schema::dropIfExists('lessons');
        }
    }
