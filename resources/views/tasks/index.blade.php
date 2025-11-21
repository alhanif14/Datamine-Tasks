<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Tasks') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- ADD TASK FORM --}}
            <div class="bg-white p-6 shadow rounded-lg mb-6">
                <form method="POST" action="{{ route('tasks.store') }}">
                    @csrf

                    <div class="flex gap-3">
                        <input type="text"
                            name="title"
                            placeholder="New task..."
                            class="flex-1 border-gray-300 rounded-lg"
                            required>

                        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Add
                        </button>
                    </div>
                </form>
            </div>

            {{-- TASK LIST --}}
            <div class="bg-white shadow rounded-lg divide-y">
                @forelse ($tasks as $task)
                    <div class="flex items-center justify-between p-4">

                        {{-- LEFT SIDE: checkbox + title --}}
                        <div class="flex items-center gap-3">
                            <form action="{{ route('tasks.toggle', $task->id) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <input type="checkbox"
                                       onChange="this.form.submit()"
                                       {{ $task->is_completed ? 'checked' : '' }}
                                       class="h-5 w-5 text-green-600 rounded">
                            </form>

                            <p class="text-lg font-medium {{ $task->is_completed ? 'line-through text-gray-500' : '' }}">
                                {{ $task->title }}
                            </p>
                        </div>

                        {{-- Actions --}}
                        <div class="flex gap-2">
                            {{-- EDIT BUTTON --}}
                            <button 
                                onclick="openEditModal({{ $task->id }}, '{{ addslashes($task->title) }}')"
                                class="px-3 py-1 text-sm bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                Edit
                            </button>

                            {{-- DELETE BUTTON --}}
                            <button
                                onclick="openDeleteModal({{ $task->id }})"
                                class="px-3 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700">
                                Delete
                            </button>
                        </div>
                    </div>
                @empty
                    <p class="p-4 text-gray-500">No tasks yet.</p>
                @endforelse
            </div>

        </div>
    </div>

    {{-- EDIT MODAL --}}
    <div id="editModal"
         class="hidden fixed inset-0 bg-black/50 flex items-center justify-center">
        <div class="bg-white p-6 w-full max-w-md rounded-lg shadow">

            <h2 class="text-xl font-semibold mb-4">Edit Task</h2>

            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <input id="editTitle"
                       type="text"
                       name="title"
                       class="w-full border-gray-300 rounded-lg"
                       required>

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button"
                            onclick="closeEditModal()"
                            class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                        Cancel
                    </button>

                    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- DELETE MODAL --}}
    <div id="deleteModal"
         class="hidden fixed inset-0 bg-black/50 flex items-center justify-center">
        <div class="bg-white p-6 w-full max-w-sm rounded-lg shadow">

            <h2 class="text-lg font-semibold mb-3">Delete this task?</h2>
            <p class="text-gray-600 mb-4">This action cannot be undone.</p>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')

                <div class="flex justify-end gap-2">
                    <button type="button"
                            onclick="closeDeleteModal()"
                            class="px-3 py-2 bg-gray-200 rounded hover:bg-gray-300">
                        Cancel
                    </button>

                    <button class="px-3 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        Delete
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- JAVASCRIPT --}}
    <script>
        function openEditModal(id, title) {
            document.getElementById('editTitle').value = title;
            document.getElementById('editForm').action = `/tasks/${id}`;
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function openDeleteModal(id) {
            document.getElementById('deleteForm').action = `/tasks/${id}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        document.getElementById('editModal').addEventListener('click', (e) => {
            if (e.target === document.getElementById('editModal')) closeEditModal();
        });

        document.getElementById('deleteModal').addEventListener('click', (e) => {
            if (e.target === document.getElementById('deleteModal')) closeDeleteModal();
        });
    </script>

</x-app-layout>
