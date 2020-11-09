<?php

namespace Sfneal\Tracking\Builders;

use Domain\Users\Builders\Interfaces\WhereUserInterface;
use Domain\Users\Builders\Traits\WhereUser;
use Sfneal\Builders\QueryBuilder;
use Sfneal\Tracking\Builders\Traits\WhereModels;

class TrackActivityBuilder extends QueryBuilder implements WhereUserInterface
{
    use WhereModels,
        WhereUser;
}
