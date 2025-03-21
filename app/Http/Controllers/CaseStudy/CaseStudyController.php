<?php

namespace App\Http\Controllers\CaseStudy;

use App\Enums\SpaceTopic;
use App\Enums\SpaceType;
use App\Http\Controllers\Controller;
use App\Http\Requests\CaseStudy\CaseStudyFileRequest;
use App\Http\Requests\CaseStudy\CaseStudyRequest;
use App\Http\Requests\FileRequest;
use App\Models\CaseStudy;
use App\Models\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
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
        return redirect()->route('case-studies.index')->with([
            'type' => 'success',
            'message' => 'Case study created successfully.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(CaseStudy $caseStudy): Response
    {
        return Inertia::render('CaseStudy/Show', [
            'caseStudy' => $caseStudy->load(['files:id,original_name,case_study_id']),
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
        return redirect()->route('case-studies.index')->with([
            'type' => 'success',
            'message' => 'Case study updated successfully.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CaseStudy $caseStudy)
    {
        //
    }

    /**
     * Create a new file for the case study.
     */
    public function createFile(CaseStudy $caseStudy): Response
    {
        return Inertia::render('CaseStudy/Forms/UploadFile', [
            'caseStudyId' => $caseStudy->id,
        ]);
    }

    /**
     * Store a new file for the case study.
     */
    public function storeFile(FileRequest $request, CaseStudy $caseStudy): RedirectResponse
    {
        $request->validated();
        $file = $request->file('file');
        $path = $file->store('case_studies', 'local');

        $caseStudy->files()->create([
            'name' => pathinfo($file->hashName(), PATHINFO_FILENAME),
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'path' => $path,
        ]);

        return redirect()->route('case-studies.show', $caseStudy)->with([
            'type' => 'success',
            'message' => 'File uploaded successfully.'
        ]);
    }

    /**
     * Download the specified file.
     */
    public function downloadFile(CaseStudy $caseStudy, File $file)
    {
        if (!Storage::disk('local')->exists($file->path)) {
            return redirect()->route('case-studies.show', $caseStudy)->with([
                'type' => 'error',
                'message' => 'File not found.'
            ]);
        }
        return Storage::disk('local')->download($file->path, $file->original_name);
    }

    /**
     * Remove the specified file from storage.
     */
    public function destroyFile(CaseStudy $caseStudy, File $file): RedirectResponse
    {
        Storage::disk('local')->delete($file->path);
        $file->delete();

        return redirect()->route('case-studies.show', $caseStudy)->with([
            'type' => 'success',
            'message' => 'File deleted successfully.'
        ]);
    }
}
