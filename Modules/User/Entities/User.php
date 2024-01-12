<?php

namespace Modules\User\Entities;

use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Laravel\Passport\HasApiTokens;
use Modules\Project\Entities\Project;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Project\Entities\ProjectTimeEntry;
use Modules\Project\Entities\ProjectMembership;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes, HasApiTokens, InteractsWithMedia;

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
    public function times()
    {
        return $this->hasMany(ProjectTimeEntry::class, 'user_id', 'id');
    }

    protected function totalTimeHours(): Attribute
    {
        return Attribute::make(
            get: function () {
                $timeEntries = $this->times;
                $totalHours = 0;
                foreach ($timeEntries as $entry) {
                    list($hours, $minutes) = explode(':', $entry->hours);
                    $totalHours += $hours * 60 + $minutes;
                }
                $formattedTotalHours = sprintf("%02d:%02d", $totalHours / 60, $totalHours % 60);
                return $formattedTotalHours;
            }
        );
    }
}
