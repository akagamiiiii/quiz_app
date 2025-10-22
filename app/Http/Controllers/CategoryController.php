<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function top()
    {
        //カテゴリー一覧を取得
        $categories = Category::get();
        return view('admin.top', [
            'categories' => $categories
        ]);
    }

    /**
     * カテゴリー新規登録画面
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * カテゴリー新規登録処理
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();
        return redirect()->route('admin.top');
    }

    /**
     * カテゴリー詳細画面表示
     */
    public function show(Request $request, $categoryId)
    {
        $category = Category::findOrFail($categoryId);
        return view('admin.categories.show', [
            'category' => $category
        ]);
    }

    /**
     * カテゴリー編集画面表示
     */
    public function edit(Request $request, $categoryId)
    {
        $category = Category::findOrFail($categoryId);
        return view('admin.categories.edit', [
            'category' => $category
        ]);
    }

    /**
     * カテゴリー更新処理
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
