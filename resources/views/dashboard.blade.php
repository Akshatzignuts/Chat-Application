<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- Using Tailwind CSS classes for styling -->
    <div class="container mx-auto px-6 py-12">

        <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold mb-6 text-center">Contacts</h2>
                <ul class="space-y-4">
                    @foreach($users as $user)
                    <li>
                        <a href="{{ route('chat', $user->id) }}" class="flex items-center justify-between px-4 py-2 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 flex items-center justify-center bg-gray-200 rounded-full">
                                    <span class="text-lg font-medium text-gray-600">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                                <span class="text-lg font-medium text-gray-800">{{ $user->name }}</span>
                            </div>
                            <sup>last seen: {{$user->last_seen}}</sup>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
<style>
    .offline-status {
        color: red;
    }

    .online-status {
        color: green;
    }

    .create-group-button {
        position: absolute;
        top: 80px;
        left: 150vh;
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border-radius: 50%;
        cursor: pointer;
    }

</style>
