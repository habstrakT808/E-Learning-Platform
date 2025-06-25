<tr>
    <td class="px-6 py-4 text-sm text-gray-900">
        <div class="flex items-center">
            @if($depth > 0)
                <div style="width: {{ $depth * 20 }}px;" class="flex-shrink-0"></div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-300 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
            @endif
            
            <div class="flex items-center">
                @if($category->icon)
                    <span class="mr-2 text-{{ substr($category->icon, 0, strpos($category->icon, ' ')) }}-500">
                        <i class="{{ $category->icon }}"></i>
                    </span>
                @else
                    <span class="mr-2 text-gray-500">
                        <i class="fas fa-folder"></i>
                    </span>
                @endif
                
                <span class="font-medium">{{ $category->name }}</span>
                
                @if($category->children->count() > 0)
                    <span class="ml-2 px-2 py-0.5 text-xs font-semibold rounded-full bg-gray-100 text-gray-700">
                        {{ $category->children->count() }} {{ Str::plural('subcategory', $category->children->count()) }}
                    </span>
                @endif
            </div>
        </div>
    </td>
    <td class="px-6 py-4 text-sm text-gray-500">
        {{ $category->slug }}
    </td>
    <td class="px-6 py-4 text-sm text-gray-500">
        {{ $category->courses_count }}
    </td>
    <td class="px-6 py-4 text-right text-sm font-medium">
        <div class="flex items-center justify-end space-x-3">
            <a href="{{ route('admin.categories.show', $category) }}" class="text-indigo-600 hover:text-indigo-900" title="View">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </a>
            <a href="{{ route('admin.categories.edit', $category) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </a>
            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure you want to delete this category? Child categories will be moved up one level.')" class="text-red-600 hover:text-red-900" title="Delete">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </form>
        </div>
    </td>
</tr>

@if($category->children->isNotEmpty())
    @foreach($category->children as $child)
        @include('admin.categories.partials._category_row', ['category' => $child, 'depth' => $depth + 1])
    @endforeach
@endif 