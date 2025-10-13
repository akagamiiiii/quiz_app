<x-admin-layout>
  <section class="text-gray-600 body-font relative">
  <div class="container px-5 py-24 mx-auto">
    <div class="flex flex-col text-center w-full mb-12">
      <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">カテゴリーを登録してください</h1>
    </div>
    <div class="lg:w-1/2 md:w-2/3 mx-auto">
      <div class="flex flex-wrap -m-2">
        {{-- ボタン --}}
        <div class="p-2 w-full">
          <button
            onclick="location.href='{{ route('admin.categories.create') }}'"
            class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">
            カテゴリー新規登録
          </button>
        </div>
        </div>
      </div>
    </div>
  </div>
</section>
</x-admin-layout>