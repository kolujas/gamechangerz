<?php
    namespace Database\Seeders;

    use App\Models\Post;
    use Illuminate\Database\Seeder;

    class PostsSeeder extends Seeder {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run () {
            if (count(Post::all())) {
                foreach(Post::all() as $post){
                    //
                }
            } else {
                Post::create( [
                    "title"=>"Piense en como soportar a tus compañeros",
                    "description"=>"<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was <b>popularised</b> in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><br/><h1>Ut enim ad minim veniam. Quis nostrud exercitation</h1><br/><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. <i>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</i>, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>",
                    "image"=>"posts/1/01.png",
                    "id_user"=>1,
                    "slug"=>"piensa-en-como-soportar-a-tus-companeros",
                ] );
                Post::create( [
                    "title"=>"Usa el steam verde, como corresponde",
                    "description"=>"<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was <b>popularised</b> in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><br/><h1>Ut enim ad minim veniam. Quis nostrud exercitation</h1><br/><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. <i>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</i>, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>",
                    "image"=>"posts/2/01.png",
                    "id_user"=>2,
                    "slug"=>"use-el-steam-verde-como-corresponde",
                ] );
                Post::create( [
                    "title"=>"Aprende a moverte",
                    "description"=>"<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was <b>popularised</b> in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><br/><h1>Ut enim ad minim veniam. Quis nostrud exercitation</h1><br/><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. <i>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</i>, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>",
                    "image"=>"posts/4/01.png",
                    "id_user"=>4,
                    "slug"=>"aprende-a-moverte",
                ] );
                Post::create( [
                    "title"=>"Lidiar con la presion",
                    "description"=>"<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was <b>popularised</b> in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><br/><h1>Ut enim ad minim veniam. Quis nostrud exercitation</h1><br/><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. <i>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</i>, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>",
                    "image"=>"posts/4/01.png",
                    "id_user"=>4,
                    "slug"=>"lidiar-con-la-presion",
                ] );
            }
        }
    }