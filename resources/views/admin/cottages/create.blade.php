<x-admin-layout>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="font-serif text-3xl font-bold text-slate-900">Add New Cottage</h1>
            <p class="mt-1 text-slate-500">Create a new luxury accommodation for your guests.</p>
        </div>
        <a href="{{ route('admin.cottages.index') }}" class="flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
            Back to List
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 bg-slate-50/50 px-8 py-4">
                    <h2 class="font-semibold text-slate-800">Cottage Details</h2>
                </div>
                <div class="p-8">
                    <form action="{{ route('admin.cottages.store') }}" method="POST" enctype="multipart/form-data" id="cottageForm" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div class="space-y-1.5">
                                <label for="name" class="text-sm font-semibold text-slate-700">Cottage Name</label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                        <i class="fa-solid fa-house-chimney text-xs"></i>
                                    </div>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                        class="block w-full rounded-xl border-slate-200 pl-10 text-sm focus:border-blue-500 focus:ring-blue-500 transition-all" 
                                        required placeholder="e.g. Ocean Deluxe #1">
                                </div>
                                @error('name') <p class="text-xs font-medium text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <!-- Capacity -->
                            <div class="space-y-1.5">
                                <label for="capacity" class="text-sm font-semibold text-slate-700">Max Capacity (Persons)</label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                        <i class="fa-solid fa-users text-xs"></i>
                                    </div>
                                    <input type="number" name="capacity" id="capacity" value="{{ old('capacity') }}" min="1" 
                                        class="block w-full rounded-xl border-slate-200 pl-10 text-sm focus:border-blue-500 focus:ring-blue-500 transition-all" 
                                        required>
                                </div>
                                @error('capacity') <p class="text-xs font-medium text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <!-- Price -->
                            <div class="space-y-1.5">
                                <label for="price" class="text-sm font-semibold text-slate-700">Price per Night</label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                        <span class="text-xs font-bold">₱</span>
                                    </div>
                                    <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}" min="0" 
                                        class="block w-full rounded-xl border-slate-200 pl-10 text-sm focus:border-blue-500 focus:ring-blue-500 transition-all" 
                                        required placeholder="0.00">
                                </div>
                                @error('price') <p class="text-xs font-medium text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <!-- Status -->
                            <div class="space-y-1.5">
                                <label for="status" class="text-sm font-semibold text-slate-700">Initial Status</label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                        <i class="fa-solid fa-circle-check text-xs"></i>
                                    </div>
                                    <select name="status" id="status" class="block w-full rounded-xl border-slate-200 pl-10 text-sm focus:border-blue-500 focus:ring-blue-500 transition-all">
                                        <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                                        <option value="booked" {{ old('status') == 'booked' ? 'selected' : '' }}>Booked</option>
                                        <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                    </select>
                                </div>
                                @error('status') <p class="text-xs font-medium text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="space-y-1.5">
                            <label for="description" class="text-sm font-semibold text-slate-700">Detailed Description</label>
                            <textarea name="description" id="description" rows="5" 
                                class="block w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500 transition-all" 
                                required placeholder="Describe the cottage amenities, views, and unique features...">{{ old('description') }}</textarea>
                            @error('description') <p class="text-xs font-medium text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <!-- Image Upload Area -->
                        <div class="space-y-1.5">
                            <label class="text-sm font-semibold text-slate-700">Cottage Gallery</label>
                            <div id="dropzone" class="relative group cursor-pointer overflow-hidden rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50/50 p-12 transition-all hover:border-blue-400 hover:bg-blue-50/30">
                                <input type="file" name="images[]" id="images" class="absolute inset-0 z-10 cursor-pointer opacity-0" multiple accept="image/*">
                                <div class="text-center">
                                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-white shadow-sm transition-transform group-hover:scale-110">
                                        <i class="fa-solid fa-cloud-arrow-up text-2xl text-blue-500"></i>
                                    </div>
                                    <h3 class="text-base font-semibold text-slate-900">Click to upload or drag and drop</h3>
                                    <p class="mt-1 text-sm text-slate-500">PNG, JPG or JPEG (Max. 2MB per file)</p>
                                    <div id="file-count" class="mt-4 hidden text-sm font-medium text-blue-600">
                                        <span id="count">0</span> files selected
                                    </div>
                                </div>
                            </div>
                            @error('images.*') <p class="text-xs font-medium text-red-500 mt-2">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-4">
                            <a href="{{ route('admin.cottages.index') }}" 
                                class="rounded-xl px-6 py-2.5 text-sm font-semibold text-slate-600 transition-all hover:bg-slate-100">
                                Cancel
                            </a>
                            <button type="submit" 
                                class="rounded-xl bg-slate-900 px-8 py-2.5 text-sm font-bold text-white shadow-lg shadow-slate-900/20 transition-all hover:bg-slate-800 active:scale-[0.98]">
                                Create Cottage
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Information Card -->
            <div class="rounded-2xl border border-blue-100 bg-blue-50/50 p-6">
                <div class="mb-4 flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 text-blue-600">
                    <i class="fa-solid fa-circle-info"></i>
                </div>
                <h3 class="mb-2 font-bold text-blue-900">Important Note</h3>
                <p class="text-sm leading-relaxed text-blue-800/80">
                    Ensure all images are of high quality (at least 1200x800px) to maintain the premium feel of the public website. The first image uploaded will be used as the primary cover photo.
                </p>
            </div>

            <!-- Preview Card (Mockup) -->
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="mb-4 font-bold text-slate-900 text-sm uppercase tracking-wider">Quick Preview</h3>
                <div class="overflow-hidden rounded-xl border border-slate-100">
                    <div class="aspect-video bg-slate-100 flex items-center justify-center text-slate-400">
                        <i class="fa-regular fa-image text-3xl"></i>
                    </div>
                    <div class="p-4">
                        <div class="h-4 w-2/3 rounded-full bg-slate-100 mb-2"></div>
                        <div class="h-3 w-full rounded-full bg-slate-50 mb-1"></div>
                        <div class="h-3 w-1/2 rounded-full bg-slate-50"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('images').addEventListener('change', function(e) {
            const count = e.target.files.length;
            const countDisplay = document.getElementById('file-count');
            const countText = document.getElementById('count');
            
            if (count > 0) {
                countDisplay.classList.remove('hidden');
                countText.textContent = count;
            } else {
                countDisplay.classList.add('hidden');
            }
        });
    </script>
    @endpush
</x-admin-layout>
