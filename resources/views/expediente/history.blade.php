{{-- resources/views/expediente/history.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-6">
            <div class="flex-shrink-0">
                <div class="p-3 bg-indigo-100 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-10 h-10 text-indigo-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <div class="flex flex-col">
                <h2 class="text-3xl font-extrabold text-gray-900">
                    Historial del Expediente
                </h2>
                <nav class="flex text-sm text-gray-500 mt-1">
                    <a href="{{ route('expedientes.index') }}" class="hover:text-indigo-600">Expedientes</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('expedientes.show', $expediente) }}" class="hover:text-indigo-600">
                        {{ $expediente->number }}
                    </a>
                    <span class="mx-2">/</span>
                    <span class="text-indigo-600 font-semibold">Historial</span>
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
                <div class="px-8 py-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Historial: {{ $expediente->number }} - {{ $expediente->subject }}
                        </h1>
                        <p class="text-sm text-gray-500 mt-1">
                            Registro completo de acciones y cambios en el expediente
                        </p>
                    </div>
                    <a href="{{ route('expedientes.show', $expediente) }}"
                       class="inline-flex items-center gap-3 px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-xl shadow-md transition-all duration-200 hover:shadow-lg hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                             stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                        Volver al expediente
                    </a>
                </div>

                <div class="p-8">
                    @if($timeline->isEmpty())
                        <div class="text-center py-20 bg-gray-50 rounded-2xl">
                            <svg class="w-24 h-24 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-2xl font-medium text-gray-500">No hay registros en el historial</p>
                            <p class="text-gray-400 mt-2">Aún no se han realizado acciones en este expediente.</p>
                        </div>
                    @else
                        <div class="flow-root">
                            <ul role="list" class="-mb-8">
                                @foreach($timeline as $item)
                                    <li>
                                        <div class="relative pb-10">
                                            @if(!$loop->last)
                                                <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200"
                                                      aria-hidden="true"></span>
                                            @endif
                                            <div class="relative flex space-x-6">
                                                <!-- Ícono según tipo -->
                                                <div class="flex-shrink-0">
                                                    <div class="h-10 w-10 rounded-full flex items-center justify-center ring-8 ring-white shadow-lg
                                                        {{ $item['type'] === 'manual' ? 'bg-emerald-600' : 'bg-indigo-600' }}">
                                                        @if($item['type'] === 'manual')
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                                 stroke-width="2" stroke="currentColor" class="w-6 h-6 text-white">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                      d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                            </svg>
                                                        @else
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                                 stroke-width="2" stroke="currentColor" class="w-6 h-6 text-white">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                      d="M16.862 4.487l1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                                            </svg>
                                                        @endif
                                                    </div>
                                                </div>

                                                <!-- Contenido del evento -->
                                                <div class="flex-1 min-w-0 bg-gray-50 rounded-2xl p-6 shadow-sm border border-gray-200">
                                                    <div class="flex items-start justify-between">
                                                        <div>
                                                            <p class="text-lg font-semibold text-gray-900">
                                                                {{ $item['description'] }}
                                                            </p>
                                                            <div class="mt-2 flex items-center gap-4 text-sm text-gray-500">
                                                                <span class="flex items-center gap-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                                         stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                              d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                                    </svg>
                                                                    {{ $item['user']?->name ?? 'Sistema' }}
                                                                </span>
                                                                <span class="flex items-center gap-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                                         stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                              d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                                    </svg>
                                                                    {{ $item['date']->format('d/m/Y H:i') }}
                                                                </span>
                                                                <span class="px-3 py-1 rounded-full text-xs font-bold
                                                                    {{ $item['type'] === 'manual' ? 'bg-emerald-100 text-emerald-800' : 'bg-indigo-100 text-indigo-800' }}">
                                                                    {{ $item['type'] === 'manual' ? 'Manual' : 'Auditoría' }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Detalles de cambios (solo para auditoría) -->
                                                    @if($item['type'] === 'audit' && (!empty($item['old_values']) || !empty($item['new_values'])))
                                                        <details class="mt-4">
                                                            <summary class="cursor-pointer text-indigo-600 hover:text-indigo-800 font-medium text-sm flex items-center gap-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                                     stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                          d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                                </svg>
                                                                Ver detalles de cambios
                                                            </summary>
                                                            <div class="mt-3 pl-6 border-l-4 border-indigo-200 bg-white rounded-r-xl p-4 text-sm text-gray-700">
                                                                @if(!empty($item['old_values']))
                                                                    <div class="mb-4">
                                                                        <p class="font-bold text-red-700 mb-2">Valores anteriores:</p>
                                                                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                                            @foreach($item['old_values'] as $key => $value)
                                                                                <div class="bg-red-50 p-3 rounded-lg">
                                                                                    <dt class="font-medium text-gray-600">{{ ucfirst(str_replace('_', ' ', $key)) }}</dt>
                                                                                    <dd class="mt-1 text-gray-900">
                                                                                        @if(is_array($value))
                                                                                            {{ json_encode($value, JSON_UNESCAPED_UNICODE) }}
                                                                                        @else
                                                                                            {{ $value ?: '—' }}
                                                                                        @endif
                                                                                    </dd>
                                                                                </div>
                                                                            @endforeach
                                                                        </dl>
                                                                    </div>
                                                                @endif
                                                                @if(!empty($item['new_values']))
                                                                    <div>
                                                                        <p class="font-bold text-green-700 mb-2">Valores nuevos:</p>
                                                                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                                            @foreach($item['new_values'] as $key => $value)
                                                                                <div class="bg-green-50 p-3 rounded-lg">
                                                                                    <dt class="font-medium text-gray-600">{{ ucfirst(str_replace('_', ' ', $key)) }}</dt>
                                                                                    <dd class="mt-1 text-gray-900">
                                                                                        @if(is_array($value))
                                                                                            {{ json_encode($value, JSON_UNESCAPED_UNICODE) }}
                                                                                        @else
                                                                                            {{ $value ?: '—' }}
                                                                                        @endif
                                                                                    </dd>
                                                                                </div>
                                                                            @endforeach
                                                                        </dl>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </details>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>