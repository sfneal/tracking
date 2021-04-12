<?php

namespace Database\Factories;

use Database\Factories\Traits\ModelChanges;
use Illuminate\Database\Eloquent\Factories\Factory;
use Sfneal\Tracking\Models\TrackAction;

class TrackActionFactory extends Factory
{
    use ModelChanges;

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TrackAction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'action' => $this->faker->randomElement($this->randomAction()),
            'model_table' => 'people',
            'model_key' => $this->faker->randomNumber(3),
            'model_changes' => $this->faker->randomElements($this->modelChanges()),
        ];
    }

    /**
     * Retrieve an array of 'actions' to be used as random elements.
     *
     * @return array
     */
    protected function randomAction(): array
    {
        return collect(['created', 'updated', 'deleted'])->each(function (string $action) {
            return ucfirst($action).' the model.';
        })->toArray();
    }
}
