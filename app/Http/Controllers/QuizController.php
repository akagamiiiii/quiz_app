<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Option;
use Illuminate\Http\Request;
use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * クイズ新規登録画面表示
     */
    public function create(Request $request, int $categoryId)
    {
        return view('admin.quizzes.create', [
            'categoryId' => $categoryId
        ]);
    }

    /**
     * クイズ新規登録処理
     */
    public function store(StoreQuizRequest $request, int $categoryId)
    {
        // 先にクイズを登録する
        $quiz = new Quiz();
        $quiz->category_id = $categoryId;
        $quiz->question    = $request->question;
        $quiz->explanation = $request->explanation;
        $quiz->save();

        // クイズIDをもとに、選択肢(Option)も登録する
        $options = [
            ['quiz_id' => $quiz->id, 'content' => $request->content1, 'is_correct' => $request->isCorrect1],
            ['quiz_id' => $quiz->id, 'content' => $request->content2, 'is_correct' => $request->isCorrect2],
            ['quiz_id' => $quiz->id, 'content' => $request->content3, 'is_correct' => $request->isCorrect3],
            ['quiz_id' => $quiz->id, 'content' => $request->content4, 'is_correct' => $request->isCorrect4],
        ];

        foreach ($options as $option){
            $newOption = new Option();
            $newOption->quiz_id = $option['quiz_id'];
            $newOption->content = $option['content'];
            $newOption->is_correct = $option['is_correct'];
            $newOption->save();
        }

        return redirect()->route('admin.categories.show', ['categoryId' => $categoryId]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz)
    {
        //
    }

    /**
     * クイズ編集画面表示
     */
    public function edit(Request $request, int $categoryId, int $quizId)
    {
        $quiz = Quiz::with('category', 'options')->findOrFail($quizId);
        return view('admin.quizzes.edit', [
            'category' => $quiz->category,
            'quiz'     => $quiz,
            'options'  => $quiz->options,
        ]);
    }

    /**
     * クイズ更新処理
     */
    public function update(UpdateQuizRequest $request, int $categoryId, int $quizId)
    {
        // dd($categoryId, $quizId, $request);
        // Quizの更新
        $quiz = Quiz::findOrFail($quizId);
        $quiz->question    = $request->question;
        $quiz->explanation = $request->explanation;
        $quiz->save();
        // Optionの更新
        $options = [
            ['optionId' => (int)$request->optionId1, 'content' => $request->content1, 'is_correct' => $request->isCorrect1],
            ['optionId' => (int)$request->optionId2, 'content' => $request->content2, 'is_correct' => $request->isCorrect2],
            ['optionId' => (int)$request->optionId3, 'content' => $request->content3, 'is_correct' => $request->isCorrect3],
            ['optionId' => (int)$request->optionId4, 'content' => $request->content4, 'is_correct' => $request->isCorrect4],
        ];

        foreach ($options as $option){
            $updateOption = Option::findOrFail($option['optionId']);
            $updateOption->content = $option['content'];
            $updateOption->is_correct = $option['is_correct'];
            $updateOption->save();
        }

        // カテゴリー詳細画面にリダイレクト
        return redirect()->route('admin.categories.show', ['categoryId' => $categoryId]);
    }

    /**
     * // クイズ削除機能
     */
    public function destroy(Request $request, int $categoryId, int $quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $quiz->delete();

        // カテゴリー詳細画面にリダイレクト
        return redirect()->route('admin.categories.show', ['categoryId' => $categoryId]);
    }
}
