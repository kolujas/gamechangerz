<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class UpdateLessonsTableModifyNullableFields extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up () {
            Schema::table('lessons', function (Blueprint $table) {
                $table->json('days')->nullable()->change();
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