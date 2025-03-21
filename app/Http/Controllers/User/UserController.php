<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use App\Models\User;
use App\Notifications\TempPasswordNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('User/Index', [
            'users' => User::select('*')
                ->filter(request(['search']))
                ->paginate(5)
                ->withQueryString(),
            'filters' => request()->only(['search']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('User/Forms/CreateEdit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request):  RedirectResponse
    {
        $user = User::create($request->validatedUserCreate());

        $user->notify(new TempPasswordNotification());

        return redirect()->route('users.index')->with([
            'type' => 'success',
            'message' => 'User created successfully.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): Response
    {
        return Inertia::render('User/Show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): Response
    {
        return Inertia::render('User/Forms/CreateEdit', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());

        return redirect()->route('users.index')->with([
            'type' => 'success',
            'message' => 'User updated successfully.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
