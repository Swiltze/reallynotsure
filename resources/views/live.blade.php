<x-app-layout>
    <div class="flex h-screen">
        <div class="flex-grow relative">
            <!-- Embed your video here --> 
            <div class="absolute inset-0 flex justify-center items-center bg-black">
                @include('components.stream', ['username' => $username])
            </div>
        
    
    </div>
    <div class="w-80 bg-gray-800 flex flex-col">
        @include('components.chat', ['messages' => $messages])
    </div>
</x-app-layout>
