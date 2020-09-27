<?php

namespace App\Http\Controllers;

use App\Category;
use App\CategoryOption;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('categories.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->save();
        foreach ($request->options as $option) {
            $category->options()->create([
                'title' => $option['title'],
                'type' => $option['type']
            ]);
        }
        return response()->json([], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Category $category)
    {
        $category->load('options');
        return response()->json(['category' => $category], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Category $category)
    {
        $category->load('options');
        return view('categories.form', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(Request $request, Category $category)
    {
        $category->name = $request->name;
        $category->save();
        $options = collect($request->options);
        foreach ($category->options as $category_option) {
            if ($options->where('id', $category_option->id)->count() > 0) {
                $option = $options->where('id', $category_option->id)->first();
                $category_option->title = $option['title'];
                $category_option->type = $option['type'];
                $category_option->save();
            } else {
                $category_option->delete();
            }
        }
        foreach ($options->whereNull('id') as $option) {
            $category->options()->create([
                'title' => $option['title'],
                'type' => $option['type']
            ]);
        }

        return response()->json([], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        $category->options()->delete();
        $category->delete();
        return redirect()->route('categories.index');
    }
}
