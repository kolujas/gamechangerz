<?php
    namespace App\Http\Controllers;

    use app\Models\Achievement;
    use app\Models\User;
    use Illuminate\Http\Request;

    class AchievementController extends Controller {
        /**
         * * Update the User Achievements
         * @param  \Illuminate\Http\Request  $request
         * @param string $slug
         * @return \Illuminate\Http\Response
         */
        public function update (Request $request, string $slug) {
            $user = User::bySlug($slug)->first();
            $user->and(["achievements"]);

            $input = (object) $request->all();

            $achievements = collect();
            foreach ($user->achievements as $achievement) {
                if (isset($input->title)) {
                    foreach ($input->title as $id_achievement => $title) {
                        if (intval($id_achievement) === intval($achievement->id_achievement)) {
                            continue 2;
                        }
                    }
                }
                if (isset($input->message)) {
                    foreach ($input->message as $id_achievement => $message) {
                        if (intval($id_achievement) === intval($achievement->id_achievement) && $message === "BORRAR") {
                            continue 2;
                        }
                    }
                }
                $achievements->push([
                    "id_achievement" => $achievement->id_achievement,
                    "title" => $achievement->title,
                    "description" => $achievement->description,
                    "icon" => "components.svg.TrofeoSVG",
                ]);
            }

            if (isset($input->title)) {
                foreach ($input->title as $id_achievement => $title) {
                    $achievement = false;
                    foreach ($user->achievements as $achievement) {
                        if (intval($id_achievement) === intval($achievement->id_achievement)) {
                            break;
                        }
                        $achievement = false;
                    }
                    foreach ($input->description as $description_id_achievement => $description) {
                        if (intval($id_achievement) === intval($description_id_achievement)) {
                            break;
                        }
                        $description = false;
                    }
                    if (!$achievement) {
                        if (!$title || !$description) {
                            continue;
                        }
                    }
                    $achievements->push([
                        "id_achievement" => $id_achievement,
                        "title" => ($title ? $title : $achievement->title),
                        "description" => ($description ? $description : $achievement->description),
                        "icon" => "components.svg.TrofeoSVG",
                    ]);
                }
            }

            $achievements = $achievements->toArray();
            
            usort($achievements, function ($a, $b) {
                return strcmp($a['id_achievement'], $b['id_achievement']);
            });

            $user->update([
                "achievements" => Achievement::stringify($achievements),
            ]);
            
            return redirect()->back()->with('status', [
                'code' => 200,
                'message' => 'Logros actualizados correctamente.',
            ]);
        }
    }