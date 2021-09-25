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
                $table->unsignedInteger('id_method')->nullable();
                $table->string('id_coupon')->nullable();
                $table->tinyInteger('id_status')->nullable()->default(2);
                $table->json('days')->nullable()->default('[]');
                $table->integer('assignments')->nullable()->default(4);
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
