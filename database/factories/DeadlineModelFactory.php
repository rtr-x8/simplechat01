<?php

namespace Database\Factories;

use Carbon\Carbon;
use CountDownChat\Domain\Deadline\DeadlineDescription;
use CountDownChat\Domain\Deadline\DeadlineId;
use CountDownChat\Domain\Deadline\DeadlineName;
use CountDownChat\Domain\Liner\LinerId;
use CountDownChat\Infrastructure\Deadline\Model\DeadlineModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeadlineModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DeadlineModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'deadline_id' => DeadlineId::new()->value(),
            'liner_id' => LinerId::new()->value(),
            'name' => DeadlineName::of($this->faker->streetName),
            'description' => DeadlineDescription::of($this->faker->text(100)),
            'is_active' => true,
            'is_complete' => false,
            'deadline_at' => Carbon::parse('2020/01/01 00:05:00'),
        ];
    }
}
