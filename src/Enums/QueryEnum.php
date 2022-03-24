<?php

namespace EscolaLms\Tracker\Enums;

use EscolaLms\Core\Enums\BasicEnum;

class QueryEnum extends BasicEnum
{
    public const PER_PAGE = 15;
    public const DEFAULT_SORT = 'created_at';
    public const DEFAULT_SORT_DIRECTION = 'desc';
}
