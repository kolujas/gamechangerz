<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class UpdateLessonsTableAddPriceField extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up () {
            Schema::table("lessons", function (Blueprint $table) {
                $table->json("price")->nullable();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down () {
            // 
        }
    }