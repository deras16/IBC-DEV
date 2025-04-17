<?php

namespace App\Policies;

use App\Models\MarketingCaseStudy;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MarketingCaseStudyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view marketing case studies');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MarketingCaseStudy $marketingCaseStudy): bool
    {
        return $user->hasPermissionTo('view marketing case studies');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create marketing case studies');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MarketingCaseStudy $marketingCaseStudy): bool
    {
        return $user->hasPermissionTo('edit marketing case studies');
    }

    public function uploadFiles(User $user, MarketingCaseStudy $marketingCaseStudy): bool
    {
        return $user->hasPermissionTo('upload marketing case studies files');
    }

    public function downloadFiles(User $user, MarketingCaseStudy $marketingCaseStudy): bool
    {
        return $user->hasPermissionTo('download marketing case studies files');
    }

    public function deleteFiles(User $user, MarketingCaseStudy $marketingCaseStudy): bool
    {
        return $user->hasPermissionTo('delete marketing case studies files');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MarketingCaseStudy $marketingCaseStudy): bool
    {
        return $user->hasPermissionTo('delete marketing case studies');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MarketingCaseStudy $marketingCaseStudy): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MarketingCaseStudy $marketingCaseStudy): bool
    {
        return false;
    }
}
