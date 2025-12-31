<x-app-layout>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <x-slot name="header">
        <div class="flex items-center gap-6">
            <div class="flex-shrink-0">
                <div class="p-3 bg-indigo-100 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-10 h-10 text-indigo-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6a2.25 2.25 0 0 0 2.227 1.932H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h3.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 0 1.06.44H18A2.25 2.25 0 0 1 20.25 9v.776" />
                    </svg>
                </div>
            </div>
            <div class="flex flex-col">
                <h2 class="text-3xl font-extrabold text-gray-900">
                    Expedientes Documentales
                </h2>
                <nav class="flex text-sm text-gray-500 mt-1">
                    <span class="text-indigo-600 font-semibold">Expedientes</span>
                </nav>
            </div>
        </div>
    </x-slot>
    @include('expediente.components.tabs')
    @include('expediente.components.statistics')
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
                <div class="p-8">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-10">
                        <h3 class="text-2xl font-bold text-gray-900">
                            Listado de Expedientes ({{ $expedientes->total() }})
                        </h3>
                        <a href="{{ route('expedientes.create') }}"
                           class="inline-flex items-center gap-3 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-md transition-all duration-200 hover:shadow-lg hover:-translate-y-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                 stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Nuevo Expediente
                        </a>
                    </div>
                    <!-- Búsqueda -->
                   <form id="search-form" class="mb-10 bg-gradient-to-r from-indigo-50 to-blue-50 p-6 rounded-2xl border border-indigo-200 shadow-sm">
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Número, asunto, detalle, metadatos, OCR..."
                                class="col-span-1 md:col-span-2 px-5 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-200 focus:border-indigo-500 transition-shadow">
                            <select name="phase"
                                    class="col-span-1 px-5 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-200 focus:border-indigo-500 transition-shadow">
                                <option value="">Todas las fases</option>
                                <option value="gestión" {{ request('phase') == 'gestión' ? 'selected' : '' }}>Gestión</option>
                                <option value="central" {{ request('phase') == 'central' ? 'selected' : '' }}>Central</option>
                                <option value="historico" {{ request('phase') == 'historico' ? 'selected' : '' }}>Histórico</option>
                            </select>
                            <select name="status"
                                    class="col-span-1 px-5 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-200 focus:border-indigo-500 transition-shadow">
                                <option value="">Todos los estados</option>
                                <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Abierto</option>
                                <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Cerrado</option>
                            </select>
                            <div class="col-span-1 flex justify-end items-center">
                                <button type="submit"
                                        class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl shadow-md transition-all duration-200 hover:shadow-lg hover:-translate-y-0.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                    </svg>
                                    Buscar
                                </button>
                            </div>
                        </div>
                    </form>
                    <div id="expedientes-list" class="grid grid-cols-1 gap-6">
                    </div>
                    <div id="pagination" class="mt-10">
                    </div>
                    <div class="grid grid-cols-1 gap-6">
                        @forelse($expedientes as $exp)
                            <div class="bg-white border border-gray-200 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                                <div class="p-8 relative">
                                    <!-- Acciones rápidas -->
                                    <div class="absolute top-6 right-6 flex gap-3">
                                        <a href="{{ route('expedientes.show', $exp) }}"
                                           class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl shadow transition-all duration-200 hover:shadow-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                            </svg>
                                            Gestionar
                                        </a>

                                        @if($exp->status == 'open')
                                            <form action="{{ route('expedientes.close', $exp) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="close-expediente-btn inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-xl shadow transition-all duration-200 hover:shadow-md cursor-pointer">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                         stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                                    </svg>
                                                    Cerrar
                                                </button>
                                            </form>
                                        @endif
                                    </div>

                                    <div class="flex items-start gap-6">
                                        <div class="flex-shrink-0">
                                            <div class="p-4 bg-indigo-100 rounded-2xl">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                     stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-indigo-600">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6a2.25 2.25 0 0 0 2.227 1.932H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h3.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 0 1.06.44H18A2.25 2.25 0 0 1 20.25 9v.776" />
                                                </svg>
                                            </div>
                                        </div>

                                        <div class="flex-grow">
                                            <h4 class="text-2xl font-extrabold text-indigo-700">{{ $exp->number }}</h4>
                                            <p class="text-gray-600 mt-1 text-base leading-relaxed">
                                                {{ Str::limit($exp->subject, 80) }}
                                            </p>
                                            <p class="text-gray-400 mt-1 text-base leading-relaxed">
                                                {{ Str::limit($exp->detail, 80) }}
                                            </p>

                                            <div class="mt-5 flex flex-wrap gap-3">
                                                <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-bold tracking-wide
                                                    {{ $exp->phase->code == 'MGMT' ? 'bg-amber-100 text-amber-800 border border-amber-200' : 
                                                       ($exp->phase->code == 'CENT' ? 'bg-indigo-100 text-indigo-800 border border-indigo-200' : 'bg-purple-100 text-purple-800 border border-purple-200') }}">
                                                    {{ ucfirst($exp->phase->name) }}
                                                </span>
                                                
                                                <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-bold tracking-wide
                                                    {{ $exp->status == 'open' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-red-100 text-red-800 border border-red-200' }}">
                                                    {{ $exp->status == 'open' ? 'Abierto' : 'Cerrado' }}
                                                </span>
                                                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold tracking-wide bg-gray-100 text-gray-800 border border-gray-300">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                         stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6" />
                                                    </svg>
                                                    Documentos: {{ $exp->documents->count() }}
                                                </span>
                                                @if($exp->supportType)
                                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-bold tracking-wide bg-orange-100 text-orange-800 border border-orange-200">
                                                        {{ $exp->supportType->name }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Eliminar -->
                                    <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end">
                                        <a href="{{ route('expedientes.history', $exp) }}"
                                           class="delete-expediente-btn text-green-600 hover:text-green-800 font-medium text-sm flex items-center gap-2 transition-colors cursor-pointer px-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                     stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                     d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                            </svg>
                                            Historial
                                        </a>
                                        <form action="{{ route('expedientes.destroy', $exp) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="delete-expediente-btn text-red-600 hover:text-red-800 font-medium text-sm flex items-center gap-2 transition-colors cursor-pointer">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                     stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                         d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                                Eliminar expediente
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-20">
                                <svg class="w-24 h-24 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                                          d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-2xl font-medium text-gray-500">No se encontraron expedientes</p>
                                <p class="text-gray-400 mt-2">Intenta ajustar los filtros o crea uno nuevo.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-10">
                        {{ $expedientes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                
                searchForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    performSearch();
                });
                performSearch();
                document.addEventListener('click', function (e) {
                    const closeBtn = e.target.closest('.close-expediente-btn');
                    if (closeBtn) {
                        e.preventDefault();
                        const url = closeBtn.dataset.url;
                        Swal.fire({
                            title: '¿Cerrar este expediente?',
                            text: 'El expediente pasará a estado cerrado. Esta acción se puede revertir si es necesario.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#dc2626',
                            cancelButtonColor: '#6b7280',
                            confirmButtonText: 'Sí, cerrar',
                            cancelButtonText: 'Cancelar',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                fetch(url, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': csrf,
                                    },
                                    body: JSON.stringify({ _method: 'PATCH' }),
                                }).then(res => {
                                    if (res.ok) {
                                        performSearch(); // Refrescar lista
                                        Swal.fire('¡Expediente cerrado!', '', 'success');
                                    } else {
                                        Swal.fire('Error', 'No se pudo cerrar el expediente.', 'error');
                                    }
                                }).catch(() => {
                                    Swal.fire('Error', 'Ocurrió un error en la solicitud.', 'error');
                                });
                            }
                        });
                    }
                    const deleteBtn = e.target.closest('.delete-expediente-btn');
                    if (deleteBtn) {
                        e.preventDefault();
                        const url = deleteBtn.dataset.url;
                        Swal.fire({
                            title: '¿Eliminar expediente permanentemente?',
                            text: 'Se eliminará el expediente y TODOS sus documentos asociados. ¡Esta acción NO se puede deshacer!',
                            icon: 'error',
                            showCancelButton: true,
                            confirmButtonColor: '#dc2626',
                            cancelButtonColor: '#6b7280',
                            confirmButtonText: 'Sí, eliminar permanentemente',
                            cancelButtonText: 'Cancelar',
                            reverseButtons: true,
                            width: '32rem'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire({
                                    title: 'Eliminando...',
                                    text: 'Por favor espera',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    didOpen: () => {
                                        Swal.showLoading();
                                    }
                                });
                                fetch(url, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': csrf,
                                    },
                                    body: JSON.stringify({ _method: 'DELETE' }),
                                }).then(res => {
                                    if (res.ok) {
                                        performSearch(); // Refrescar lista
                                        Swal.fire('¡Expediente eliminado!', '', 'success');
                                    } else {
                                        Swal.fire('Error', 'No se pudo eliminar el expediente.', 'error');
                                    }
                                }).catch(() => {
                                    Swal.fire('Error', 'Ocurrió un error en la solicitud.', 'error');
                                });
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>