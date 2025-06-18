<x-filament::page>
    <div class="space-y-4">
        <a href="{{ url('/admin/export/all') }}" target="_blank"
           class="filament-button inline-flex items-center space-x-2 bg-primary-600 text-white hover:bg-primary-700 px-4 py-2 rounded-lg shadow">
            <x-heroicon-o-arrow-down-tray class="w-5 h-5" />
            <span>Exporter tout (CSV)</span>
        </a>
    </div>
</x-filament::page>