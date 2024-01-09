<x-app-layout>
    <div class="flex h-screen">
        <div class="flex-grow relative">
            <!-- Embed your video here --> 
            <div class="absolute inset-0 flex justify-center items-center bg-black">
                <video controls class="w-full h-full max-w-full max-h-full">
                    <source src="https://cam.goldbudz.com/stream/hls/treez.m3u8" type="application/x-mpegURL" />
                    Your browser does not support the video tag.
                </video>
            </div>
        
    
    </div>
    <div class="w-80 bg-gray-800 flex flex-col">
        @include('components.chat', ['messages' => $messages])
    </div>
</x-app-layout>
