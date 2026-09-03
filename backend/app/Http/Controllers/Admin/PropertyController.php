<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\GeneratesSlugs;
use App\Http\Controllers\Admin\Concerns\HandlesMedia;
use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PropertyController extends Controller
{
    use GeneratesSlugs, HandlesMedia;

    /** Mirrors the enum on the properties table — keep the two in step. */
    public const STATUSES = [
        'available' => 'Available',
        'upcoming' => 'Upcoming',
        'sold' => 'Sold',
    ];

    public function index(Request $request)
    {
        $properties = Property::query()
            ->when($request->string('q')->trim()->value(), fn ($query, $term) => $query->where(
                fn ($q) => $q->where('title', 'like', "%{$term}%")->orWhere('location', 'like', "%{$term}%")
            ))
            ->when($request->input('status'), fn ($query, $status) => $query->where('status', $status))
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        return view('admin.properties.index', compact('properties'));
    }

    public function create()
    {
        return view('admin.properties.form', ['property' => new Property(['status' => 'available', 'sort_order' => 0])]);
    }

    public function store(Request $request)
    {
        $property = Property::create($this->validated($request));

        return redirect()->route('admin.properties.index')
            ->with('status', "Property “{$property->title}” created.");
    }

    public function edit(Property $property)
    {
        return view('admin.properties.form', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        $property->update($this->validated($request, $property));

        return redirect()->route('admin.properties.index')
            ->with('status', "Property “{$property->title}” updated.");
    }

    public function destroy(Property $property)
    {
        $property->delete();

        return redirect()->route('admin.properties.index')->with('status', 'Property deleted.');
    }

    /** @return array<string, mixed> */
    private function validated(Request $request, ?Property $property = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', Rule::unique('properties', 'slug')->ignore($property)],
            'location' => ['required', 'string', 'max:255'],
            'price' => ['nullable', 'integer', 'min:0'],
            'price_label' => ['nullable', 'string', 'max:255'],
            'area' => ['nullable', 'integer', 'min:0'],
            'bedrooms' => ['nullable', 'integer', 'min:0', 'max:100'],
            'bathrooms' => ['nullable', 'integer', 'min:0', 'max:100'],
            'status' => ['required', Rule::in(array_keys(self::STATUSES))],
            'sort_order' => ['nullable', 'integer'],
            'amenities' => ['nullable', 'string'],
        ] + $this->mediaRules('image', required: true) + $this->galleryRules('gallery'));

        // Every numeric/label column on this table is NOT NULL, so blanks are
        // coerced here rather than handed to the database as null.
        $price = (int) ($data['price'] ?? 0);

        return array_merge($data, $this->media($request, ['image'], 'properties'), [
            'slug' => $data['slug'] ?: $this->uniqueSlug('properties', $data['title'], $property),
            'price' => $price,
            // The frontend prints priceLabel and never the raw number, so a
            // blank label would hide the price entirely.
            'price_label' => $data['price_label'] ?: ($price > 0 ? '$'.number_format($price) : 'Price on request'),
            'area' => (int) ($data['area'] ?? 0),
            'bedrooms' => (int) ($data['bedrooms'] ?? 0),
            'bathrooms' => (int) ($data['bathrooms'] ?? 0),
            'sort_order' => (int) ($data['sort_order'] ?? 0),
            'gallery' => $this->gallery($request, 'gallery', 'properties'),
            'amenities' => $this->lines($request->input('amenities')),
        ]);
    }
}
