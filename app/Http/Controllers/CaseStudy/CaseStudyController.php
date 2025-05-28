<?php

namespace App\Http\Controllers\CaseStudy;

use App\Enums\SpaceTopic;
use App\Enums\SpaceType;
use App\Http\Controllers\Controller;
use App\Http\Requests\CaseStudy\CaseStudyRequest;
use App\Http\Requests\FileRequest;
use App\Http\Services\Twitter\TwitterService;
use App\Models\CaseStudy;
use App\Models\File;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class CaseStudyController extends Controller
{
    public function __construct(protected TwitterService $twitterService) {}
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('CaseStudy/Index', [
            'caseStudies' => CaseStudy::select('*')->filter(request(['search']))->latest('updated_at')->paginate(5)->withQueryString(),
            'filters' => \Illuminate\Support\Facades\Request::only(['search']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : Response
    {
        return  Inertia::render('CaseStudy/CreateEdit', [
            'spaceTopics' => SpaceTopic::cases(),
            'spaceTypes' => SpaceType::cases()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CaseStudyRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $caseStudy = CaseStudy::create($data);
        if (!empty($data['client_twitter_username'])) {
            try {
                $result = $this->twitterService->getUserDataByUsername($data['client_twitter_username']);

                $caseStudy->followerHistory()->create([
                    'follower_count' => $result->public_metrics->followers_count,
                    'loaded_at' => now(),
                ]);

            } catch (\Throwable $e) {
                logger()->error("Error getting Twitter followers for @{$data['client_twitter_username']}: {$e->getMessage()}");
            }
        }

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
            'caseStudy' => $caseStudy->load(['followerHistory']),
        ]);
    }

    public function loadTwitterData(CaseStudy $caseStudy): RedirectResponse
    {
        $today = Carbon::today();
        $alreadyLoaded = $caseStudy->followerHistory()
            ->whereDate('loaded_at', $today)
            ->exists();

        if ($alreadyLoaded) {
            return redirect()->back()->with([
                'type' => 'warning',
                'message' => 'Twitter data for today has already been loaded.',
            ]);
        }

        if (empty($caseStudy->client_twitter_username)) {
            return redirect()->back()->with([
                'type' => 'error',
                'message' => 'Twitter username is not set for this case study.',
            ]);
        }

        try {
            $result = $this->twitterService->getUserDataByUsername($caseStudy->client_twitter_username);

            $caseStudy->followerHistory()->create([
                'follower_count' => $result->public_metrics->followers_count,
                'loaded_at' => now(),
            ]);

            return redirect()->back()->with([
                'type' => 'success',
                'message' => 'Data loaded successfully.',
            ]);
        } catch (\Throwable $e) {
            logger()->error("Error getting Twitter followers for @{$caseStudy->client_twitter_username}: {$e->getMessage()}");
            return redirect()->back()->with([
                'type' => 'error',
                'message' => 'Error getting Twitter information. Please try again later.',
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CaseStudy $caseStudy) : Response
    {
        return Inertia::render('CaseStudy/CreateEdit', [
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
