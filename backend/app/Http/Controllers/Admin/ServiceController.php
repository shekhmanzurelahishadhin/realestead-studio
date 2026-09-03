<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesMedia;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    use HandlesMedia;

    public function index()
    {
        return view('admin.services.index', [
            'services' => Service::orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.services.form', ['service' => new Service(['sort_order' => 0])]);
    }

    public function store(Request $request)
    {
        $service = Service::create($this->validated($request));

        return redirect()->route('admin.services.index')
            ->with('status', "Service “{$service->title}” created.");
    }

    public function edit(Service $service)
    {
        return view('admin.services.form', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $service->update($this->validated($request, $service));

        return redirect()->route('admin.services.index')
            ->with('status', "Service “{$service->title}” updated.");
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')->with('status', 'Service deleted.');
    }

    /** @return array<string, mixed> */
    private function validated(Request $request, ?Service $service = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            // `key` is what the frontend matches on, so it must stay stable and unique.
            'key' => ['nullable', 'string', 'max:100', 'alpha_dash', Rule::unique('services', 'key')->ignore($service)],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer'],
        ] + $this->mediaRules('image', required: true));

        // description is NOT NULL on this table.
        return array_merge($data, $this->media($request, ['image'], 'services'), [
            'key' => $data['key'] ?: Str::slug($data['title']),
            'description' => $data['description'] ?? '',
            'sort_order' => (int) ($data['sort_order'] ?? 0),
        ]);
    }
}
