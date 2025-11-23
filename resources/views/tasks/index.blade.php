<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Tasks') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- WEATHER WIDGET --}}
            @if ($weather)
                <div class="flex justify-end mb-4">
                    <div onclick="openWeatherModal()"
                         class="group cursor-pointer inline-flex items-center gap-2 px-4 py-1.5 bg-white/80 backdrop-blur-sm border border-blue-100 rounded-full shadow-sm hover:shadow-md hover:bg-white transition-all duration-300">
                        
                        {{-- small icon --}}
                        <img src="http://openweathermap.org/img/wn/{{ $weather['weather'][0]['icon'] }}.png" 
                             class="w-6 h-6 group-hover:scale-110 transition-transform">

                        {{-- short info --}}
                        <div class="text-sm font-medium text-gray-600 group-hover:text-blue-600 flex items-center gap-2">
                            <span>{{ round($weather['main']['temp']) }}°C</span>
                            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                            <span class="truncate max-w-[100px]">{{ $weather['name'] }}</span>
                        </div>
                    </div>
                </div>
            @endif

            {{-- ADD TASK FORM --}}
            <div class="bg-white p-5 shadow-md rounded-xl mb-6 border border-gray-100">
                <form method="POST" action="{{ route('tasks.store') }}">
                    @csrf
                    <div class="flex gap-3">
                        <input type="text"
                            name="title"
                            placeholder="Add a new task..."
                            class="flex-1 rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            required>

                        <button class="px-5 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 shadow transition-colors">
                            Add
                        </button>
                    </div>
                </form>
            </div>

            {{-- TASK LIST --}}
            <div class="bg-white shadow-md rounded-xl divide-y border border-gray-100">
                @forelse ($tasks as $task)
                    <div class="flex items-center justify-between p-4 hover:bg-gray-50 transition">

                        <div class="flex items-center gap-3">
                            <form action="{{ route('tasks.toggle', $task->id) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <input type="checkbox"
                                       onChange="this.form.submit()"
                                       {{ $task->is_completed ? 'checked' : '' }}
                                       class="h-5 w-5 text-green-600 rounded focus:ring-green-500 cursor-pointer">
                            </form>

                            <p class="text-lg font-medium transition-all {{ $task->is_completed ? 'line-through text-gray-400' : 'text-gray-700' }}">
                                {{ $task->title }}
                            </p>
                        </div>

                        <div class="flex gap-2 opacity-80 hover:opacity-100 transition-opacity">
                            <button 
                                onclick="openEditModal({{ $task->id }}, '{{ addslashes($task->title) }}')"
                                class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition">
                                {{-- Edit Icon (SVG biar lebih rapi daripada text) --}}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </button>

                            <button
                                onclick="openDeleteModal({{ $task->id }})"
                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                                {{-- Delete Icon --}}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <p class="text-gray-500">No tasks yet. Start by adding one!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- MODALS & SCRIPTS --}}
    
    {{-- Edit & Delete Modals --}}
    <div id="editModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white p-6 w-full max-w-md rounded-xl shadow-2xl transform transition-all">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Edit Task</h2>
            <form id="editForm" method="POST">
                @csrf @method('PUT')
                <input id="editTitle" type="text" name="title" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                <div class="flex justify-end gap-2 mt-6">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-medium">Cancel</button>
                    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <div id="deleteModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white p-6 w-full max-w-sm rounded-xl shadow-2xl">
            <h2 class="text-lg font-bold text-gray-800 mb-2">Delete this task?</h2>
            <p class="text-gray-500 mb-6">This action cannot be undone.</p>
            <form id="deleteForm" method="POST">
                @csrf @method('DELETE')
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-medium">Cancel</button>
                    <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium">Delete</button>
                </div>
            </form>
        </div>
    </div>

    {{-- WEATHER MODAL --}}
    <div id="weatherModal" class="fixed inset-0 bg-black/60 hidden items-center justify-center backdrop-blur-sm z-50 transition-opacity">
        <div onclick="event.stopPropagation()" class="bg-white w-full max-w-sm p-6 rounded-2xl shadow-2xl relative overflow-hidden">
            
            {{-- Background Decor --}}
            <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-blue-100 rounded-full blur-3xl opacity-50"></div>
            <div class="absolute bottom-0 left-0 -mb-8 -ml-8 w-32 h-32 bg-yellow-100 rounded-full blur-3xl opacity-50"></div>

            <div class="relative z-10">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">{{ $weather['name'] }}</h2>
                        <p class="text-gray-500 text-sm">{{ date('l, d F Y') }}</p>
                    </div>
                    <span class="px-2 py-1 bg-blue-50 text-blue-600 text-xs rounded-md font-medium uppercase tracking-wide">
                        {{ $weather['weather'][0]['main'] }}
                    </span>
                </div>

                <div class="flex items-center gap-4 mb-8">
                    <div class="bg-blue-50 rounded-2xl p-2">
                        <img src="http://openweathermap.org/img/wn/{{ $weather['weather'][0]['icon'] }}@2x.png" class="w-16 h-16">
                    </div>
                    <div>
                        <p class="text-4xl font-bold text-gray-900">{{ round($weather['main']['temp']) }}°</p>
                        <p class="text-gray-500 capitalize">{{ $weather['weather'][0]['description'] }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-2 mb-6 text-center">
                    <div class="bg-gray-50 p-3 rounded-xl">
                        <p class="text-xs text-gray-400 mb-1">Humidity</p>
                        <p class="font-semibold text-gray-700">{{ $weather['main']['humidity'] }}%</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-xl">
                        <p class="text-xs text-gray-400 mb-1">Wind</p>
                        <p class="font-semibold text-gray-700">{{ $weather['wind']['speed'] }}m/s</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-xl">
                        <p class="text-xs text-gray-400 mb-1">Feels Like</p>
                        <p class="font-semibold text-gray-700">{{ round($weather['main']['feels_like']) }}°</p>
                    </div>
                </div>

                <button onclick="closeWeatherModal()" class="w-full py-3 bg-gray-900 text-white rounded-xl hover:bg-black transition font-medium">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
        function openEditModal(id, title) {
            document.getElementById('editTitle').value = title;
            document.getElementById('editForm').action = `/tasks/${id}`;
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editModal').classList.add('flex');
        }
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('editModal').classList.remove('flex');
        }
        function openDeleteModal(id) {
            document.getElementById('deleteForm').action = `/tasks/${id}`;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
        }
        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteModal').classList.remove('flex');
        }
        function openWeatherModal() {
            document.getElementById('weatherModal').classList.remove('hidden');
            document.getElementById('weatherModal').classList.add('flex');
        }
        function closeWeatherModal() {
            document.getElementById('weatherModal').classList.add('hidden');
            document.getElementById('weatherModal').classList.remove('flex');
        }

        window.onclick = function(event) {
            const modals = ['editModal', 'deleteModal', 'weatherModal'];
            modals.forEach(id => {
                const modal = document.getElementById(id);
                if (event.target === modal) {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }
            });
        }
    </script>
</x-app-layout>