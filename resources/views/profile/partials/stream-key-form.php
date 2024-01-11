<form method="POST" action="{{ route('stream-key.reset') }}">
    @csrf
    @method('PATCH')

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
            Stream Key
        </label>
        <input type="text" readonly class="mt-1 block w-full" value="{{ $user->stream_key }}">
    </div>

    <div>
        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
            {{ __('Reset Stream Key') }}
        </button>
    </div>
</form>
