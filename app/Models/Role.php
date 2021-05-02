<?php
    namespace App\Models;

    use App\Models\Ability;
    use App\Models\Folder;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Role extends Model {
        use HasFactory;
        
        /** @var string Table primary key name */
        protected $primaryKey = 'id_role';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'id_role', 'name', 'slug',
        ];

        /** @var array Role options */
        static $options = [[
                'id_role' => 0,
                'name' => 'User',
                'slug' => 'user',
            ], [
                'id_role' => 1,
                'name' => 'Teacher',
                'slug' => 'teacher',
            ], [
                'id_role' => 2,
                'name' => 'Admin',
                'slug' => 'admin',
        ]];

        /**
         * * Check if a Role exists.
         * @param string $field 
         * @return boolean
         */
        static public function has ($field) {
            $found = false;
            foreach (Role::$options as $role) {
                $role = new Role($role);
                if ($role->id_role === $field) {
                    $found = true;
                }
            }
            return $found;
        }

        /**
         * * Returns a Role.
         * @param string $field
         * @return Role
         */
        static public function one ($field = '') {
            foreach (Role::$options as $role) {
                $role = new Role($role);
                if ($role->id_role === $field) {
                    return $role;
                }
            }
        }
    }