<?php

namespace App\Http\Controllers\CaseStudy;

use App\Enums\SpaceTopic;
use App\Enums\SpaceType;
use App\Http\Controllers\Controller;
use App\Http\Requests\CaseStudy\CaseStudyRequest;
use App\Models\CaseStudy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CaseStudyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('CaseStudy/Index', [
            'caseStudies' => CaseStudy::select('*')->filter(request(['search']))->paginate(5)->withQueryString(),
            'filters' => \Illuminate\Support\Facades\Request::only(['search']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : Response
    {
        return  Inertia::render('CaseStudy/Forms/CreateEdit', [
            'spaceTopics' => SpaceTopic::cases(),
            'spaceTypes' => SpaceType::cases()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CaseStudyRequest $request): RedirectResponse
    {
        CaseStudy::create($request->validated());
        return redirect()->route('case-studies.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(CaseStudy $caseStudy): Response
    {
        return Inertia::render('CaseStudy/Show', [
            'caseStudy' => $caseStudy,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CaseStudy $caseStudy) : Response
    {
        return Inertia::render('CaseStudy/Forms/CreateEdit', [
            'caseStudy' => $caseStudy,
            'spaceTopics' => SpaceTopic::cases(),
            'spaceTypes' => SpaceType::cases()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CaseStudyRequest $request, CaseStudy $caseStudy): RedirectResponse
    {
        $caseStudy->update($request->validated());
        return redirect()->route('case-studies.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CaseStudy $caseStudy)
    {
        //
    }
}
