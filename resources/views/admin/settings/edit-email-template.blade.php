@extends('admin.settings.layout')

@section('settings_content')
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="mb-4 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold">Edit {{ $templateInfo['name'] }}</h2>
                <p class="text-sm text-gray-600 mt-1">{{ $templateInfo['description'] }}</p>
            </div>
            <a href="{{ route('admin.settings.email-templates') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="h-4 w-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Templates
            </a>
        </div>
        
        <form action="{{ route('admin.settings.email-templates.update', $template) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label for="subject" class="block text-sm font-medium text-gray-700">Email Subject</label>
                <div class="mt-1">
                    <input type="text" name="subject" id="subject" 
                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                           value="{{ old('subject', Setting::get($template . '_email_subject', 'Default Subject')) }}" required>
                </div>
                @error('subject')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700">Email Content</label>
                <div class="mt-1">
                    <textarea id="content" name="content" rows="20" 
                              class="tinymce-editor shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                              required>{{ old('content', $content) }}</textarea>
                </div>
                @error('content')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Available Variables</h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p>You can use these variables in your email template:</p>
                            <div class="mt-2 flex flex-wrap gap-2">
                                @foreach($templateInfo['variables'] as $var)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-yellow-100 text-yellow-800">
                                        {{'{'.$var.'}'}}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end">
                <a href="{{ route('admin.settings.email-templates') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2">
                    Cancel
                </a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save Template
                </button>
            </div>
        </form>
    </div>
@endsection

@push('settings_scripts')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea.tinymce-editor',
        height: 500,
        menubar: true,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount'
        ],
        toolbar: 'undo redo | formatselect | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help',
        setup: function (editor) {
            // Add button for each template variable
            editor.ui.registry.addMenuButton('variables', {
                text: 'Insert Variable',
                fetch: function (callback) {
                    var items = [
                        @foreach($templateInfo['variables'] as $var)
                            {
                                type: 'menuitem',
                                text: '{{$var}}',
                                onAction: function () {
                                    editor.insertContent('{{"{" . $var . "}"}}');
                                }
                            },
                        @endforeach
                    ];
                    callback(items);
                }
            });
        }
    });
</script>
@endpush 