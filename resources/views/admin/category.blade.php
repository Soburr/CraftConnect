@extends('layouts.admin')

@section('title', 'Categories Management')

@section('content')

    <div class="p-6">
        {{-- Add Category --}}
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-xl font-bold text-[#19813c] mb-4">Add New Category</h2>

            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    <div>
                        <label class="text-sm font-medium">Category Name</label>
                        <input type="text" name="name" class="w-full border rounded p-2 mt-1"
                            placeholder="e.g., Repairs, Fashion, Electrical">
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-sm font-medium">Description (optional)</label>
                        <textarea name="description" class="w-full border rounded p-2 mt-1" rows="1"
                            placeholder="Short explanation of the category"></textarea>
                    </div>

                </div>

                <button class="mt-4 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-opacity-90">
                    Add Category
                </button>
            </form>
        </div>

        {{-- Category List --}}
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-bold text-green-600 mb-4">All Categories</h2>

            <table class="w-full text-left">
                <thead>
                    <tr class="border-b font-semibold">
                        <th class="p-3">Category</th>
                        <th class="p-3">Description</th>
                        <th class="p-3">Skills</th>
                        <th class="p-3">Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($categories as $category)
                        <tr class="border-b">

                            <td class="p-3 font-medium">
                                {{ $category->name }}
                            </td>

                            <td class="p-3 text-gray-600">
                                {{ $category->description ?? '—' }}
                            </td>

                            <td class="p-3">
                                <span class="px-3 py-1 text-sm rounded bg-gray-100">
                                    {{ $category->skills_count }} Skills
                                </span>
                            </td>

                            <td class="p-3 flex gap-4">

                                {{-- EDIT BUTTON --}}
                                <button onclick='openEditCategoryModal(@json($category))'
                                    class="text-blue-600 font-medium">
                                    Edit
                                </button>

                                {{-- DELETE BUTTON --}}
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                    onsubmit="return confirm('Delete this category?')">
                                    @csrf @method('DELETE')

                                    <button class="text-red-600 font-medium">Delete</button>
                                </form>

                            </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

    </div>


    {{-- EDIT CATEGORY MODAL --}}
    <div id="editCategoryModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center p-4">

        <div class="bg-white w-full max-w-lg p-6 rounded-lg shadow-lg">

            <h2 class="text-xl font-bold text-green-600 mb-4">Edit Category</h2>

            <form id="editCategoryForm" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="text-sm font-medium">Category Name</label>
                    <input id="editCategoryName" type="text" name="name" class="w-full border rounded p-2 mt-1">
                </div>

                <div class="mb-3">
                    <label class="text-sm font-medium">Description</label>
                    <textarea id="editCategoryDescription" name="description" class="w-full border rounded p-2 mt-1" rows="2"></textarea>
                </div>

                <div class="flex justify-end gap-4 mt-4">

                    <button type="button" onclick="closeEditCategoryModal()" class="px-4 py-2 bg-gray-200 rounded-md">
                        Cancel
                    </button>

                    <button class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-opacity-90">
                        Save Changes
                    </button>

                </div>

            </form>

        </div>
    </div>



    <script>
        function openEditCategoryModal(category) {
            document.getElementById('editCategoryModal').classList.remove('hidden');

            document.getElementById('editCategoryName').value = category.name;
            document.getElementById('editCategoryDescription').value = category.description || '';

            document.getElementById('editCategoryForm').action =
                `/admin/categories/${category.id}`;
        }

        function closeEditCategoryModal() {
            document.getElementById('editCategoryModal').classList.add('hidden');
        }
    </script>





@endsection
