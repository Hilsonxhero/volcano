<?php

namespace Modules\Meta\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Meta extends Model
{
    use HasFactory;

    protected $fillable = [
        'key', 'value', 'type', 'status', 'metaable_type', 'metaable_id',
    ];

    // protected static function newFactory()
    // {
    //     return \Modules\Meta\Database\factories\MetaFactory::new();
    // }


    /**
     * morphTo relation with other models
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function meta()
    {
        return $this->morphTo();
    }
}
