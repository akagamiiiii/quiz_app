<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class PlayController extends Controller
{
    /**
     * プレイ画面トップページ
     */
    public function top()
    {
        $categories = Category::all();
        return view('play.top', [
            'categories' => $categories
        ]);
    }

    /**
     * クイズスタート画面表示
     */
    public function categories(Request $request, int $categoryId)
    {
        // セッションの削除
        session()->forget('resultArray');

        $category = Category::withCount('quizzes')->findOrFail($categoryId);
        return view('play.start', [
            'category' => $category,
            'quizzesCount' => $category->quizzes_count
        ]);
    }

    /**
     * クイズ出題画面
     */
    public function quizzes(Request $request, int $categoryId)
    {
        // カテゴリーに紐づくクイズと選択肢をすべて取得する
        $category = Category::with('quizzes.options')->findOrFail($categoryId);

        // セッションに保存されているクイズIDの配列を取得
        $resultArray = session('resultArray');
        // 初回アクセス時はセッションに保存されたクイズIDの配列がないため、クイズIDの配列を作成
        if (is_null($resultArray)) {
            // クイズIDを全て抽出する
            $quizIds = $category->quizzes->pluck('id')->toArray();
            // クイズIDの配列をランダムに入れ替える
            shuffle($quizIds);
            $resultArray = [];
            foreach ($quizIds as $quizId) {
                $resultArray[] = [
                    'quizId' => $quizId,
                    'result' => null,
                ];
            }

            // クイズIDの配列をセッションに保存
            session(['resultArray' => $resultArray]);
        }

        // $resultArrayの中で、resultがnullのもののうち、最初のデータを選ぶ
        $noAnswerResult = collect($resultArray)->filter(function ($item) {
            return $item['result'] === null;
        })->first();

        if (!$noAnswerResult) {
            dd('未解答のクイズは無くなりました');
        }

        // クイズIDに紐づくクイズを取得
        $quiz = $category->quizzes->firstWhere('id', $noAnswerResult['quizId'])->toArray();

        return view('play.quizzes', [
            'quiz' => $quiz,
            'categoryId' => $categoryId
        ]);
    }

    /**
     * クイズ解答画面
     */
    public function answer(Request $request, int $categoryId)
    {
        $quizId = $request->quizId;
        $slectedOptions = $request->optionId === null ? [] : $request->optionId;
        // カテゴリーに紐づくクイズと選択肢をすべて取得する
        $category = Category::with('quizzes.options')->findOrFail($categoryId);
        $quiz = $category->quizzes->firstWhere('id', $quizId);
        $quizOptions = $quiz->options->toArray();
        $isCorrectAnswer = $this->isCorrectAnswer($slectedOptions, $quizOptions);

        // セッションからクイズIDと解答情報を取得
        $resultArray = session('resultArray');
        foreach ($resultArray as $index => $result) {
            if ($result['quizId'] === (int)$quizId){
                $resultArray[$index]['result'] = $isCorrectAnswer;
                break;
            }
        }

        // 解答結果をセッションに保存する
        session(['resultArray' => $resultArray]);

        return view('play.answer', [
            'isCorrectAnswer' => $isCorrectAnswer,
            'quiz' => $quiz->toArray(),
            'quizOptions' => $quizOptions,
            'selectedOptions' => $slectedOptions,
            'categoryId' => $categoryId
        ]);
    }

    /**
     * プレイヤーの解答が正解か不正解かを判定
     */
    private function isCorrectAnswer(array $slectedOptions, array $quizOptions)
    {
        // クイズの選択肢から正解の選択肢を抽出し、そのidを全て取得する
        $correctOptions = array_filter($quizOptions, function($option) {
            return $option['is_correct'] === 1;
        });

        // idの数字だけを抽出する
        $correctOptionIds = array_map(function ($option) {
            return $option['id'];
        }, $correctOptions);

        // プレイヤーが選んだ選択肢の個数と正解の選択肢の個数が一致するかを判定する
        if (count($slectedOptions) !== count($correctOptionIds )) {
            return false;
        }

        // プレイヤーが選んだ選択肢のid番号と正解のidが全て一致することを判定する
        foreach ($slectedOptions as $slectedOption) {
            if (!in_array($slectedOption, $correctOptionIds )) {
                return false;
            }
        }

        // 正解であることを返す
        return true;
    }
}
