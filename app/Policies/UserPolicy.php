<?php
    namespace App\Policies;

    use App\Models\Lesson;
    use App\Models\User;
    use Illuminate\Auth\Access\HandlesAuthorization;

    class UserPolicy {
        use HandlesAuthorization;

        /**
         * * Determine whether the User is member of the Lesson.
         * @param \App\Models\User $user
         * @param \App\Models\Lesson $lesson
         * @return mixed
         */
        public function memberOfLesson (User $user, Lesson $lesson) {
            return $lesson->id_user_from == $user->id_user || $lesson->id_user_to == $user->id_user;
        }

        /**
         * * Determine whether the User can view the Coach checkout.
         * @param \App\Models\User $user
         * @param \App\Models\User $coach
         * @param string $type
         * @return mixed
         */
        public function viewCheckout (User $user, User $coach, string $type) {
            foreach ($coach->prices as $price) {
                if ($price->slug == $type) {
                    break;
                }
                $price = false;
            }
            return $price && $price->price > 0;
        }
    }