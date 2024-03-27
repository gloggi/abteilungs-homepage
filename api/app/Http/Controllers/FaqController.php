<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFaqRequest;
use App\Http\Requests\UpdateFaqRequest;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 1000);
        $query = Faq::with('questions');
        $user = Auth::user();
        if ($request->has('dashboard') && ! $user->hasRole('admin')) {
            $groupIds = $user->groups->pluck('id');
            $query->whereIn('group_id', $groupIds);
        }

        $faqs = $query->paginate($perPage);

        return response()->json($faqs);
    }

    public function store(StoreFaqRequest $request)
    {
        $validated = $request->validated();
        $user = Auth::user();
        if (! $user->hasRole('admin') && ! isset($validated['group_id'])) {
            $groups = $user->groups->pluck('id');
            $validated['group_id'] = $groups->first();
        }
        $faq = Faq::create($validated);
        if (isset($validated['questions'])) {
            $questionIds = array_column($validated['questions'], 'id');
            $faq->questions()->whereNotIn('id', $questionIds)->delete();

            foreach ($validated['questions'] as $questionData) {
                $questionData['sort'] = floor($questionData['sort']);
                $faq->questions()->updateOrCreate(
                    ['id' => $questionData['id'] ?? null],
                    $questionData
                );
            }

        }

        return response()->json($faq, 201);
    }

    public function show($id)
    {
        $faq = Faq::with('questions')->find($id);

        if (! $faq) {
            return response()->json(['message' => 'Faq not found'], 404);
        }

        return response()->json($faq);
    }

    public function update(UpdateFaqRequest $request, $id)
    {
        $faq = Faq::find($id);

        if (! $faq) {
            return response()->json(['message' => 'Question not found'], 404);
        }
        $validated = $request->validated();
        $user = Auth::user();
        if (! $user->hasRole('admin')) {
            $groups = $user->groups->pluck('id');
            $groupId = $validated['group_id'];
            if (! $groups->contains($groupId)) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }
        $faq->update($validated);
        if (isset($validated['questions'])) {
            $questionIds = array_column($validated['questions'], 'id');
            $faq->questions()->whereNotIn('id', $questionIds)->delete();
            $questions = $validated['questions'];
            foreach ($questions as $questionData) {
                $faq->questions()->updateOrCreate(
                    ['id' => $questionData['id'] ?? null],
                    $questionData
                );
            }

        }

        return response()->json($faq);
    }

    public function destroy($id)
    {
        $faq = Faq::find($id);

        if (! $faq) {
            return response()->json(['message' => 'Question not found'], 404);
        }
        $user = Auth::user();
        if (! $user->hasRole('admin')) {
            $groups = $user->groups->pluck('id');
            $groupId = $faq->group_id;
            if (! $groups->contains($groupId)) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }

        $faq->delete();

        return response()->json(null, 204);
    }
}
