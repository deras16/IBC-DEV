<?php

namespace App\Policies;

use App\Models\CaseStudy;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CaseStudyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view case studies');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CaseStudy $caseStudy): bool
    {
        return $user->hasPermissionTo('view case studies');
    }

    public function loadTwitterData(User $user, CaseStudy $caseStudy): bool
    {
        if ($caseStudy->trashed()){
            return false;
        }
        return $user->hasPermissionTo('load twitter data for case studies');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create case studies');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CaseStudy $caseStudy): bool
    {
        if ($caseStudy->trashed()){
            return false;
        }
        return $user->hasPermissionTo('edit case studies');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CaseStudy $caseStudy): bool
    {
        if ($caseStudy->trashed()){
            return false;
        }
        return $user->hasPermissionTo('delete case studies');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CaseStudy $caseStudy): bool
    {
        if ($caseStudy->trashed()){
            return $user->hasPermissionTo('restore case studies');
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CaseStudy $caseStudy): bool
    {
        return false;
    }
}
