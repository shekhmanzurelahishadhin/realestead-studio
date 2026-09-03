<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stat;
use Illuminate\Http\Request;

class StatController extends Controller
{
    public function index()
    {
        return view('admin.stats.index', [
            'stats' => Stat::orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.stats.form', ['stat' => new Stat(['sort_order' => 0])]);
    }

    public function store(Request $request)
    {
        $stat = Stat::create($this->validated($request));

        return redirect()->route('admin.stats.index')
            ->with('status', "Stat “{$stat->label}” created.");
    }

    public function edit(Stat $stat)
    {
        return view('admin.stats.form', compact('stat'));
    }

    public function update(Request $request, Stat $stat)
    {
        $stat->update($this->validated($request));

        return redirect()->route('admin.stats.index')
            ->with('status', "Stat “{$stat->label}” updated.");
    }

    public function destroy(Stat $stat)
    {
        $stat->delete();

        return redirect()->route('admin.stats.index')->with('status', 'Stat deleted.');
    }

    /** @return array<string, mixed> */
    private function validated(Request $request): array
    {
        $data = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'value' => ['required', 'numeric'],
            'suffix' => ['nullable', 'string', 'max:20'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        return array_merge($data, [
            'suffix' => $data['suffix'] ?? '',
            'sort_order' => (int) ($data['sort_order'] ?? 0),
        ]);
    }
}
