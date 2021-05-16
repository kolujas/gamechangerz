<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\File;
    use Storage;

    class Folder extends Model {
        static public function getFiles ($route, $storage = true) {
            if ($storage) {
                if (!count(Storage::disk('public')->allFiles($route))) {
                    return [];
                }
                return Storage::disk('public')->allFiles($route);
            } else {
                // 
            }
        }
    }