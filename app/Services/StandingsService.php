<?php

namespace App\Services;

use App\Models\Fixture;
use App\Models\Standing;

class StandingsService
{
    public function recalculateLeagueStandings($leagueId)
    {
        $fixtures = Fixture::where('league_id', $leagueId)->where('status', 'completed')->with(['homeTeam', 'awayTeam'])->get();
        foreach ($fixtures as $fixture) {
            $this->updateTeamStandings($fixture);
        }
    }

    public function updateTeamStandings(Fixture $fixture)
    {
        $homeTeamId = $fixture->home_team_id;
        $awayTeamId = $fixture->away_team_id;
        $leagueId = $fixture->league_id;
        $homeGoals = $fixture->home_goals ?? 0;
        $awayGoals = $fixture->away_goals ?? 0;

        $homeStanding = Standing::firstOrCreate(
            ['league_id' => $leagueId, 'team_id' => $homeTeamId],
            ['position' => 0, 'played' => 0, 'won' => 0, 'drawn' => 0, 'lost' => 0, 'goals_for' => 0, 'goals_against' => 0, 'points' => 0]
        );

        $awayStanding = Standing::firstOrCreate(
            ['league_id' => $leagueId, 'team_id' => $awayTeamId],
            ['position' => 0, 'played' => 0, 'won' => 0, 'drawn' => 0, 'lost' => 0, 'goals_for' => 0, 'goals_against' => 0, 'points' => 0]
        );

        $homeStanding->increment('played');
        $awayStanding->increment('played');
        $homeStanding->update(['goals_for' => $homeStanding->goals_for + $homeGoals, 'goals_against' => $homeStanding->goals_against + $awayGoals]);
        $awayStanding->update(['goals_for' => $awayStanding->goals_for + $awayGoals, 'goals_against' => $awayStanding->goals_against + $homeGoals]);

        if ($homeGoals > $awayGoals) {
            $homeStanding->increment('won');
            $homeStanding->increment('points', 3);
            $awayStanding->increment('lost');
        } elseif ($awayGoals > $homeGoals) {
            $awayStanding->increment('won');
            $awayStanding->increment('points', 3);
            $homeStanding->increment('lost');
        } else {
            $homeStanding->increment('drawn');
            $homeStanding->increment('points');
            $awayStanding->increment('drawn');
            $awayStanding->increment('points');
        }

        $this->updateLeaguePositions($leagueId);
    }

    private function updateLeaguePositions($leagueId)
    {
        $standings = Standing::where('league_id', $leagueId)->orderByDesc('points')->orderByDesc('goal_difference')->orderByDesc('goals_for')->get();
        foreach ($standings as $key => $standing) {
            $standing->update(['position' => $key + 1]);
        }
    }
}
