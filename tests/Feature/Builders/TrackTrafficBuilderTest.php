<?php


namespace Sfneal\Tracking\Tests\Feature\Builders;


use Sfneal\Tracking\Models\TrackTraffic;
use Sfneal\Tracking\Tests\Feature\Builders\Traits\WhereUserTests;

class TrackTrafficBuilderTest extends BuilderTestCase
{
    use WhereUserTests;

    /**
     * @var TrackTraffic
     */
    protected $modelClass = TrackTraffic::class;
}
