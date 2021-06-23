<?php
    namespace App\Models;

    use App\Models\User;
    use Cviebrock\EloquentSluggable\Sluggable;
    use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
    use Illuminate\Database\Eloquent\Model;

    class Post extends Model {
        use Sluggable, SluggableScopeHelpers;

        /** @var string Table name */
        protected $table = 'posts';
        
        /** @var string Table primary key name */
        protected $primaryKey = 'id_post';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'description', 'image', 'id_user', 'link', 'title', 'slug',
        ];
        
        /**
         * * The Sluggable configuration for the Model.
         * @return array
         */
        public function sluggable (): array {
            return [
                'slug' => [
                    'source'	=> 'name',
                    'onUpdate'	=> true,
                ]
            ];
        }

        /**
         * * Get the Post User.
         * @return array
         */
        public function user () {
            return $this->belongsTo(User::class, 'id_user', 'id_user');
        }

        /**
         * * Check if the Post has an action.
         * @param string $name
         * @return boolean
         */
        static public function hasAction (string $name) {
            switch (strtoupper($name)) {
                case 'UPDATE':
                case 'DELETE':
                    return true;
                default:
                    return false;
            }
        }

        /** @var array Validation rules & messages. */
        static $validation = [
            'create' => [
                'rules' => [
                    'title' => 'required|max:200',
                    'description' => 'required',
                    'image' => 'required|mimetypes:image/jpeg,image/png',
                    'link' => 'nullable|url',
                ], 'messages' => [
                    'es' => [
                        'title.required' => 'El título es obligatorio.',
                        'description.required' => 'La descripción es obligatoria.',
                        'image.required' => 'La imagen es obligatoria.',
                        'image.mimetypes' => 'La imagen debe ser formato jpg/jpeg o png.',
                        'link.url' => 'El link debe ser formatio URL (https://ejemplo.com)',
            ]]], 'update' => [
                'rules' => [
                    'title' => 'required|max:200',
                    'description' => 'required',
                    'image' => 'nullable|mimetypes:image/jpeg,image/png',
                    'link' => 'nullable|url',
                ], 'messages' => [
                    'es' => [
                        'title.required' => 'El título es obligatorio.',
                        'description.required' => 'La descripción es obligatoria.',
                        'image.mimetypes' => 'La imagen debe ser formato jpg/jpeg o png.',
                        'link.url' => 'El link debe ser formatio URL (https://ejemplo.com)',
            ]]], 'delete' => [
                'rules' => [
                    'message' => 'required|regex:/^BORRAR$/',
                ], 'messages' => [
                    'es' => [
                        'message.required' => 'El mensaje es obligatorio.',
                        'message.regex' => 'El mensaje debe decir BORRAR.',
        ]]]];
    }