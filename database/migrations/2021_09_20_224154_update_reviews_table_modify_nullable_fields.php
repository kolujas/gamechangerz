<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class UpdateReviewsTableModifyNullableFields extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up () {
            Schema::table('reviews', function (Blueprint $table) {
                $table->text('description')->nullable()->change();
                $table->json('abilities')->nullable()->default('[]')->change();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down () {
            Schema::table('reviews', function (Blueprint $table) {
                //
            });
        }
    }