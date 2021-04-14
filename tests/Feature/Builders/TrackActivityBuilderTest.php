<?php


namespace Sfneal\Tracking\Tests\Feature\Builders;


use Sfneal\Tracking\Models\TrackActivity;
use Sfneal\Tracking\Tests\Feature\Builders\Traits\WhereModelTests;
use Sfneal\Tracking\Tests\Feature\Builders\Traits\WhereUserTests;

class TrackActivityBuilderTest extends BuilderTestCase
{
    use WhereUserTests;
    use WhereModelTests;

    /**
     * @var TrackActivity
     */
    protected $modelClass = TrackActivity::class;
}
