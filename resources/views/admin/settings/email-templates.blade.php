@extends('admin.settings.layout')

@section('settings_content')
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Email Templates</h2>
        <p class="text-sm text-gray-600 mb-6">Customize email templates that are sent to users for different events.</p>
        
        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Template Name</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Description</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Variables</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($templates as $key => $template)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ $template['name'] }}
                            </td>
                            <td class="px-3 py-4 text-sm text-gray-500">
                                {{ $template['description'] }}
                            </td>
                            <td class="px-3 py-4 text-sm text-gray-500">
                                @if(isset($template['variables']) && count($template['variables']) > 0)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($template['variables'] as $var)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                {{'{'.$var.'}'}}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-400">No variables</span>
                                @endif
                            </td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                <a href="{{ route('admin.settings.email-templates.edit', $key) }}" class="text-indigo-600 hover:text-indigo-900">
                                    Edit<span class="sr-only">, {{ $template['name'] }}</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-3 py-4 text-sm text-center text-gray-500">
                                No email templates available.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection 