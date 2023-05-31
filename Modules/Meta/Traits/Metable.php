<?php


namespace Modules\Meta\Traits;

trait Metable
{
    use MetableBase, GetMeta, SetMeta, DeleteMeta, MetaClauses;
}
