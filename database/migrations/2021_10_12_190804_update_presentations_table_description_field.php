<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class UpdatePresentationsTableDescriptionField extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up () {
            Schema::table('presentations', function (Blueprint $table) {
                $table->text("description")->nullable()->change();
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