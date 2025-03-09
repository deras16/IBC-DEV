<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseStudy extends Model
{
    /** @use HasFactory<\Database\Factories\CaseStudyFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters): void
    {
        $query->when($filters['search'] ?? false, function( $query, $search){
            $query->where(fn($query) =>
                $query->where('client_name','like','%'.$search.'%')
                    ->orWhere('space_topic','like','%'.$search.'%')
                    ->orWhere('space_type','like','%'.$search.'%')
                    ->orWhere('space_title','like','%'.$search.'%')
                    ->orWhere('date','like','%'.$search.'%')
                    ->orWhere('views','like','%'.$search.'%')
                    ->orWhere('impressions','like','%'.$search.'%')
                    ->orWhere('listeners','like','%'.$search.'%')
                    ->orWhere('followers','like','%'.$search.'%')
                );
        });
    }
}
