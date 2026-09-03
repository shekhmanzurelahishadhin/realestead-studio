<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProcessStep;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProcessStepController extends Controller
{
    public function index()
    {
        return view('admin.process-steps.index', [
            'steps' => ProcessStep::orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function create()
    {
        $next = (ProcessStep::max('sort_order') ?? 0) + 1;

        return view('admin.process-steps.form', [
            'step' => new ProcessStep([
                'sort_order' => $next,
                'index_label' => str_pad((string) $next, 2, '0', STR_PAD_LEFT),
            ]),
        ]);
    }

    public function store(Request $request)
    {
        $step = ProcessStep::create($this->validated($request));

        return redirect()->route('admin.process-steps.index')
            ->with('status', "Step “{$step->title}” created.");
    }

    public function edit(ProcessStep $processStep)
    {
        return view('admin.process-steps.form', ['step' => $processStep]);
    }

    public function update(Request $request, ProcessStep $processStep)
    {
        $processStep->update($this->validated($request, $processStep));

        return redirect()->route('admin.process-steps.index')
            ->with('status', "Step “{$processStep->title}” updated.");
    }

    public function destroy(ProcessStep $processStep)
    {
        $processStep->delete();

        return redirect()->route('admin.process-steps.index')->with('status', 'Step deleted.');
    }

    /** @return array<string, mixed> */
    private function validated(Request $request, ?ProcessStep $step = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'key' => ['nullable', 'string', 'max:100', 'alpha_dash', Rule::unique('process_steps', 'key')->ignore($step)],
            'index_label' => ['required', 'string', 'max:20'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        // description is NOT NULL on this table.
        return array_merge($data, [
            'key' => $data['key'] ?: Str::slug($data['title']),
            'description' => $data['description'] ?? '',
            'sort_order' => (int) ($data['sort_order'] ?? 0),
        ]);
    }
}
