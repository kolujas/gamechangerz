<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreatePostsTable extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up () {
            Schema::create('posts', function (Blueprint $table) {
                $table->increments('id_post');
                $table->unsignedInteger('id_user');
                $table->string('title');
                $table->text('description')->nullable();
                $table->string('image');
                $table->string('link')->nullable();
                $table->string('slug');
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down () {
            Schema::dropIfExists('posts');
        }
    }
