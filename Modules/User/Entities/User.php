<?php

namespace Modules\User\Entities;

use Laravel\Passport\HasApiTokens;
use Modules\Project\Entities\Project;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Project\Entities\ProjectMembership;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;


class User extends Authenticatable implements HasMedia
{
    use HasFactory, HasRoles, SoftDeletes, HasApiTokens, InteractsWithMedia;

    protected $fillable = [
        'username', 'ip', 'nullable', 'email', 'phone', 'email_verified_at',
        'remember_token', 'password', 'status', 'job', 'gender', 'is_superuser',
    ];

    protected static function newFactory()
    {
        return \Modules\User\Database\factories\UserFactory::new();
    }
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300)
            ->format(Manipulations::FORMAT_PNG);
    }
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
    // public function role()
    // {
    //     return $this->roles()->first();
    // }
    public function memberships()
    {
        return $this->hasMany(ProjectMembership::class);
    }

    /**
     * Calculate discount percent.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function role(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->roles()->first(),
        );
    }

    /**
     * Calculate discount percent.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function hasPassword(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => !!$this->password,
        );
    }

    public function isSuperUser()
    {
        return $this->is_superuser;
    }
}
