<x-app-layout>
    <div class="flex h-screen">
        <div class="flex-grow relative">
            <!-- Embed the user's video stream here -->
            <div class="absolute inset-0 flex justify-center items-center bg-black">
                <!-- Include the stream component and pass the username -->
                @include('components.stream', ['username' => $user->name])
            </div>
        </div>
        <div class="w-80 bg-gray-800 flex flex-col">
            <!-- Include the chat component and pass the messages -->
            @include('components.chat', ['messages' => $messages])
        </div>
    </div>
</x-app-layout>
