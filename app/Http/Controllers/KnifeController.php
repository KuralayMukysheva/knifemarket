<?php

namespace App\Http\Controllers;

use App\Models\Knife;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KnifeController extends Controller
{
    public function index(Request $request)
{
    $query = Knife::query();

    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    if ($request->filled('min_price')) {
        $query->where('price', '>=', $request->input('min_price'));
    }

    if ($request->filled('max_price')) {
        $query->where('price', '<=', $request->input('max_price'));
    }

    $knives = $query->latest()->get();

    return view('knives.index', compact('knives'));
} 

    public function create()
    {
        return view('knives.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $imagePath = $request->file('image')->store('knives', 'public');

        Knife::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath
        ]);

        return redirect()->route('knives.index');
    }

    public function edit(Knife $knife)
    {
        return view('knives.edit', compact('knife'));
    }

    public function update(Request $request, Knife $knife)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            Storage::delete('public/'.$knife->image);
            $validated['image'] = $request->file('image')->store('knives', 'public');
        }

        $knife->update($validated);

        return redirect()->route('knives.index')->with('success', 'Нож успешно обновлен');
    }

    public function destroy(Knife $knife)
    {
        Storage::delete('public/'.$knife->image);
        $knife->delete();

        return redirect()->route('knives.index')->with('success', 'Нож успешно удален');
    }
}