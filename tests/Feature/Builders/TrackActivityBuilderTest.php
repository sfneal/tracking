<?php

namespace Sfneal\Tracking\Tests\Feature\Builders;

use Sfneal\Tracking\Models\TrackActivity;

class TrackActivityBuilderTest extends BuilderTestCase
{
    use WhereUserTests;
    use WhereModelTests;

    /**
     * @var TrackActivity
     */
    protected $modelClass = TrackActivity::class;
}
