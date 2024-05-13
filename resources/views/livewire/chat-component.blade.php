<div class="h-screen flex flex-col">
    <!-- Header -->
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.Swal = require('sweetalert2');

    </script>
    <div class="fixed w-full bg-green-400 h-16 pt-2 text-white flex justify-between shadow-md" style="top:0px;">
        <!-- back button -->
        <a href="/dashboard">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-8 h-8 my-1 text-green-100 ml-2 hover:text-green-200">
                <path class="text-green-100 fill-current" d="M9.41 11H17a1 1 0 0 1 0 2H9.41l2.3 2.3a1 1 0 1 1-1.42 1.4l-4-4a1 1 0 0 1 0-1.4l4-4a1 1 0 0 1 1.42 1.4L9.4 11z" />
            </svg>
        </a>
        <div class="my-3 text-green-100 font-bold text-lg tracking-wide px-2">{{ $user->name }}</div>
        <!-- 3 dots -->
        <div class="relative">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon-dots-vertical w-8 h-8 mt-2 mr-2 hover:text-green-200" id="dropdown-button" aria-haspopup="true" aria-expanded="false">
                <path class="text-green-100 fill-current" fill-rule="evenodd" d="M12 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4z" />
            </svg>
            <div class="hidden bg-white shadow-md py-2 absolute right-0 mt-2 w-48" id="dropdown">
                <a href="{{route('user.block', ['userId' => $user->id])}}" class="block w-full py-2 px-4 text-sm text-red-500 hover:text-red-700 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-200">
                    Block User
                </a>
                <a href="{{route('user.unblock', ['userId' => $user->id])}}" class="block w-full py-2 px-4 text-sm text-red-500 hover:text-red-700 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-200">
                    UnBlock User
                </a>
            </div>
        </div>
    </div>
    <!-- Chat messages -->
    <div class="flex-1 overflow-y-auto p-4">
        @foreach ($messages as $message)
        @if ($message['sender']!= auth()->user()->name)
        <div class="clearfix mb-4">
            <div class="bg-gray-300 p-2 rounded-lg inline-block">
                <b>{{ $message['sender'] }} :</b> {{ $message['message'] }}
            </div>
        </div>
        @else

        <div class="clearfix mb-4 text-right">
            <div class="bg-green-400 p-2 rounded-lg inline-block text-white">
                {{ $message['message'] }} <b>: You</b>
            </div>
        </div>
        @endif
        @endforeach
    </div>
    <!-- Chat input -->
    <form wire:submit="sendMessage()">
        <div class="fixed w-full flex justify-between bg-green-100 py-2" style="bottom: 0px;">
            <textarea class="flex-grow m-2 py-2 px-4 rounded-lg border border-gray-300 bg-gray-200 resize-none" rows="1" wire:model="message" placeholder="Type your message..." style="outline: none;"></textarea>
            <button class="m-2 bg-green-400 text-white py-2 px-4 rounded-full hover:bg-green-500" type="submit" style="outline: none;">
                <svg class="svg-inline--fa fa-paper-plane fa-w-16 w-6 h-6 mr-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="paper-plane" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="currentColor" d="M476 3.2L12.5 270.6c-18.1 10.4-15.8 35.6 2.2 43.2L121 358.4l287.3-253.2c5.5-4.9 13.3 2.6 8.6 8.3L176 407v80.5c0 23.6 28.5 32.9 42.5 15.8L282 426l124.6 52.2c14.2 6 30.4-2.9 33-18.2l72-432C515 7.8 493.3-6.8 476 3.2z" />
                </svg>
            </button>
        </div>
    </form>
</div>
<script>
    document.getElementById('dropdown-button').addEventListener('click', function() {
        document.getElementById('dropdown').classList.toggle('hidden');
    });

</script>
