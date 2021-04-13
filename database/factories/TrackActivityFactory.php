<?php

namespace Database\Factories;

use Database\Factories\Traits\ModelChanges;
use Illuminate\Database\Eloquent\Factories\Factory;
use Sfneal\Tracking\Models\TrackActivity;

class TrackActivityFactory extends Factory
{
    use ModelChanges;

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TrackActivity::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomNumber(3),
            'route' => $this->route(),
            'description' => $this->faker->text(),

            'model_table' => 'people',
            'model_key' => $this->faker->randomNumber(3),
            'model_changes' => $this->faker->randomElements($this->modelChanges()),

            'request_token' => $this->faker->uuid,
        ];
    }

    /**
     * Retrieve an array of 'route' that can be used as random elements.
     *
     * @return string
     */
    protected function route(): string
    {
        $prefixes = ['projects', 'tasks', 'reports', 'client'];
        $actions = ['store', 'update',  'delete'];

        return $this->faker->randomElement($prefixes).'.'.$this->faker->randomElement($actions);
    }
}
