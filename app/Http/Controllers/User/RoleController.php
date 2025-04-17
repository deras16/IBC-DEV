<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\RoleRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        Gate::authorize('viewAny', Role::class);
        return Inertia::render('User/Role/Index',[
            'roles' => Role::select('id','name','created_at','updated_at')->when(\Illuminate\Support\Facades\Request::input('search') ?? false, function($query , $search){
                $query->where('name','LIKE',"%{$search}%")
                    ->orWhere('id','LIKE',"%{$search}%");
            })->paginate(10)
                ->through(fn ($role) => [
                    'id' => $role->id,
                    'name' => $role->name,
                    'created_at' => $role->created_at->diffForHumans(),
                    'updated_at' => $role->updated_at->diffForHumans(),
                ])
                ->withQueryString(),
            'filters' => request()->only(['search'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        Gate::authorize('create', Role::class);
        return Inertia::render('User/Role/CreateEdit',[
            'permissions' => Permission::select('id','name')->orderBy('id')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request):  RedirectResponse
    {
        Gate::authorize('create', Role::class);
        $permissions = Permission::whereIn('id', $request->validatedPermissionsIds())->get();
        $role = Role::create($request->validatedRole())->syncPermissions($permissions);

        return redirect()->route('roles.show',$role->id)->with([
            'type' => 'success',
            'message' => 'Role created successfully.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): Response
    {
        Gate::authorize('view', $role);
        return Inertia::render('User/Role/Show',[
            'role' => $role->load(['permissions:id,name']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role): Response
    {
        Gate::authorize('update', $role);
        return Inertia::render('User/Role/CreateEdit',[
            'role' => $role,
            'role_permissions' => $role->permissions->pluck('id')->toArray(),
            'permissions' => Permission::select('id','name')->orderBy('id')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role) : RedirectResponse
    {
        Gate::authorize('update', $role);
        $permissions = Permission::whereIn('id', $request->validatedPermissionsIds())->get();
        $role->update($request->validatedRole());
        $role->syncPermissions($permissions);

        return redirect()->route('roles.show',$role->id)->with([
            'type' => 'success',
            'message' => 'Role updated successfully.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Role $role)
    {
        Gate::authorize('delete', $role);
    }
}
