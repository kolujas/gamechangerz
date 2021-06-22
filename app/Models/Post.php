<?php
    namespace App\Models;

    use App\Models\User;
    use Illuminate\Database\Eloquent\Model;

    class Post extends Model {
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

        /** @var array Validation rules & messages. */
        static $validation = [
            'add' => [
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
        ]]]];

        /**
         * * Get the Post User.
         * @return array
         */
        public function user () {
            return $this->belongsTo(User::class, 'id_user', 'id_user');
        }
    }