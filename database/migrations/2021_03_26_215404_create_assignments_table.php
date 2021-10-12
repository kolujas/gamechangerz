<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateAssignmentsTable extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up () {
            Schema::create("assignments", function (Blueprint $table) {
                $table->increments("id_assignment");
                $table->unsignedInteger("id_lesson");
                $table->text("description")->nullable();
                $table->string("url")->nullable();
                $table->json("abilities")->nullable();
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down () {
            Schema::dropIfExists("assignments");
        }
    }
