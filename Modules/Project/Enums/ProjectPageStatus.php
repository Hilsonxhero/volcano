<?php

namespace Modules\Project\Enums;

enum ProjectPageStatus: string
{
    case ACTIVE  = 'active';
    case INACTIVE = 'inactive';
    case REEJCTED  = 'rejected';
    case PENDING  = 'pending';
    case DRAFT  = 'draft';
}
