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
                        $games->push($game);
                    }
                }
            }

            $games = Game::stringify($games->toArray());
            $games = Game::requilify($user->id_user, $games);

            $user->update([
                "games" => $games,
            ]);
            
            return redirect()->back()->with('status', [
                'code' => 200,
                'message' => 'Juegos actualizados correctamente.',
            ]);
        }
    }