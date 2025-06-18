<x-filament::widget>
    <x-filament::card class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <div class="text-lg font-semibold">Exporter toutes les données</div>
                <div class="text-sm text-gray-400 dark:text-gray-500">
                    Téléchargez un fichier CSV avec toutes les données du système.
                </div>
                <div class="flex justify-end mt-4">
                    <a href="{{ url('/admin/export/all') }}" target="_blank"
                        class="filament-button inline-flex items-center bg-warning-600 hover:bg-warning-700 text-white px-4 py-2 rounded-lg shadow">
                        <x-heroicon-o-arrow-down-tray class="w-5 h-5" />
                        &nbsp;
                        <span class="ml-2">Exporter CSV</span>
                    </a>
                </div>
            </div>
        </div>
    </x-filament::card>
            <div class="h-6"></div>
    <x-filament::card class="mt-6">
        @php

            $stats = [
                [
                    'label' => 'Réservations',
                    'value' => \App\Models\Reservation::count(),
                    'icon' => 'heroicon-o-calendar-days',
                    'color' => 'bg-indigo-500',
                ],
                [
                    'label' => 'Utilisateurs',
                    'value' => \App\Models\User::count(),
                    'icon' => 'heroicon-o-user-group',
                    'color' => 'bg-green-500',
                ],
                [
                    'label' => 'Spectacles',
                    'value' => \App\Models\Show::count(),
                    'icon' => 'heroicon-o-ticket',
                    'color' => 'bg-pink-500',
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
            @foreach ($stats as $stat)
                <div class="rounded-xl p-4 shadow flex items-center justify-between text-white {{ $stat['color'] }}">
                    <div>
                        <div class="text-sm opacity-80">{{ $stat['label'] }}</div>
                        <div class="text-2xl font-bold mt-1">{{ $stat['value'] }}</div>
                    </div>
                    <x-dynamic-component :component="$stat['icon']" class="w-8 h-8 opacity-80" />
                </div>
            @endforeach
        </div>        
    </x-filament::card>
</x-filament::widget>
