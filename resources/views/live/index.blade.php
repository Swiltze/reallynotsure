<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-xl font-bold mb-4">Live Users</h1>
        <ul>
            @foreach ($users as $user)
                <li>
                    <!-- Link to the user's live stream page -->
                    <a href="{{ url('/live/' . $user->name) }}">{{ $user->name }}</a>
                </li>
            @endforeach
        </ul>
    </div>
</x-app-layout>
