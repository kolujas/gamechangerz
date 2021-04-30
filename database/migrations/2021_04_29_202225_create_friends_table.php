<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateFriendsTable extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up () {
            Schema::create('friends', function (Blueprint $table) {
                $table->increments('id_friend');
                $table->unsignedInteger('id_user_from');
                $table->unsignedInteger('id_user_to');
                $table->tinyInteger('accepted')->default(0);
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down () {
            Schema::dropIfExists('friends');
        }
    }