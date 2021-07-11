<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\File;
    use Storage;

    class Folder extends Model {
        /**
         * * Get the files from a folder.
         * @param string $route
         * @param bool [$storage=true]
         * @return array
         */
        static public function getFiles (string $route, bool $storage = true) {
            if ($storage) {
                if (!count(Storage::disk('public')->allFiles($route))) {
                    return [];
                }
                
                return Storage::disk('public')->allFiles($route);
            } else {
                $files = collect();
                
                foreach (File::files("img/$route") as $file) {
                    $files->push($file->getPathname());
                }

                return $files;
            }
        }
    }