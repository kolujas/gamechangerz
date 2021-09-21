<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class UpdateAssigmentsTableModifyNullableFields extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up () {
            Schema::table('assigments', function (Blueprint $table) {
                $table->text("description")->nullable()->change();
                $table->string("url")->nullable()->change();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down () {
            Schema::table('assigments', function (Blueprint $table) {
                //
            });
        }
    }