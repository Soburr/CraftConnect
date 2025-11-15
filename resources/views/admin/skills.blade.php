@extends('layouts.admin')

@section('title', 'Skills Management')

@section('content')

    <div class="p-6">

        {{-- ALERT MESSAGES --}}
        @if (session('success'))
            <div class="mb-4 p-4 text-green-700 bg-green-100 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-4 text-red-700 bg-red-100 rounded-md">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Add Skill Form --}}
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-xl font-bold text-green-600 mb-4">Add New Skill</h2>

            <form action="{{ route('admin.skills.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    <div>
                        <label class="text-sm font-medium">Skill Name</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="w-full border rounded p-2" placeholder="e.g. Barber">
                    </div>

                    <div>
                        <label class="text-sm font-medium">Category</label>
                        <select name="category_id" class="w-full border rounded p-2">
                            <option value="">No Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-opacity-90">
                            Add Skill
                        </button>
                    </div>

                </div>
            </form>
        </div>

        {{-- Skills Table --}}
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-bold text-green-600 mb-4">All Skills</h2>

            <table class="w-full text-left">
                <thead>
                    <tr class="border-b font-semibold">
                        <th class="p-3">Skill</th>
                        <th class="p-3">Category</th>
                        <th class="p-3">Artisans</th>
                        <th class="p-3">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($skills as $skill)
                        <tr class="border-b">

                            <td class="p-3">{{ $skill->name }}</td>
                            <td class="p-3">{{ $skill->category->name ?? '—' }}</td>
                            <td class="p-3">{{ $skill->artisans_count }}</td>

                            <td class="p-3 flex gap-4">

                                {{-- EDIT --}}
                                <button onclick='editSkill(@json($skill))' class="text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M16.862 4.487l1.687-1.688a2.25 2.25 0 113.182 3.183L7.5 20.314l-4.5.75.75-4.5L16.862 4.487z" />
                                    </svg>
                                </button>

                                {{-- DELETE --}}
                                <button onclick="confirmDelete({{ $skill->id }})" class="text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M19.5 7.5l-.955 12.34A2.25 2.25 0 0116.3 22.5H7.7a2.25 2.25 0 01-2.244-2.66L4.5 7.5m5-3h5m-7 3h9M10 11v6m4-6v6" />
                                    </svg>
                                </button>

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

    {{-- EDIT SKILL MODAL --}}
    <div id="editSkillModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center p-4">

        <div class="bg-white w-full max-w-lg p-6 rounded-lg shadow-lg">

            <h2 class="text-xl font-bold text-[#0A2E5C] mb-4">Edit Skill</h2>

            <form id="editSkillForm" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="text-sm font-medium">Skill Name</label>
                    <input id="editSkillName" type="text" name="name" class="w-full border rounded p-2 mt-1">
                </div>

                <div class="mb-3">
                    <label class="text-sm font-medium">Category</label>
                    <select id="editSkillCategory" name="category_id" class="w-full border rounded p-2 mt-1">
                        <option value="">No Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end gap-4 mt-4">

                    <button type="button" onclick="closeEditSkillModal()" class="px-4 py-2 bg-gray-200 rounded-md">
                        Cancel
                    </button>

                    <button class="px-4 py-2 bg-[#0A2E5C] text-white rounded-md hover:bg-opacity-90">
                        Save Changes
                    </button>

                </div>

            </form>

        </div>
    </div>

    {{-- DELETE CONFIRMATION MODAL --}}
    <div id="deleteConfirmModal"
         class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center p-4">

        <div class="bg-white w-full max-w-sm p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold text-red-600 mb-3">Delete Skill</h2>

            <p class="text-gray-700 text-sm mb-6">
                Are you sure you want to delete this skill? This action cannot be undone.
            </p>

            <form id="deleteSkillForm" method="POST">
                @csrf
                @method('DELETE')

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeDeleteModal()"
                            class="px-4 py-2 bg-gray-200 rounded-md">
                        Cancel
                    </button>

                    <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Delete
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editSkill(skill) {
            document.getElementById('editSkillModal').classList.remove('hidden');
            document.getElementById('editSkillName').value = skill.name;
            document.getElementById('editSkillCategory').value = skill.category_id ?? '';
            document.getElementById('editSkillForm').action =
                `/admin/skills/${skill.id}`;
        }

        function closeEditSkillModal() {
            document.getElementById('editSkillModal').classList.add('hidden');
        }

        function confirmDelete(skillId) {
            document.getElementById('deleteConfirmModal').classList.remove('hidden');
            document.getElementById('deleteSkillForm').action = `/admin/skills/${skillId}`;
        }

        function closeDeleteModal() {
            document.getElementById('deleteConfirmModal').classList.add('hidden');
        }
    </script>

@endsection
