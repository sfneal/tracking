<?php

namespace Database\Factories;

use Database\Factories\Traits\ModelChanges;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use Sfneal\Tracking\Utils\ModelAdapter;
use Sfneal\Tracking\Utils\RandomTrackable;

class TrackActionFactory extends Factory
{
    use ModelChanges;

    /**
     * TrackActionFactory constructor.
     *
     * @param  null  $count
     * @param  Collection|null  $states
     * @param  Collection|null  $has
     * @param  Collection|null  $for
     * @param  Collection|null  $afterMaking
     * @param  Collection|null  $afterCreating
     * @param  null  $connection
     */
    public function __construct($count = null,
                                ?Collection $states = null,
                                ?Collection $has = null,
                                ?Collection $for = null,
                                ?Collection $afterMaking = null,
                                ?Collection $afterCreating = null,
                                $connection = null)
    {
        $this->model = ModelAdapter::TrackAction();
        parent::__construct($count, $states, $has, $for, $afterMaking, $afterCreating, $connection);
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $trackable = new RandomTrackable();

        return [
            'action' => $this->faker->randomElement($this->randomAction()),
            'model_changes' => $this->faker->randomElements($this->modelChanges()),

            'trackable_id' => $trackable->id,
            'trackable_type' => $trackable->type,

            'created_at' => $this->faker->date('Y-m-d H:i:s'),
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
