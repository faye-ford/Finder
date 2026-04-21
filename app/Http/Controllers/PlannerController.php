<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\TravelPlan;
use App\Models\TravelPlanItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlannerController extends Controller
{
    public function index()
    {
        $plans = Auth::user()->plans()->with('items.post')->latest()->get();
        $posts = Post::visible()->latest()->limit(12)->get();

        return view('plans.index', [
            'plans' => $plans,
            'posts' => $posts,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:140'],
            'description' => ['nullable', 'string', 'max:500'],
            'planned_date' => ['nullable', 'date'],
        ]);

        Auth::user()->plans()->create($data);

        return redirect()->route('plans.index')->with('status', 'Travel plan created.');
    }

    public function addItem(Request $request, TravelPlan $plan)
    {
        if ($plan->user_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validate([
            'post_id' => ['required', 'exists:posts,id'],
            'note' => ['nullable', 'string', 'max:300'],
        ]);

        TravelPlanItem::create([
            'travel_plan_id' => $plan->id,
            'post_id' => $data['post_id'],
            'note' => $data['note'] ?? '',
            'order' => $plan->items()->count() + 1,
        ]);

        return redirect()->route('plans.index')->with('status', 'Destination added to your trip plan.');
    }

    public function destroy(TravelPlan $plan)
    {
        if ($plan->user_id !== Auth::id()) {
            abort(403);
        }

        $plan->delete();

        return redirect()->route('plans.index')->with('status', 'Travel plan removed.');
    }

    public function destroyItem(TravelPlanItem $item)
    {
        if ($item->plan->user_id !== Auth::id()) {
            abort(403);
        }

        $item->delete();

        return redirect()->route('plans.index')->with('status', 'Plan item removed.');
    }
}
