<?php

namespace Sfneal\Tracking\Tests\Feature\Builders;

use Sfneal\Tracking\Models\TrackAction;

class TrackActionBuilderTest extends BuilderTestCase
{
    use WhereModelTests;

    /**
     * @var TrackAction
     */
    protected $modelClass = TrackAction::class;
}
