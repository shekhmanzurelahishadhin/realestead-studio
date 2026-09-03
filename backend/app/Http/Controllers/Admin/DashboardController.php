<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\ProcessStep;
use App\Models\Project;
use App\Models\Property;
use App\Models\Service;
use App\Models\Stat;
use App\Models\Testimonial;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard', [
            'tiles' => [
                ['label' => 'Properties', 'value' => Property::count(), 'icon' => 'key', 'route' => route('admin.properties.index')],
                ['label' => 'Projects', 'value' => Project::count(), 'icon' => 'building', 'route' => route('admin.projects.index')],
                ['label' => 'Services', 'value' => Service::count(), 'icon' => 'sparkles', 'route' => route('admin.services.index')],
                ['label' => 'Testimonials', 'value' => Testimonial::count(), 'icon' => 'quote', 'route' => route('admin.testimonials.index')],
                ['label' => 'Process steps', 'value' => ProcessStep::count(), 'icon' => 'list', 'route' => route('admin.process-steps.index')],
                ['label' => 'Stats', 'value' => Stat::count(), 'icon' => 'chart', 'route' => route('admin.stats.index')],
            ],
            'unread' => ContactMessage::where('is_read', false)->count(),
            'totalMessages' => ContactMessage::count(),
            'portfolioValue' => (int) Property::sum('price'),
            'statusBreakdown' => $this->statusBreakdown(),
            'messagesPerDay' => $this->messagesPerDay(),
            'recentMessages' => ContactMessage::latest()->take(5)->get(),
            'recentProperties' => Property::latest()->take(5)->get(),
        ]);
    }

    /**
     * Property count per status, in the panel's canonical status order so the
     * chart legend does not reshuffle when a status drops to zero.
     *
     * @return array<int, array{label: string, total: int}>
     */
    private function statusBreakdown(): array
    {
        $counts = Property::query()
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        return collect(PropertyController::STATUSES)
            ->map(fn ($label, $key) => ['label' => $label, 'total' => (int) ($counts[$key] ?? 0)])
            ->values()
            ->all();
    }

    /**
     * Last 14 days of contact-form volume, zero-filled so the bar chart keeps
     * a fixed width regardless of how quiet a week was.
     *
     * @return array<int, array{label: string, short: string, total: int}>
     */
    private function messagesPerDay(): array
    {
        $start = Carbon::today()->subDays(13);

        $counts = ContactMessage::query()
            ->where('created_at', '>=', $start)
            ->get(['created_at'])
            ->countBy(fn ($message) => $message->created_at->toDateString());

        return collect(range(0, 13))
            ->map(function (int $offset) use ($start, $counts) {
                $day = $start->copy()->addDays($offset);

                return [
                    'label' => $day->format('j M'),
                    'short' => $day->format('j'),
                    'total' => (int) ($counts[$day->toDateString()] ?? 0),
                ];
            })
            ->all();
    }
}
