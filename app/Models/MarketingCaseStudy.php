<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class MarketingCaseStudy extends Model
{
    /** @use HasFactory<\Database\Factories\MarketingCaseStudyFactory> */
    use HasFactory;
    protected $guarded = ['id'];

    public function getCreatedAtAttribute(): string
    {
        return Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }
    public function getUpdatedAtAttribute(): string
    {
        return Carbon::parse($this->attributes['updated_at'])->diffForHumans();
    }
    public function scopeFilter($query, array $filters): void
    {
        $query->when($filters['search'] ?? false, function( $query, $search){
            $query->where(fn($query) =>
                $query->where('client_name','like','%'.$search.'%')
                ->orWhere('marketing_case_topic','like','%'.$search.'%')
                ->orWhere('date','like','%'.$search.'%')
                ->orWhere('views','like','%'.$search.'%')
                ->orWhere('impressions','like','%'.$search.'%')
                ->orWhere('followers','like','%'.$search.'%')
            );
        });
    }

    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }

    public function followerHistory(): MorphMany
    {
        return $this->morphMany(FollowerHistory::class, 'followable');
    }
}
