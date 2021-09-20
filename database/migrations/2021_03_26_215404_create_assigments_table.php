<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateAssigmentsTable extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up () {
            Schema::create("assigments", function (Blueprint $table) {
                $table->increments("id_assigment");
                $table->unsignedInteger("id_lesson");
                $table->text("description")->nullable();
                $table->string("url")->nullable();
                $table->json("abilities")->nullable()->default("[]");
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down () {
            Schema::dropIfExists("assigments");
        }
    }
