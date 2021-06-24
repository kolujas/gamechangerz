<?php
    namespace App\Http\Controllers;

    use App\Models\Game;
    use App\Models\User;
    use Illuminate\Http\Request;

    class GameController extends Controller {
        public function user (Request $request, $slug) {
            $user = User::where('slug', '=', $slug)->with('reviews')->first();

            $input = (object) $request->all();

            $games = [];
            if (isset($input->games)) {
                foreach ($input->games as $game) {
                    if (Game::has($game)) {
                        $game = Game::find($game);
                        $game = (object) [
                            "id_game" => $game->id_game,
                            "abilities" => [],
                        ];
                        foreach ($user->reviews as $review) {
                            $review->and(['abilities']);
                            if ($user->id_role === 0) {
                                foreach ($review->abilities as $ability) {
                                    if ($ability->id_game === $game->id_game) {
                                        $game->abilities[] = (object) [
                                            "id_ability" => $ability->id_ability,
                                        ];
                                    }
                                }
                            }
                        }
                        $games[] = $game;
                    }
                }
            }

            $input->games = json_encode($games);

            $user->update((array) $input);
            
            return redirect("/users/$user->slug/profile")->with('status', [
                'code' => 200,
                'message' => 'Juegos actualizados correctamente.',
            ]);
        }
    }