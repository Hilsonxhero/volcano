<?php

namespace Modules\Project\Enums;

enum ProjectIssueStatus: string
{
    case ACTIVE  = 'active';
    case INACTIVE = 'inactive';
    case REEJCTED  = 'rejected';
    case LOCKED  = 'locked';
    case PENDING  = 'pending';
}
