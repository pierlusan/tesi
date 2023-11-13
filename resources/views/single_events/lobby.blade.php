<x-app-layout>
    <div class="py-16">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="backdrop-blur-3xl overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6">
                    <div id="videos">
                        <video class="video-player"  id="user-1" autoplay playsinline></video>
                        <video class="video-player"  id="user-2" autoplay playsinline></video>
                    </div>

                    <div class="max-w-sm mx-auto sm:px-6 lg:px-8 mt-12">
                        <div class="flex justify-between item-center">
                            <div class="">
                                <x-primary-button id="camera-btn">
                                    <x-feathericon-video class="h-4 mr-1 -ml-1" />
                                    Camera
                                </x-primary-button>
                            </div>
                            <div class="">
                                <x-primary-button id="mic-btn">
                                    <x-feathericon-mic id="mic-icon" class="h-4 mr-1 -ml-1" />
                                    Mic
                                </x-primary-button>
                            </div>
                            <a href={{ route('dashboard') }}>
                                <div class="">
                                    <x-danger-button id="leave-btn">
                                        <x-feathericon-log-out class="h-4 mr-1 -ml-1" />
                                        Leave
                                    </x-danger-button>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@vite(['resources/css/webrtc.css', 'resources/js/agora-rtm-sdk-1.5.1.js', 'resources/js/webrtc.js'])
