<?php


namespace Sfneal\Tracking\Tests\Feature\Builders;


use Sfneal\Tracking\Models\TrackAction;
use Sfneal\Tracking\Tests\Feature\Builders\Traits\WhereModelTests;

class TrackActionBuilderTest extends BuilderTestCase
{
    use WhereModelTests;

    /**
     * @var TrackAction
     */
    protected $modelClass = TrackAction::class;


}
