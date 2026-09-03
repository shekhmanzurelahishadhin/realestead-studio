<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\GeneratesSlugs;
use App\Http\Controllers\Admin\Concerns\HandlesMedia;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    use GeneratesSlugs, HandlesMedia;

    public function index(Request $request)
    {
        $projects = Project::query()
            ->when($request->string('q')->trim()->value(), fn ($query, $term) => $query->where(
                fn ($q) => $q->where('name', 'like', "%{$term}%")->orWhere('location', 'like', "%{$term}%")
            ))
            ->when($request->input('category'), fn ($query, $category) => $query->where('category', $category))
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        $categories = Project::query()->whereNotNull('category')->distinct()->pluck('category', 'category');

        return view('admin.projects.index', compact('projects', 'categories'));
    }

    public function create()
    {
        return view('admin.projects.form', ['project' => new Project(['sort_order' => 0])]);
    }

    public function store(Request $request)
    {
        $project = Project::create($this->validated($request));

        return redirect()->route('admin.projects.index')
            ->with('status', "Project “{$project->name}” created.");
    }

    public function edit(Project $project)
    {
        return view('admin.projects.form', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $project->update($this->validated($request, $project));

        return redirect()->route('admin.projects.index')
            ->with('status', "Project “{$project->name}” updated.");
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index')->with('status', 'Project deleted.');
    }

    /** @return array<string, mixed> */
    private function validated(Request $request, ?Project $project = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', Rule::unique('projects', 'slug')->ignore($project)],
            'location' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'year' => ['nullable', 'string', 'max:20'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer'],
            'stat_keys' => ['nullable', 'array'],
            'stat_keys.*' => ['nullable', 'string', 'max:100'],
            'stat_values' => ['nullable', 'array'],
            'stat_values.*' => ['nullable', 'string', 'max:100'],
        ] + $this->mediaRules('image', required: true) + $this->galleryRules('gallery'));

        // category / year / description are NOT NULL on this table.
        return array_merge($data, $this->media($request, ['image'], 'projects'), [
            'slug' => $data['slug'] ?: $this->uniqueSlug('projects', $data['name'], $project),
            'category' => $data['category'] ?? '',
            'year' => $data['year'] ?? '',
            'description' => $data['description'] ?? '',
            'sort_order' => (int) ($data['sort_order'] ?? 0),
            'gallery' => $this->gallery($request, 'gallery', 'projects'),
            'stats' => $this->pairs($request->input('stat_keys'), $request->input('stat_values')),
        ]);
    }

    /**
     * The `stats` column is a list of {label, value} objects — the shape the
     * API hands the frontend verbatim — edited as two parallel input columns.
     * Rows without a label are dropped so a blank row never becomes data.
     *
     * @return array<int, array{label: string, value: string}>
     */
    private function pairs(?array $keys, ?array $values): array
    {
        $stats = [];

        foreach ($keys ?? [] as $i => $key) {
            $label = trim((string) $key);

            if ($label !== '') {
                $stats[] = ['label' => $label, 'value' => trim((string) ($values[$i] ?? ''))];
            }
        }

        return $stats;
    }
}
