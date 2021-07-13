<?php
    namespace App\Http\Controllers;

    use App\Models\Ability;
    use App\Models\Game;
    use App\Models\Review;
    use App\Models\User;
    use Illuminate\Http\Request;

    class GameController extends Controller {
        /**
         * * Update the User Games.
         * @param Request $request
         * @param string $slug
         * @return [type]
         */
        public function update (Request $request, string $slug) {
            $user = User::findBySlug($slug);
            $reviews = Review::allToUser($user->id_user);
            
            $input = (object) $request->all();

            $games = collect();
            if (isset($input->games)) {
                foreach ($input->games as $slug) {
                    $game = Game::findBySlug($slug);

                    if ($user->id_role === 1) {
                        dd("TODO: Determinar de donde vienen las habilidades profe");
                    }
                    if ($user->id_role === 0) {
                        $game->and(['abilities']);
                    }
                    if ($game) {
                        if ($user->id_role === 0) {
                            foreach ($game->abilities as $ability) {
                                $stars = 0;
                                $quantity = 0;

                                foreach ($reviews as $review) {
                                    $review->and(['abilities']);

                                    foreach ($review->abilities as $reviewAbility) {
                                        if ($reviewAbility->id_ability === $ability->id_ability) {
                                            $stars += $reviewAbility->stars;
                                            $quantity++;
                                        }
                                    }
                                }
                                
                                $ability->stars = ($stars ? $stars / $quantity : 0);
                            }

                            $stars = 0;
                            $quantity = 0;
                            foreach ($reviews as $review) {
                                if ($review->id_game === $game->id_game) {
                                    $stars += $review->stars;
                                    $quantity++;
                                }
                            }
    
                            $game->stars = ($stars ? $stars / $quantity : 0);
    
                            $games->push($game);
                        }
                    }
                }
            }

            $games = Game::stringify($games->toArray());

            $user->update([
                "games" => $games,
            ]);
            
            return redirect("/users/$user->slug/profile")->with('status', [
                'code' => 200,
                'message' => 'Juegos actualizados correctamente.',
            ]);
        }
    }