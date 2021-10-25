<?php
    namespace App\Models;

    use Cviebrock\EloquentSluggable\Services\SlugService;
    use Cviebrock\EloquentSluggable\Sluggable;
    use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
    use Illuminate\Database\Eloquent\Model;

    class Achievement extends Model {
        use Sluggable, SluggableScopeHelpers;

        /**
         * * Table primary key name.
         * @var string
         */
        protected $primaryKey = 'id_achievement';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'description', 'icon', 'id_achievement', 'slug', 'title',
        ];
        
        /**
         * * The Sluggable configuration for the Model.
         * @return array
         */
        public function sluggable (): array {
            return [
                'slug' => [
                    'source'	=> 'title',
                ]
            ];
        }

        /**
         * * Returns the Achievement options.
         * @param array [$achievements]
         * @param bool [$all=true]
         * @return Achievement[]
         */
        static public function options (array $achievements = [], bool $all = true) {
            $collection = collect();

            foreach (Achievement::$options as $option) {
                $option = new Achievement($option);
                $found = false;
                
                foreach ($achievements as $data) {
                    if ($option->id_achievement === $data['id_achievement']) {
                        $found = true;
                        break;
                    }
                }

                if ($all || $found) {
                    $collection->push($option);
                }
            }

            return $collection;
        }

        /**
         * * Parse an Achievements array.
         * @param string [$achievements]
         * @return Achievement[]
         */
        static public function parse (string $achievements = '') {
            $collection = collect();

            foreach (json_decode($achievements) as $data) {
                $achievement = new Achievement([
                    'id_achievement' => $data->id_achievement,
                    'title' => $data->title,
                    'description' => $data->description,
                    'icon' => 'components.svg.TrofeoSVG',
                ]);

                $collection->push($achievement);
            }

            return $collection;
        }

        /**
         * * Stringify an Achievements array.
         * @param array [$achievements]
         * @return string
         */
        static public function stringify (array $achievements = []) {
            $collection = collect();

            foreach ($achievements as $data) {
                $collection->push([
                    'id_achievement' => $data['id_achievement'],
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'slug' => preg_replace('/\W+/', '-', strtolower(trim($data['title']))),
                ]);
            }

            return $collection->toJson();
        }

        /**
         * * Achievement options.
         * @var array
         */
        static $options = [
            [
                'id_achievement' => 1,
                'title' => 'Something',
                'description' => 'Something',
                'icon' => 'something',
                'slug' => 'something',
            ], [
                'id_achievement' => 2,
                'title' => 'Something',
                'description' => 'Something',
                'icon' => 'something',
                'slug' => 'something',
            ],
        ];
    }