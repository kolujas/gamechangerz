<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateChatsTable extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up () {
            Schema::create('chats', function (Blueprint $table) {
                $table->increments('id_chat');
                $table->unsignedInteger('id_user_from');
                $table->unsignedInteger('id_user_to');
                $table->json('messages')->nullble()->default('[]');
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down () {
            Schema::dropIfExists('chats');
        }
    }
