<?php

namespace Database\Factories;

use Database\Factories\Traits\ModelChanges;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use Sfneal\Tracking\Utils\ModelAdapter;

class TrackActivityFactory extends Factory
{
    use ModelChanges;

    /**
     * TrackActivityFactory constructor.
     *
     * @param null $count
     * @param Collection|null $states
     * @param Collection|null $has
     * @param Collection|null $for
     * @param Collection|null $afterMaking
     * @param Collection|null $afterCreating
     * @param null $connection
     */
    public function __construct($count = null,
                                ?Collection $states = null,
                                ?Collection $has = null,
                                ?Collection $for = null,
                                ?Collection $afterMaking = null,
                                ?Collection $afterCreating = null,
                                $connection = null)
    {
        $this->model = ModelAdapter::TrackActivity();
        parent::__construct($count, $states, $has, $for, $afterMaking, $afterCreating, $connection);
    }

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

            'model_table' => $this->faker->randomElement(['people', 'address']),
            'model_key' => $this->faker->randomNumber(3),
            'model_changes' => $this->faker->randomElements($this->modelChanges()),

            'request_token' => $this->faker->uuid,

            'created_at' => $this->faker->date('Y-m-d H:i:s'),
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
