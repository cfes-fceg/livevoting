<?php

use App\EngSoc;
use App\Question;
use App\User;
use App\Vote;
use Illuminate\Database\Seeder;

class VoterEngSocQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $engSocs = factory(EngSoc::class, 50)->create()->all();
        $newUsers = factory(User::class, 40)->create()->all();
        shuffle($newUsers);
        $extraUsers = array_slice($newUsers, 0, 10);
        $users = array_merge($newUsers, $extraUsers);
        shuffle($users);

        $count = 0;
        foreach ($users as $user) {
            $engSocs[$count]->voter()->associate($user);
            $engSocs[$count]->save();
            $count++;
        }

        factory(Question::class, 5)->create([
            'is_active' => false
        ])->each(function ($question) {
            $engSocs = EngSoc::has('voter')->get()->all();
            foreach ($engSocs as $engSoc) {
                $vote = new \App\Vote();
                $vote->vote = Vote::OPTIONS[array_rand(Vote::OPTIONS)];
                $vote->voter()->associate($engSoc->voter);
                $vote->engSoc()->associate($engSoc);
                $vote->question()->associate($question);
                $vote->save();
            }
        });
    }
}
