<?php


namespace Database\Factories\Traits;


trait ModelChanges
{
    /**
     * Retrieve an array of 'model_changes' that can be used as random elements.
     *
     * @return array
     */
    protected function modelChanges(): array
    {
        return [
            'uploaded' => $this->faker->randomElement([0, 1]),
            'correction_needed' => $this->faker->randomElement([0, 1]),
            'published' => $this->faker->randomElement([0, 1]),
        ];
    }
}
