<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Role extends Model {
        /**
         * * Table primary key name
         * @var string
         */
        protected $primaryKey = "id_role";

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            "id_role",
            "name",
            "slug",
        ];

        /**
         * * Check if a Role exists.
         * @param int $id_role
         * @return bool
         */
        static public function has (int $id_role) {
            foreach (Role::$options as $option) {
                if ($option["id_role"] === $id_role) {
                    return true;
                }
            }

            return false;
        }

        /**
         * * Returns a Role.
         * @param int $id_role
         * @return Role
         */
        static public function option (int $id_role) {
            foreach (Role::$options as $option) {
                if ($option["id_role"] === $id_role) {
                    return new Role($option);
                }
            }

            dd("Role \"$id_role\" not found");
        }

        /**
         * * Role options.
         * @var array
         */
        static $options = [
            [
                "id_role" => 0,
                "name" => "User",
                "slug" => "user",
            ], [
                "id_role" => 1,
                "name" => "Teacher",
                "slug" => "teacher",
            ], [
                "id_role" => 2,
                "name" => "Admin",
                "slug" => "admin",
            ],
        ];
    }