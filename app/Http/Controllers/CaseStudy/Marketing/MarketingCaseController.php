<?php

namespace App\Http\Controllers\CaseStudy\Marketing;

use App\Enums\MarketingTopic;
use App\Http\Controllers\Controller;
use App\Http\Requests\CaseStudy\MarketingCaseStudyRequest;
use App\Http\Requests\FileRequest;
use App\Models\File;
use App\Models\MarketingCaseStudy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;

class MarketingCaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        Gate::authorize('viewAny', MarketingCaseStudy::class);
        return Inertia::render('CaseStudy/Marketing/Index', [
            'marketingCaseStudies' => MarketingCaseStudy::select('id', 'client_name', 'views', 'marketing_case_topic', 'impressions', 'followers')
                ->filter(request(['search']))->paginate(8)->withQueryString(),
            'filters' => \Illuminate\Support\Facades\Request::only(['search']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : Response
    {
        Gate::authorize('create', MarketingCaseStudy::class);
        return  Inertia::render('CaseStudy/Marketing/CreateEdit', [
            'marketingTopics' => MarketingTopic::cases()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MarketingCaseStudyRequest $request): RedirectResponse
    {
        Gate::authorize('create', MarketingCaseStudy::class);
        MarketingCaseStudy::create($request->validated());
        return redirect()->route('marketing-case-studies.index')->with([
            'type' => 'success',
            'message' => 'Case study created successfully.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(MarketingCaseStudy $marketingCaseStudy): Response
    {
        Gate::authorize('view', $marketingCaseStudy);
        return Inertia::render('CaseStudy/Marketing/Show', [
            'marketingCaseStudy' => $marketingCaseStudy,
            'marketingFiles' => $marketingCaseStudy->files()
                ->select('id', 'original_name')
                ->when(\Illuminate\Support\Facades\Request::input('search') ?? false, function($query , $search) {
                $query->where(fn($query) =>
                    $query->where('original_name','like','%'.$search.'%')
                );
            })->paginate(8)->withQueryString(),
            'filters' => \Illuminate\Support\Facades\Request::only(['search']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MarketingCaseStudy $marketingCaseStudy) : Response
    {
        Gate::authorize('update', $marketingCaseStudy);
        return Inertia::render('CaseStudy/Marketing/CreateEdit', [
            'marketingCaseStudy' => $marketingCaseStudy,
            'marketingTopics' => MarketingTopic::cases()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MarketingCaseStudyRequest $request, MarketingCaseStudy $marketingCaseStudy): RedirectResponse
    {
        Gate::authorize('update', $marketingCaseStudy);
        $marketingCaseStudy->update($request->validated());
        return redirect()->route('marketing-case-studies.index')->with([
            'type' => 'success',
            'message' => 'Case study updated successfully.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MarketingCaseStudy $marketingCaseStudy)
    {
        Gate::authorize('delete', $marketingCaseStudy);
    }
    /**
     * Create a new file for the case study.
     */
    public function createFile(MarketingCaseStudy $marketingCaseStudy): Response
    {
        Gate::authorize('uploadFiles', $marketingCaseStudy);
        return Inertia::render('CaseStudy/Marketing/UploadFile', [
            'marketingCaseStudyId' => $marketingCaseStudy->id,
        ]);
    }

    /**
     * Store a new file for the case study.
     */
    public function storeFile(FileRequest $request, MarketingCaseStudy $marketingCaseStudy): RedirectResponse
    {
        Gate::authorize('uploadFiles', $marketingCaseStudy);
        $request->validated();
        $file = $request->file('file');
        $path = $file->store('marketing_case_studies', 'local');

        $marketingCaseStudy->files()->create([
            'name' => pathinfo($file->hashName(), PATHINFO_FILENAME),
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'path' => $path,
        ]);

        return redirect()->route('marketing-case-studies.show', $marketingCaseStudy)->with([
            'type' => 'success',
            'message' => 'File uploaded successfully.'
        ]);
    }

    /**
     * Download the specified file.
     */
    public function downloadFile(MarketingCaseStudy $marketingCaseStudy, File $file)
    {
        Gate::authorize('downloadFiles', $marketingCaseStudy);
        if (!Storage::disk('local')->exists($file->path)) {
            return redirect()->route('marketing-case-studies.show', $marketingCaseStudy)->with([
                'type' => 'error',
                'message' => 'File not found.'
            ]);
        }
        return Storage::disk('local')->download($file->path, $file->original_name);
    }

    /**
     * Remove the specified file from storage.
     */
    public function destroyFile(MarketingCaseStudy $marketingCaseStudy, File $file): RedirectResponse
    {
        Gate::authorize('deleteFiles', $marketingCaseStudy);
        Storage::disk('local')->delete($file->path);
        $file->delete();

        return redirect()->route('marketing-case-studies.show', $marketingCaseStudy)->with([
            'type' => 'success',
            'message' => 'File deleted successfully.'
        ]);
    }
}
