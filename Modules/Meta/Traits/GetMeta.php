<?php


namespace Modules\Meta\Traits;

use Modules\Meta\Enums\MetaType;
use Modules\Meta\Helpers\MetaHelper as Meta;

trait GetMeta
{
    /**
     * get meta value by given key
     *
     * @param string $key
     * @param mixed $defaultValue
     * @param string $customType
     *
     * @return mixed
     */
    public function getMeta($key, $defaultValue = MetaType::NO_VALUE_FOR_PARAMETER, $customType = null)
    {
        if (!is_string($key)) {
            return $defaultValue;
        }
        $metaResult = Meta::returnValue($this->getloadedMeta(), $key, $customType);
        if (Meta::isNullValue($metaResult)) {
            if ($defaultValue !== MetaType::NO_VALUE_FOR_PARAMETER) {
                return $defaultValue;
            }

            return $metaResult;
        }

        return $metaResult;
    }

    /**
     * get all metas's value and format the value
     *
     * @return mixed
     */
    public function getMetas()
    {
        return $this->getLoadedMeta()->toBase()->mapWithKeys(function ($item) {
            return [$item->key => Meta::returnValue($this->getLoadedMeta(), $item->key)];
        });
    }
}
