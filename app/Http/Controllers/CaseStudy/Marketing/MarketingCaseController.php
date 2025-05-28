<?php

namespace App\Http\Controllers\CaseStudy\Marketing;

use App\Enums\MarketingTopic;
use App\Http\Controllers\Controller;
use App\Http\Requests\CaseStudy\MarketingCaseStudyRequest;
use App\Http\Requests\FileRequest;
use App\Http\Services\Twitter\TwitterService;
use App\Models\CaseStudy;
use App\Models\File;
use App\Models\MarketingCaseStudy;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class MarketingCaseController extends Controller
{
    public function __construct(protected TwitterService $twitterService) {}
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        Gate::authorize('viewAny', MarketingCaseStudy::class);
        return Inertia::render('CaseStudy/Marketing/Index', [
            'marketingCaseStudies' => MarketingCaseStudy::select('id', 'client_name', 'client_twitter_username')
                ->filter(request(['search']))->latest('updated_at')->paginate(8)->withQueryString(),
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
        $data = $request->validated();
        $marketingCaseStudy = MarketingCaseStudy::create($data);
        if (!empty($data['client_twitter_username'])) {
            try {
                $result = $this->twitterService->getUserDataByUsername($data['client_twitter_username']);

                $marketingCaseStudy->followerHistory()->create([
                    'follower_count' => $result->public_metrics->followers_count,
                    'loaded_at' => now(),
                ]);

            } catch (\Throwable $e) {
                logger()->error("Error getting Twitter followers for @{$data['client_twitter_username']}: {$e->getMessage()}");
            }
        }
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
            'marketingCaseStudy' => $marketingCaseStudy->load('followerHistory'),
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

    public function loadTwitterData(MarketingCaseStudy $marketingCaseStudy): RedirectResponse
    {
        $today = Carbon::today();
        $alreadyLoaded = $marketingCaseStudy->followerHistory()
            ->whereDate('loaded_at', $today)
            ->exists();

        if ($alreadyLoaded) {
            return redirect()->back()->with([
                'type' => 'warning',
                'message' => 'Twitter data for today has already been loaded.',
            ]);
        }

        if (empty($marketingCaseStudy->client_twitter_username)) {
            return redirect()->back()->with([
                'type' => 'error',
                'message' => 'Twitter username is not set for this marketing case.',
            ]);
        }

        try {
            $result = $this->twitterService->getUserDataByUsername($marketingCaseStudy->client_twitter_username);

            $marketingCaseStudy->followerHistory()->create([
                'follower_count' => $result->public_metrics->followers_count,
                'loaded_at' => now(),
            ]);

            return redirect()->back()->with([
                'type' => 'success',
                'message' => 'Data loaded successfully.',
            ]);
        } catch (\Throwable $e) {
            logger()->error("Error getting Twitter followers for @{$marketingCaseStudy->client_twitter_username}: {$e->getMessage()}");
            return redirect()->back()->with([
                'type' => 'error',
                'message' => 'Error getting Twitter information. Please try again later.',
            ]);
        }
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
