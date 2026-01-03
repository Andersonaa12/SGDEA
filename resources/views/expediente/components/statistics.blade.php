<div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
    <div class="flex flex-wrap -mx-3 lg:-mx-6">
        
        <div class="w-full sm:w-1/2 lg:w-1/4 px-3 lg:px-6 mb-6">
            <div class="group bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden 
                        h-full transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:-translate-y-2 cursor-pointer">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-500  tracking-wider">Total Expedientes</p>
                            <p class="text-xl font-extrabold text-indigo-600 mt-3">{{ $total_expedientes ?? '1.248' }}</p>
                        </div>
                        <div class="p-4 bg-indigo-100 rounded-xl group-hover:bg-indigo-200 transition-colors">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 017-2h6a2 2 0 012 2v2" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full sm:w-1/2 lg:w-1/4 px-3 lg:px-6 mb-6">
            <div class="group bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden 
                        h-full transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:-translate-y-2 cursor-pointer">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-500 tracking-wider">En Gestión</p>
                            <p class="text-xl font-extrabold text-indigo-600 mt-3">{{ $in_management ?? '1.248' }}</p>
                        </div>
                        <div class="p-4 bg-indigo-100 rounded-xl group-hover:bg-indigo-200 transition-colors">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                     d="M6 6.878V6a2.25 2.25 0 0 1 2.25-2.25h7.5A2.25 2.25 0 0 1 18 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 0 0 4.5 9v.878m13.5-3A2.25 2.25 0 0 1 19.5 9v.878m0 0a2.246 2.246 0 0 0-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0 1 21 12v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6c0-.98.626-1.813 1.5-2.122" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full sm:w-1/2 lg:w-1/4 px-3 lg:px-6 mb-6">
            <div class="group bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden 
                        h-full transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:-translate-y-2 cursor-pointer">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-500 tracking-wider">Archivo Central</p>
                            <p class="text-xl font-extrabold text-indigo-600 mt-3">{{ $in_central ?? '1.248' }}</p>
                        </div>
                        <div class="p-4 bg-indigo-100 rounded-xl group-hover:bg-indigo-200 transition-colors">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                            </svg>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="w-full sm:w-1/2 lg:w-1/4 px-3 lg:px-6 mb-6">
            <div class="group bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden 
                        h-full transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:-translate-y-2 cursor-pointer">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-500 tracking-wider">Histórico</p>
                            <p class="text-xl font-extrabold text-indigo-600 mt-3">{{ $in_historical ?? '1.248' }}</p>
                        </div>
                        <div class="p-4 bg-indigo-100 rounded-xl group-hover:bg-indigo-200 transition-colors">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        
        <!-- Repite el mismo bloque para las otras 3 tarjetas con sus colores -->
        <!-- Solo cambia: sm:w-1/2 lg:w-1/4, color, título, valor e icono -->
    </div>
</div>