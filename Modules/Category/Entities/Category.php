<?php

namespace Modules\Category\Entities;

use Illuminate\Support\Str;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Modules\Category\Database\factories\CategoryFactory;
use Laravel\Scout\Searchable;

class Category extends Model implements HasMedia

{
    use HasFactory, SoftDeletes, InteractsWithMedia, Searchable;

    protected $fillable = [
        'title',
        'slug',
        'link',
        'description',
        'parent_id',
        'status',
    ];

    /**
     * Get the name of the index associated with the model.
     */
    public function searchableAs(): string
    {
        return 'categories_index';
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        return [
            'id' => (int) $this->id,
            'title' => $this->title,

        ];
    }

    public static function last()
    {
        return static::all()->last();
    }
    protected static function newFactory()
    {
        return CategoryFactory::new();
    }
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->format(Manipulations::FORMAT_PNG);
    }
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('children');
    }
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    /**
     * Get sub parent
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */

    protected function mainParent(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->parent ?   $this->parent->main_parent : $this
        );
    }

    public static function booted()
    {
        static::saving(function ($category) {
            $category->slug = Str::slug($category->title, '-', null);
        });
    }
}
