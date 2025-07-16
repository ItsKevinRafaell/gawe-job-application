<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Category;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index(Request $request)
    {
        // Mulai query builder untuk Project
        $projectsQuery = Project::query();

        // Terapkan filter HANYA JIKA input diisi
        $projectsQuery->when($request->filled('name'), function ($query) use ($request) {
            return $query->where('name', 'like', '%' . $request->input('name') . '%');
        });

        $projectsQuery->when($request->filled('category_id'), function ($query) use ($request) {
            return $query->where('category_id', $request->input('category_id'));
        });

        $projectsQuery->when($request->filled('job_type'), function ($query) use ($request) {
            return $query->where('job_type', $request->input('job_type'));
        });

        $projectsQuery->when($request->filled('location_district'), function ($query) use ($request) {
            return $query->where('location_district', 'like', '%' . $request->input('location_district') . '%');
        });

        // Eager load relasi untuk optimasi dan filter hanya yang belum selesai
        $projects = $projectsQuery->with(['category', 'owner'])
                                  ->where('has_finished', false)
                                  ->orderByDesc('id')
                                  ->paginate(8);

        // Ambil semua kategori untuk dropdown filter
        $categories = Category::orderBy('name')->get();

        // Ambil semua jenis pekerjaan unik dari database untuk dropdown dinamis
        $job_types = Project::whereNotNull('job_type')
                            ->where('job_type', '!=', '')
                            ->distinct()
                            ->orderBy('job_type')
                            ->pluck('job_type');

        return view('front.index', compact('projects', 'categories', 'job_types'));
    }

    public function details(Project $project)
    {
        $projects = Project::where('category_id', $project->category_id)
            ->where('has_finished', false)
            ->orderByDesc('id')
            ->take(4)
            ->get();
        return view('front.details', compact('project', 'projects'));
    }

    public function apply(Project $project)
    {
        return view('front.apply', compact('project'));
    }

    public function category(Category $category)
    {
        $projects = Project::where('category_id', $category->id)
            ->where('has_finished', false)
            ->orderByDesc('id')
            ->paginate(8);
            
        return view('front.category', compact('projects', 'category'));
    }
}
