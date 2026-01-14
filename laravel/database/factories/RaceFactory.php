<?php

namespace Database\Factories;

use App\Models\Race;
use Illuminate\Database\Eloquent\Factories\Factory;

class RaceFactory extends Factory
{
    protected $model = Race::class;

    public function definition()
    {
        return [
            'RAC_TIME_START' => '2026-01-20 10:00:00',
            'RAC_TIME_END' => '2026-01-20 12:00:00',
            'RAC_TYPE' => 'Trail',
            'RAC_DIFFICULTY' => 'Hard',
            'RAC_MIN_PARTICIPANTS' => 1,
            'RAC_MAX_PARTICIPANTS' => 100,
            'RAC_MIN_TEAMS' => 1,
            'RAC_MAX_TEAMS' => 20,
            'RAC_TEAM_MEMBERS' => 5,
            'RAC_AGE_MIN' => 18,
            'RAC_AGE_MIDDLE' => 30,
            'RAC_AGE_MAX' => 65,
        ];
    }
}