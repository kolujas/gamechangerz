<?php
    namespace App\Http\Controllers\Panel;

    use App\Http\Controllers\Controller;
    use App\Models\Platform;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\File;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use Intervention\Image\ImageManagerStatic as Image;
    use Storage;

    class PlatformController extends Controller {
        /**
         * * Call the correct function.
         * @param Request $request
         * @param string $section
         * @param string $action
         * @return [type]
         */
        static public function call (Request $request, string $section, string $action) {
            switch ($section) {
                case "banner":
                    return PlatformController::doUpdateBanners($request);
                case "info":
                    return PlatformController::doUpdateInfo($request);
                default:
                    dd("Call to an undefined section \"$section\"");
            }
        }

        /**
         * * Updates the Platform images.
         * @param Request $request
         * @return [type]
         */
        static public function doUpdateBanners (Request $request) {
            $input = (object) $request->all();

            $validator = Validator::make($request->all(), Platform::$validation["banner"]["rules"], Platform::$validation["banner"]["messages"]["es"]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if ($request->hasFile("banner")) {
                $filepath = "web/01-banner.png";
                Storage::delete("web/01-banner.png");
                
                $file = Image::make($request->file("banner"))
                        ->resize(1349, 395, function($constrait){
                            $constrait->aspectRatio();
                            $constrait->upsize();
                        });
    
                Storage::put($filepath, (string) $file->encode());
            }

            if ($request->hasFile("background")) {
                $filepath = "web/02-background." . $request->background->extension();
                Storage::delete("web/02-background.jpg");
                Storage::delete("web/02-background.jpeg");
                
                $file = Image::make($request->file("background"))
                        ->resize(1000, 500, function($constrait){
                            $constrait->aspectRatio();
                            $constrait->upsize();
                        });

                Storage::put($filepath, (string) $file->encode());
            }

            return redirect("/panel/platform/banner")->with("status", [
                "code" => 200,
                "message" => "Im??genes actualizadas exitosamente.",
            ]);
        }

        /**
         * * Updates the Platform info.
         * @param Request $request
         * @return [type]
         */
        static public function doUpdateInfo (Request $request) {
            $input = (object) $request->all();

            $validator = Validator::make($request->all(), Platform::$validation["info"]["rules"], Platform::$validation["info"]["messages"]["es"]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $platform = Platform::find(1);
            $platform->update([
                "info" => $input->info,
            ]);

            return redirect("/panel/platform/info")->with("status", [
                "code" => 200,
                "message" => "Informaci??n actualizada exitosamente.",
            ]);
        }
    }