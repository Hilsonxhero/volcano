<?php

namespace Modules\Project\Enums;

enum ProjectMemberStatus: string
{
    case ACTIVE  = 'active';
    case INACTIVE = 'inactive';
    case REEJCTED  = 'rejected';
    case PENDING  = 'pending';
}
