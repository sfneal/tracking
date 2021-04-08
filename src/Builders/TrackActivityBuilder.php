<?php

namespace Sfneal\Tracking\Builders;

use Sfneal\Builders\QueryBuilder;
use Sfneal\Tracking\Builders\Traits\WhereModels;
use Sfneal\Users\Builders\Interfaces\WhereUserInterface;
use Sfneal\Users\Builders\Traits\WhereUser;

class TrackActivityBuilder extends QueryBuilder implements WhereUserInterface
{
    use WhereModels,
        WhereUser;
}
