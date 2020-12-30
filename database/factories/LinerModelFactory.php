<?php

namespace Database\Factories;

use CountDownChat\Domain\Liner\LinerSourceType;
use CountDownChat\Infrastructure\Liner\Model\LinerModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LinerModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LinerModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'liner_id' => Str::orderedUuid(),
            'source_type' => LinerSourceType::User,
            'provided_liner_id' => Str::random(12),
            'is_active' => true
        ];
    }
}
