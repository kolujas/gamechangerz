<?php
    namespace App\Http\Controllers;

    use App\Models\Ability;
    use App\Models\Game;
    use App\Models\User;
    use Illuminate\Http\Request;

    class GameController extends Controller {
        /**
         * * Update the User Games.
         * @param  \Illuminate\Http\Request  $request
         * @param string $slug
         * @return \Illuminate\Http\Response
         */
        public function update (Request $request, string $slug) {
            $user = User::bySlug($slug)->first();
            
            $input = (object) $request->all();

            if ($user->id_role === 0) {
                $games = collect();
                if (isset($input->games)) {
                    foreach ($input->games as $slug) {
                        $game = Game::bySlug($slug)->first();

                        $game->and(['abilities']);
                        $games->push($game);
                    }
                }
            }
            if ($user->id_role === 1) {
                $games = collect();
                foreach ($input->abilities as $ability => $on) {
                    $ability = Ability::bySlug($ability)->first();
                    if (count($games)) {
                        foreach ($games as $game) {
                            if ($game["id_game"] === $ability->id_game) {
                                $game["abilities"]->push([
                                    "id_ability" => $ability->id_ability,
                                ]);
                                continue 2;
                            }
                        }
                    }
                    $games->push([
                        "id_game" => $ability->id_game,
                        "abilities" => collect(),
                    ]);
                    $games[count($games) - 1]["abilities"]->push([
                        "id_ability" => $ability->id_ability,
                    ]);
                }
            }

            $games = Game::stringify($games->toArray());
            
            $user->update([
                "games" => $games,
            ]);
            User::requilify($user->id_user);
            
            return redirect()->back()->with('status', [
                'code' => 200,
                'message' => 'Juegos actualizados correctamente.',
            ]);
        }
    }