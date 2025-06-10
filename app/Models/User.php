<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }
    public function getCreatedAtAttribute(): string
    {
        return Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }
    public function getUpdatedAtAttribute(): string
    {
        return Carbon::parse($this->attributes['updated_at'])->diffForHumans();
    }
    public function getDeletedAtAttribute(): ?string
    {
        return $this->attributes['deleted_at'] ? Carbon::parse($this->attributes['deleted_at'])->diffForHumans(): null;
    }

    public function scopeFilter($query, array $filters): void
    {
        $query->when($filters['search'] ?? false, function( $query, $search){
            $query->where(fn($query) =>
                $query->where('name','like','%'.$search.'%')
                ->orWhere('email','like','%'.$search.'%')
                    ->orWhereHas('roles',fn($query) => $query->where('roles.name','like','%'.$search.'%'))
            );
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }

    //view soft deleted models
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
    }
}
