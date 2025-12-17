<x-play-layout>
  <section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto">
      <div class="flex flex-col text-center w-full mb-20">
        <p class="lg:w-2/3 mx-auto leading-relaxed text-base">総合成績</p>
        <h1 class="sm:text-4xl text-3xl font-medium title-font mb-2 text-gray-900">
          正解数：{{ $correctCount }} / {{ $questionCount }}
        </h1>
      </div>
      <div class="flex pl-4 mt-4 lg:w-2/3 w-full mx-auto">
        <button
          onclick="location.href='{{ route('categories', ['categoryId'=> $categoryId]) }}'"
          class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
          もう一度挑戦する
        </button>
      </div>
      <div class="flex pl-4 mt-4 lg:w-2/3 w-full mx-auto">
        <button
          onclick="location.href='{{ route('top', ['categoryId'=> $categoryId]) }}'"
          class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
          カテゴリー一覧に戻る
        </button>
      </div>
    </div>
  </section>
</x-play-layout>
