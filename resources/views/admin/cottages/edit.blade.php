<x-admin-layout>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="font-serif text-3xl font-bold text-slate-900">Edit Cottage</h1>
            <p class="mt-1 text-slate-500">Update details for <span class="font-semibold text-slate-700">{{ $cottage->name }}</span>.</p>
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
                    <form action="{{ route('admin.cottages.update', $cottage) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PATCH')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div class="space-y-1.5">
                                <label for="name" class="text-sm font-semibold text-slate-700">Cottage Name</label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                        <i class="fa-solid fa-house-chimney text-xs"></i>
                                    </div>
                                    <input type="text" name="name" id="name" value="{{ old('name', $cottage->name) }}" 
                                        class="block w-full rounded-xl border-slate-200 pl-10 text-sm focus:border-blue-500 focus:ring-blue-500 transition-all" 
                                        required>
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
                                    <input type="number" name="capacity" id="capacity" value="{{ old('capacity', $cottage->capacity) }}" min="1" 
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
                                    <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $cottage->price) }}" min="0" 
                                        class="block w-full rounded-xl border-slate-200 pl-10 text-sm focus:border-blue-500 focus:ring-blue-500 transition-all" 
                                        required>
                                </div>
                                @error('price') <p class="text-xs font-medium text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <!-- Status -->
                            <div class="space-y-1.5">
                                <label for="status" class="text-sm font-semibold text-slate-700">Status</label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                        <i class="fa-solid fa-circle-check text-xs"></i>
                                    </div>
                                    <select name="status" id="status" class="block w-full rounded-xl border-slate-200 pl-10 text-sm focus:border-blue-500 focus:ring-blue-500 transition-all">
                                        <option value="available" {{ old('status', $cottage->status) == 'available' ? 'selected' : '' }}>Available</option>
                                        <option value="booked" {{ old('status', $cottage->status) == 'booked' ? 'selected' : '' }}>Booked</option>
                                        <option value="maintenance" {{ old('status', $cottage->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
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
                                required>{{ old('description', $cottage->description) }}</textarea>
                            @error('description') <p class="text-xs font-medium text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <!-- Image Upload Area -->
                        <div class="space-y-1.5">
                            <label class="text-sm font-semibold text-slate-700">Add More Images</label>
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
                                Update Cottage
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Current Gallery -->
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="mb-4 font-bold text-slate-900 text-sm uppercase tracking-wider">Current Gallery</h3>
                @if($cottage->images->count() > 0)
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($cottage->images as $image)
                            <div class="group relative overflow-hidden rounded-xl bg-slate-100">
                                <img src="{{ Storage::url($image->image_path) }}" class="h-24 w-full object-cover transition-transform group-hover:scale-110">
                                <div class="absolute inset-0 flex items-center justify-center gap-2 bg-black/40 opacity-0 transition-opacity group-hover:opacity-100">
                                    <a href="{{ Storage::url($image->image_path) }}" class="glightbox h-8 w-8 flex items-center justify-center rounded-full bg-white/20 text-white backdrop-blur-md hover:bg-white/40 transition-all">
                                        <i class="fa-solid fa-expand text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.cottages.images.archive', $image) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="h-8 w-8 flex items-center justify-center rounded-full bg-rose-500/80 text-white backdrop-blur-md hover:bg-rose-600 transition-all" title="Archive Image">
                                            <i class="fa-solid fa-box-archive text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-8 text-slate-400">
                        <i class="fa-regular fa-image text-3xl mb-2"></i>
                        <p class="text-xs">No images uploaded yet</p>
                    </div>
                @endif
            </div>

            <!-- Archived Photos -->
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="mb-4 font-bold text-slate-900 text-sm uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-box-archive text-slate-500"></i>
                    Archived Photos
                    @if($archivedImages->count() > 0)
                        <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-bold text-slate-600">{{ $archivedImages->count() }}</span>
                    @endif
                </h3>
                @if($archivedImages->count() > 0)
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($archivedImages as $image)
                            <div class="group relative overflow-hidden rounded-xl bg-slate-100 grayscale hover:grayscale-0 transition-all duration-300">
                                <img src="{{ Storage::url($image->image_path) }}" class="h-24 w-full object-cover">
                                <div class="absolute inset-0 flex items-center justify-center gap-2 bg-black/50 opacity-0 transition-opacity group-hover:opacity-100">
                                    <form action="{{ route('admin.cottages.images.restore', $image->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="h-8 w-8 flex items-center justify-center rounded-full bg-emerald-500/95 text-white backdrop-blur-md hover:bg-emerald-600 transition-all" title="Restore Image">
                                            <i class="fa-solid fa-rotate-left text-xs"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.cottages.images.purge', $image->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to permanently delete this photo? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="h-8 w-8 flex items-center justify-center rounded-full bg-rose-500/95 text-white backdrop-blur-md hover:bg-rose-600 transition-all" title="Permanently Delete">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-8 text-slate-400">
                        <i class="fa-solid fa-box-archive text-3xl mb-2 text-slate-300"></i>
                        <p class="text-xs">No archived photos</p>
                    </div>
                @endif
            </div>

            <!-- Stats Card -->
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="mb-4 font-bold text-slate-900 text-sm uppercase tracking-wider">Quick Stats</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-50 pb-2">
                        <span class="text-sm text-slate-500">Total Bookings</span>
                        <span class="text-sm font-bold text-slate-900">{{ $cottage->bookings_count ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between border-b border-slate-50 pb-2">
                        <span class="text-sm text-slate-500">Status</span>
                        @if($cottage->status === 'available')
                            <span class="rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-bold text-emerald-600">Available</span>
                        @elseif($cottage->status === 'booked')
                            <span class="rounded-full bg-amber-50 px-2 py-0.5 text-xs font-bold text-amber-600">Booked</span>
                        @else
                            <span class="rounded-full bg-rose-50 px-2 py-0.5 text-xs font-bold text-rose-600">Maintenance</span>
                        @endif
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
