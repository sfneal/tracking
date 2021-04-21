<?php


namespace Sfneal\Tracking\Utils;


use Sfneal\Address\Models\Address;
use Sfneal\Queries\RandomModelAttributeQuery;
use Sfneal\Testing\Models\People;

class RandomTrackable
{
    /**
     * @var array Array of possible trackable types
     */
    private const MODELS = [People::class, Address::class];

    /**
     * The trackable's 'type'
     *
     * @var People|Address|string
     */
    public $type;

    /**
     * * The trackable's 'id'
     *
     * @var int
     */
    public $id;

    /**
     * RandomTrackable constructor.
     */
    public function __construct()
    {
        // Create People models if none exists
        if (! People::query()->count()) {
            self::createTrackables();
        }

        $this->type = self::MODELS[rand(0, count(self::MODELS) - 1)];
        $this->id = (new RandomModelAttributeQuery($this->type, $this->type::getPrimaryKeyName()))->execute();
    }


    /**
     * Create People models to attach to 'trackable' relationships
     *
     * @return void
     */
    private static function createTrackables(): void
    {
        People::factory()
            ->count(20)
            ->has(Address::factory())
            ->create();
    }
}
