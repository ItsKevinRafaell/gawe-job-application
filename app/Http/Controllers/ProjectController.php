<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\StoreToolProjectRequest;
use App\Http\Requests\StoreToolRequest;
use App\Models\Category;
use App\Models\Project;
use App\Models\ProjectApplicant;
use App\Models\ProjectTool;
use App\Models\Tool;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $projectsQuery = Project::with(['category', 'applicants'])->orderByDesc('id');

        if($user->hasRole('project_client')){
            $projectsQuery->whereHas('owner', function ($query) use ($user) {
                $query->where('client_id', $user->id);
            });
        }

        $projects = $projectsQuery->paginate(10);

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.projects.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $user = Auth::user();
        $balance = $user->wallet->balance;

        if($request->input('budget') > $balance){
            return redirect()->back()->withErrors('error', 'Balance Anda tidak cukup');
        }



        DB::transaction(function () use($request, $user){
            $user->wallet->decrement('balance', $request->input('budget'));

            $projectWalletTransaction = WalletTransaction::create([
                'type' => 'Project Cost',
                'amount' => $request->input('budget'),
                'is_paid' => true,
                'user_id' => $user->id,
            ]);

            $validated = $request->validated();

            if($request->hasFile('thumbnail')){
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
                $validated['thumbnail'] = $thumbnailPath;

                $validated['slug'] = Str::slug($validated['name']);
                $validated['has_finished'] = false;
                $validated['has_started'] = false;
                $validated['client_id'] = $user->id;

                $newProject = Project::create($validated);
            }

            return redirect()->route('admin.projects.index');
        });
    }

    public function tools(Project $project)
    {
        if($project->client_id != Auth::id()){
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }

        $tools = Tool::all();
        return view('admin.projects.tools', compact('project', 'tools'));
    }

    public function tools_store(StoreToolProjectRequest $request, Project $project){
        DB::transaction(function () use($request, $project){
            $validated = $request->validated();
            $validated['project_id'] = $project->id;

            $toolProject = ProjectTool::firstOrCreate($validated);

        });
        return redirect()->route('admin.projects.tools', $project->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }

    public function complete_project_store(ProjectApplicant $projectApplicant){
        DB::transaction(function () use ($projectApplicant){
            $validated['type'] = 'Revenue';
            $validated['amount'] = $projectApplicant->project->budget;
            $validated['is_paid'] = true;
            $validated['user_id'] = $projectApplicant->freelancer_id;
            WalletTransaction::create($validated);

            $projectApplicant->freelancer->wallet->increment('balance', $projectApplicant->project->budget);

            $projectApplicant->project->update([
                'has_finished' => true
            ]);

            return redirect()->route('admin.projects.show', [$projectApplicant->project, $projectApplicant->id]);
        });
    }

}
