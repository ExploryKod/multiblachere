@extends('statamic::layout')

@section('title', $title)

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold">{{ $title }}</h1>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('field-visibility.store') }}">
            @csrf
            
            <div class="p-6">
                <div class="mb-6">
                    <h2 class="text-xl font-semibold mb-4">Configure Field Visibility by Site</h2>
                    <p class="text-gray-600 mb-6">
                        Set up which fields should be hidden or shown for each site. This allows you to customize the control panel experience based on the active site.
                    </p>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Site Configurations
                        </label>
                        <div id="sites-container" class="space-y-4">
                            @if(empty($values))
                                <div class="site-config border rounded-lg p-4 bg-gray-50">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Site Handle</label>
                                            <input type="text" name="sites[0][site_handle]" 
                                                   placeholder="groupe_blachere" 
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Fields to Hide</label>
                                            <textarea name="sites[0][hidden_fields][]" 
                                                      placeholder="marie_blachere_builder" 
                                                      rows="3"
                                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Fields to Show</label>
                                            <textarea name="sites[0][visible_fields][]" 
                                                      placeholder="page_builder" 
                                                      rows="3"
                                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                        </div>
                                    </div>
                                    <button type="button" onclick="removeSiteConfig(this)" 
                                            class="mt-2 text-red-600 hover:text-red-800 text-sm">
                                        Remove Configuration
                                    </button>
                                </div>
                            @else
                                @foreach($values as $siteHandle => $config)
                                    <div class="site-config border rounded-lg p-4 bg-gray-50">
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Site Handle</label>
                                                <input type="text" name="sites[{{ $loop->index }}][site_handle]" 
                                                       value="{{ $siteHandle }}" 
                                                       placeholder="groupe_blachere" 
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Fields to Hide</label>
                                                <textarea name="sites[{{ $loop->index }}][hidden_fields][]" 
                                                          rows="3"
                                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">@foreach($config['hidden_fields'] ?? [] as $field){{ $field }}
@endforeach</textarea>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Fields to Show</label>
                                                <textarea name="sites[{{ $loop->index }}][visible_fields][]" 
                                                          rows="3"
                                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">@foreach($config['visible_fields'] ?? [] as $field){{ $field }}
@endforeach</textarea>
                                            </div>
                                        </div>
                                        <button type="button" onclick="removeSiteConfig(this)" 
                                                class="mt-2 text-red-600 hover:text-red-800 text-sm">
                                            Remove Configuration
                                        </button>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        
                        <button type="button" onclick="addSiteConfig()" 
                                class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Add Site Configuration
                        </button>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t flex justify-end space-x-3">
                <a href="{{ route('statamic.cp.dashboard') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Save Settings
                </button>
            </div>
        </form>
    </div>

    <script>
        let siteConfigIndex = {{ count($values ?? []) }};

        function addSiteConfig() {
            const container = document.getElementById('sites-container');
            const newConfig = document.createElement('div');
            newConfig.className = 'site-config border rounded-lg p-4 bg-gray-50';
            newConfig.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Site Handle</label>
                        <input type="text" name="sites[${siteConfigIndex}][site_handle]" 
                               placeholder="groupe_blachere" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fields to Hide</label>
                        <textarea name="sites[${siteConfigIndex}][hidden_fields][]" 
                                  placeholder="marie_blachere_builder" 
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fields to Show</label>
                        <textarea name="sites[${siteConfigIndex}][visible_fields][]" 
                                  placeholder="page_builder" 
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                </div>
                <button type="button" onclick="removeSiteConfig(this)" 
                        class="mt-2 text-red-600 hover:text-red-800 text-sm">
                    Remove Configuration
                </button>
            `;
            container.appendChild(newConfig);
            siteConfigIndex++;
        }

        function removeSiteConfig(button) {
            button.closest('.site-config').remove();
        }
    </script>
@endsection
