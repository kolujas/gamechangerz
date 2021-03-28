<?php
    namespace App\Models;

    use App\Models\Ability;
    use App\Models\Folder;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Role extends Model {
        use HasFactory;

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
         * @param int $id_role Role primary key. 
         * @return boolean
         */
        static public function has ($id_role) {
            $found = false;
            foreach (Role::options as $role) {
                if ($role->id_role === $id_role) {
                    $found = true;
                }
            }
            return $found;
        }

        /**
         * * Find a Role.
         * @param int $id_role Role primary key. 
         * @return object
         */
        static public function find ($id_role) {
            foreach (Role::$options as $role) {
                $role = (object) $role;
                if ($role->id_role === $id_role) {
                    $roleFound = $role;
                }
            }
            return $roleFound;
        }

        /**
         * * Parse a Role primary key.
         * @param int $id_role.
         * @return array
         */
        static public function parse ($id_role) {
            if (Role::has($id_role)) {
                $role = Role::find($id_role);
            }
            return $role;
        }
    }