<?php

namespace Database\Factories;

use Database\Factories\Traits\ModelChanges;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use Sfneal\Tracking\Utils\ModelAdapter;

class TrackTrafficFactory extends Factory
{
    use ModelChanges;

    /**
     * TrackActivityFactory constructor.
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
        $this->model = ModelAdapter::TrackTraffic();
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
            'session_id' => session_id(),

            // Application
            'app_version' => $this->version(),
            'app_environment' => $this->environment(),

            // Request
            'request_host' => $this->environment().'.example.com',
            'request_uri' => $this->uri(),
            'request_method' => $this->faker->randomElement(['GET', 'POST', 'PUT', 'DELETE']),
            'request_payload' => ['page' => $this->faker->randomNumber(1)],
            'request_browser' => null,
            'request_ip' => '192.168.150.51',
            'request_referrer' => null,
            'request_token' => $this->faker->uuid,

            // Response
            'response_code' => $this->faker->randomElement([200, 201, 500, 504]),
            'response_time' => $this->faker->randomFloat(2, 0, 10),
            'response_content' => null,

            // Agent
            'agent_platform' => $this->faker->randomElement(['OS X', 'Windows', 'iOS', 'AndroidOS', 'Linux']),
            'agent_device' => $this->faker->randomElement(['Macintosh', 'WebKit']),
            'agent_browser' => $this->faker->randomElement(['Chrome', 'Mozilla', 'Safari']),

            // Timestamp
            'time_stamp' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }

    /**
     * Retrieve a random semantic version number.
     *
     * @return string
     */
    protected function version(): string
    {
        return $this->faker->randomDigit.'.'.$this->faker->randomDigit.'.'.$this->faker->randomDigit;
    }

    /**
     * Retrieve a random application environment name.
     *
     * @return string
     */
    protected function environment(): string
    {
        return $this->faker->randomElement(['production', 'development', 'staging']);
    }

    /**
     * Retrieve a random request uri.
     *
     * @return string
     */
    protected function uri(): string
    {
        return '/'.$this->faker->randomElement([
            'about',
            'services',
            'team',
            'portfolio',
            'faqs',
        ]);
    }
}
