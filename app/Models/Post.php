<?php
    namespace App\Models;

    use App\Models\User;
    use Carbon\Carbon;
    use Cviebrock\EloquentSluggable\Sluggable;
    use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
    use Illuminate\Database\Eloquent\Model;

    class Post extends Model {
        use Sluggable, SluggableScopeHelpers;

        /**
         * * Table name.
         * @var string
         */
        protected $table = 'posts';
        
        /**
         * * Table primary key name.
         * @var string
         */
        protected $primaryKey = 'id_post';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'description', 'id_user', 'image', 'link', 'slug', 'title',
        ];

        /**
         * * Set the Post info. 
         * @param array [$columns]
         */
        public function and (array $columns = []) {
            foreach ($columns as $column) {
                if (!is_array($column)) {
                    switch ($column) {
                        case 'date':
                            $this->date();
                            break;
                        case 'user':
                            $this->user();
                            break;
                    }
                    continue;
                }
                switch ($column[0]) {
                    default:
                        break;
                }
            }
        }

        /**
         * * Set the Post date for hummans.
         */
        public function date () {
            Carbon::setLocale('es');
            $months = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
            $month = $months[intval($this->updated_at->format('m')) - 1];
            $day = $this->updated_at->format('d') ;
            $year = $this->updated_at->format('Y') ;

            $this->date = (object) [
                'timeForHumans' => $this->updated_at->diffForHumans(),
                'dateForHumans' => "$month $day, $year",
            ];
        }
        
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
         * @return User
         */
        public function user () {
            $this->user = User::find($this->id_user);
        }

        /**
         * * Check if the Post has an action.
         * @param string $name
         * @return bool
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

        /**
         * * Scope a query to only include Posts where their User role = 2.
         * @static
         * @param  \Illuminate\Database\Eloquent\Builder  $query
         * @return \Illuminate\Database\Eloquent\Builder
         */
        static public function scopeByAdmin ($query) {
            return $query->join('users', 'posts.id_user', '=', 'users.id_user')
                ->where('id_role', '=', 2)
                ->select('posts.title', 'posts.description', 'posts.image', 'posts.slug', 'posts.id_user', 'posts.updated_at')
                ->orderBy('posts.updated_at', 'desc');
        }

        /**
         * * Scope a query to only include Posts where their id_user matches.
         * @static
         * @param  \Illuminate\Database\Eloquent\Builder  $query
         * @param  int $id_user
         * @return \Illuminate\Database\Eloquent\Builder
         */
        static public function scopeByUser ($query, int $id_user) {
            return $query->where('id_user', $id_user);
        }

        /**
         * * Scope a query to only include Posts where their slug matches.
         * @static
         * @param  \Illuminate\Database\Eloquent\Builder  $query
         * @param  string $slug
         * @return \Illuminate\Database\Eloquent\Builder
         */
        static public function scopeBySlug ($query, string $slug) {
            return $query->where('slug', $slug);
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
                    ],
                ],
            ], 'update' => [
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
                    ],
                ],
            ], 'delete' => [
                'rules' => [
                    'message' => 'required|regex:/^BORRAR$/',
                ], 'messages' => [
                    'es' => [
                        'message.required' => 'El mensaje es obligatorio.',
                        'message.regex' => 'El mensaje debe decir BORRAR.',
                    ],
                ],
            ],
        ];
    }