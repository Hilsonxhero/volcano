<?php

namespace Modules\Contact\Enums;

enum ContactMessageStatus: string
{
    case CLOSE = 'close';
    case PENDING = 'pending';
    case ANSWER = 'answer';
}
