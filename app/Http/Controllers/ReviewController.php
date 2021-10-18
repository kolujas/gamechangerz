<?php
    namespace App\Http\Controllers;

    use App\Models\Lesson;
    use App\Models\Review;
    use App\Models\User;
    use Auth;
    use Cviebrock\EloquentSluggable\Services\SlugService;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class ReviewController extends Controller {
        /**
         * * Create a new Review.
         * @param  \Illuminate\Http\Request  $request
         * @param int $id_lesson
         * @return \Illuminate\Http\Response
         */
        public function create (Request $request, int $id_lesson) {
            $input = (object) $request->all();

            $validator = Validator::make($request->all(), Review::$validation['create']['rules'], Review::$validation['create']['messages']['es']);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $lesson = Lesson::find($id_lesson);

            $from = User::find($lesson->id_user_from);
            $from->and(['games', 'abilities']);
            $to = User::find(($lesson->id_user_from === Auth::user()->id_user ? $lesson->id_user_to : $lesson->id_user_from));

            $abilities = collect();
            if (Auth::user()->id_role === 1) {
                foreach ($from->games as $game) {
                    foreach ($game->abilities as $ability) {
                        $value = 0;
                        foreach ($input->stars as $slug => $stars) {
                            if ($ability->slug === $slug) {
                                foreach ($stars as $star) {
                                    if ($value < intval($star)) {
                                        $value = intval($star);
                                    }
                                }
                            }
                        }
                        $abilities->push([
                            "id_ability" => $ability->id_ability,
                            "stars" => $value
                        ]);
                    }
                }
            }
            if (Auth::user()->id_role === 0) {
                foreach ($from->abilities as $ability) {
                    $value = 0;
                    foreach ($input->stars as $slug => $stars) {
                        if ($ability->slug === $slug) {
                            foreach ($stars as $star) {
                                if ($value < intval($star)) {
                                    $value = intval($star);
                                }
                            }
                        }
                    }
                    $abilities->push([
                        "id_ability" => $ability->id_ability,
                        "stars" => $value
                    ]);
                }
            }

            $stars = 0;
            $quantity = 0;
            foreach ($abilities as $ability) {
                $stars += $ability['stars'];
                $quantity++;
            }

            $input->abilities = $abilities->toJson();
            $input->id_user_from = Auth::user()->id_user;
            $input->id_user_to = $to->id_user;
            $input->id_lesson = $lesson->id_lesson;
            $input->stars = ($stars ? $stars / $quantity : 0);
            $input->slug = SlugService::createSlug(Review::class, 'slug', $input->title);

            $review = Review::create((array) $input);

            Lesson::finish($lesson->id_lesson);
            User::requilify($to->id_user);

            return redirect("/users/$to->slug/profile")->with('status', [
                'code' => 200,
                'message' => "Reseña creada exitosamente.",
            ]);
        }

        public function update (Request $request, string $id_review, string $id_user) {
            $input = (object) $request->all();

            $validator = Validator::make($request->all(), Review::$validation['create']['rules'], Review::$validation['create']['messages']['es']);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $review = Review::find($id_review);
            $review->and(["lesson"]);
            $review->lesson->and(['users']);

            $user = User::find($review->id_user_from);

            $abilities = collect();
            if ($user->id_role === 1) {
                foreach ($review->lesson->users->from->games as $game) {
                    foreach ($game->abilities as $ability) {
                        $value = 0;
                        foreach ($input->stars as $slug => $stars) {
                            if ($ability->slug === $slug) {
                                foreach ($stars as $star) {
                                    if ($value < intval($star)) {
                                        $value = intval($star);
                                    }
                                }
                            }
                        }
                        $abilities->push([
                            "id_ability" => $ability->id_ability,
                            "stars" => $value
                        ]);
                    }
                }
            }
            if ($user->id_role === 0) {
                foreach ($review->lesson->users->from->abilities as $ability) {
                    $value = 0;
                    foreach ($input->stars as $slug => $stars) {
                        if ($ability->slug === $slug) {
                            foreach ($stars as $star) {
                                if ($value < intval($star)) {
                                    $value = intval($star);
                                }
                            }
                        }
                    }
                    $abilities->push([
                        "id_ability" => $ability->id_ability,
                        "stars" => $value
                    ]);
                }
            }

            $stars = 0;
            $quantity = 0;
            foreach ($abilities as $ability) {
                $stars += $ability['stars'];
                $quantity++;
            }

            $input->abilities = $abilities->toJson();
            $input->stars = ($stars ? $stars / $quantity : 0);
            $input->slug = SlugService::createSlug(Review::class, 'slug', $input->title);
            
            unset($review->lesson);

            $review->update((array) $input);

            User::requilify($review->id_user_to);

            return redirect()->back()->with('status', [
                'code' => 200,
                'message' => "Reseña actualizada exitosamente.",
            ]);
        }
    }