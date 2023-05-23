<?php

namespace Modules\Project\Enums;

enum ProjectStatus: string
{
    case ACTIVE  = 'active';
    case INACTIVE = 'inactive';
    case REEJCTED  = 'rejected';
    case PENDING  = 'pending';
    case LOCK  = 'lock';
}
