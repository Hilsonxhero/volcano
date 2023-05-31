<?php

namespace Modules\Meta\Enums;

enum MetaType: string
{
    case NO_VALUE_FOR_PARAMETER  = 'NOVALUEFORPARAMETER';
    case META_TYPE_STRING  = 'string';
    case META_TYPE_COLLECTION = 'collection';
    case META_TYPE_JSON  = 'json';
    case META_TYPE_ARRAY  = 'array';
    case META_TYPE_BOOLEAN  = 'boolean';
    case META_TYPE_INTEGER  = 'integer';
    case META_TYPE_NULL  = 'null';
}
