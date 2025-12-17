<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\PlayController;
use Illuminate\Support\Facades\Route;

// プレイヤー画面
Route::get('/', [PlayController::class, 'top'])->name('top');
// クイズのスタート画面
Route::get('categories/{categoryId}', [PlayController::class, 'categories'])->name('categories');
// クイズ出題画面
Route::get('categories/{categoryId}/quizzes', [PlayController::class, 'quizzes'])->name('categories.quizzes');
// クイズ解答画面
Route::post('categories/{categoryId}/quizzes', [PlayController::class, 'answer'])->name('categories.quizzes.answer');
// リザルト画面
Route::get('categories/{categoryId}/quizzes/result', [PlayController::class, 'result'])->name('categories.quizzes.result');

// 管理者の認証機能
require __DIR__.'/auth.php';

// 管理画面
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    //管理画面トップページ 兼 カテゴリー一覧表示
    Route::get('top', [CategoryController::class, 'top'])->name('top');

    // カテゴリー管理
    Route::prefix('categories')->name('categories.')->group(function () {
        // カテゴリー新規登録画面
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        // カテゴリー新規登録処理
        Route::post('/store', [CategoryController::class, 'store'])->name('store');
        // カテゴリー詳細表示・兼・クイズ一覧表示画面
        Route::get('{categoryId}', [CategoryController::class, 'show'])->name('show');
        // カテゴリー編集画面表示
        Route::get('{categoryId}/edit', [CategoryController::class, 'edit'])->name('edit');
        // カテゴリー更新処理
        Route::post('{categoryId}/update', [CategoryController::class, 'update'])->name('update');
        // カテゴリー削除処理
        Route::post('{categoryId}/destroy', [CategoryController::class, 'destroy'])->name('destroy');

        // クイズ管理
        Route::prefix('{categoryId}/quizzes')->name('quizzes.')->group(function () {
            // クイズ新規登録画面
            Route::get('create', [QuizController::class, 'create'])->name('create');
            // クイズ新規登録処理
            Route::post('store', [QuizController::class, 'store'])->name('store');
            // クイズ編集画面
            Route::get('{quizId}/edit', [QuizController::class, 'edit'])->name('edit');
            // クイズ更新機能
            Route::post('{quizId}/update', [QuizController::class, 'update'])->name('update');
            // クイズ削除機能
            Route::post('{quizId}/destroy', [QuizController::class, 'destroy'])->name('destroy');
        });
    });
});
