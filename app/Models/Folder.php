<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\File;

    class Folder extends Model {
        use HasFactory;

        static public function getFiles ($route, $storage) {
            if ($storage) {
                return Storage::disk('public')->allFiles($route);
            } else {
                // 
            }
        }
    }