<aside x-data="{ open: true }" 
       class="bg-white border-r border-gray-200 flex flex-col transition-all duration-300 ease-in-out shadow-lg fixed inset-y-0 left-0 z-50 overflow-hidden" 
       :class="{ 'w-74': open, 'w-30': !open }">

    <!-- Logo + Toggle -->
    <div class="flex items-center justify-between p-4 border-b border-gray-200 bg-gradient-to-r from-indigo-50 to-white">
        <a href="{{ route('dashboard') }}" class="flex items-center">
            <x-application-logo class="block h-9 w-auto fill-current text-indigo-600" />
            <span x-show="open" class="ml-3 text-xl font-bold text-indigo-700 tracking-tight">{{ __('SGDA') }}</span>
        </a>
        <button @click="open = !open" class="p-2 rounded-full hover:bg-indigo-100 text-gray-600 hover:text-indigo-700 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>

    <!-- Menú -->
    <nav class="flex-1 overflow-y-auto py-4 px-2 space-y-1">
        <!-- Inicio -->
        <div class="group relative">
            <a href="{{ route('dashboard') }}" 
               class="relative flex items-center rounded-lg px-4 py-3 text-sm font-medium transition-all duration-200"
               :class="{ 
                   'justify-start': open, 
                   'justify-center': !open, 
                   'bg-indigo-100 text-indigo-700 shadow-sm ring-1 ring-indigo-200': request()->routeIs('dashboard'),
                   'text-gray-600 hover:bg-gray-100 hover:text-gray-900': !request()->routeIs('dashboard')
               }">
                <svg class="h-5 w-5 flex-shrink-0 transition-colors" 
                     :class="{ 'mr-3': open, 'text-indigo-700': request()->routeIs('dashboard'), 'text-gray-500 group-hover:text-gray-700': !request()->routeIs('dashboard') }" 
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-3a1 1 0 011-1h2a1 1 0 011 1v3a1 1 0 01-1 1m-4 0h4" />
                </svg>
                <span x-show="open" class="transition-colors ml-3" :class="{ 'text-indigo-700 font-semibold': request()->routeIs('dashboard') }">{{ __('Inicio') }}</span>
            </a>
            <div x-show="!open" class="absolute left-full ml-4 top-1/2 -translate-y-1/2 px-3 py-1.5 bg-gray-800 text-white text-xs font-medium rounded-md opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50 shadow-md ring-1 ring-gray-900/10">
                {{ __('Inicio') }}
            </div>
        </div>

        <!-- Expedientes -->
        <div class="group relative">
            <a href="{{ route('expedientes.index') }}" 
               class="relative flex items-center rounded-lg px-4 py-3 text-sm font-medium transition-all duration-200"
               :class="{ 
                   'justify-start': open, 
                   'justify-center': !open, 
                   'bg-indigo-100 text-indigo-700 shadow-sm ring-1 ring-indigo-200': request()->routeIs('expedientes.*'),
                   'text-gray-600 hover:bg-gray-100 hover:text-gray-900': !request()->routeIs('expedientes.*')
               }">
                <svg class="h-5 w-5 flex-shrink-0 transition-colors" 
                     :class="{ 'mr-3': open, 'text-indigo-700': request()->routeIs('expedientes.*'), 'text-gray-500 group-hover:text-gray-700': !request()->routeIs('expedientes.*') }" 
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" />
                </svg>
                <span x-show="open" class="transition-colors ml-3" :class="{ 'text-indigo-700 font-semibold': request()->routeIs('expedientes.*') }">{{ __('Expedientes') }}</span>
            </a>
            <div x-show="!open" class="absolute left-full ml-4 top-1/2 -translate-y-1/2 px-3 py-1.5 bg-gray-800 text-white text-xs font-medium rounded-md opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50 shadow-md ring-1 ring-gray-900/10">
                {{ __('Expedientes') }}
            </div>
        </div>

        <!-- Divider -->
        <div class="my-3 border-t border-gray-200 mx-4"></div>

        <!-- Tablas de Retención Documental -->
        <div x-data="{ submenuOpen: {{ (request()->is('trd/*') || request()->is('series*') || request()->is('subseries*') || request()->is('document-types*')) ? 'true' : 'false' }} }" class="group relative">
            <button @click="submenuOpen = !submenuOpen" 
                    class="w-full relative flex items-center rounded-lg px-4 py-3 text-sm font-medium transition-all duration-200"
                    :class="{ 
                        'justify-start': open, 
                        'justify-center': !open, 
                        'bg-indigo-100 text-indigo-700 shadow-sm ring-1 ring-indigo-200': request()->is('trd/*') || request()->is('series*') || request()->is('subseries*') || request()->is('document-types*'),
                        'text-gray-600 hover:bg-gray-100 hover:text-gray-900': !(request()->is('trd/*') || request()->is('series*') || request()->is('subseries*') || request()->is('document-types*'))
                    }">
                <svg class="h-5 w-5 flex-shrink-0 transition-colors" 
                     :class="{ 'mr-3': open, 'text-indigo-700': request()->is('trd/*') || request()->is('series*') || request()->is('subseries*') || request()->is('document-types*'), 'text-gray-500 group-hover:text-gray-700': !(request()->is('trd/*') || request()->is('series*') || request()->is('subseries*') || request()->is('document-types*')) }" 
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2m-6 4h6" />
                </svg>
                <span x-show="open" class="transition-colors ml-3" :class="{ 'text-indigo-700 font-semibold': request()->is('trd/*') || request()->is('series*') || request()->is('subseries*') || request()->is('document-types*') }">{{ __('Tablas de Retención Documental') }}</span>
                <svg x-show="open" class="ml-auto h-4 w-4 transition-all text-gray-500 group-hover:text-gray-700" 
                     :class="{ 'rotate-180 text-indigo-700': submenuOpen }" 
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="!open" class="absolute left-full ml-4 top-1/2 -translate-y-1/2 px-3 py-1.5 bg-gray-800 text-white text-xs font-medium rounded-md opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50 shadow-md ring-1 ring-gray-900/10">
                {{ __('Tablas de Retención Documental') }}
            </div>

            <div x-show="submenuOpen && open" x-transition class="mt-2 space-y-1 pl-8">
                <a href="{{ route('trds.index') }}" class="block px-4 py-2 text-xs font-medium rounded-md transition-all" :class="{ 'bg-indigo-50 text-indigo-700': request()->routeIs('trds.*'), 'text-gray-600 hover:bg-gray-50 hover:text-gray-900': !request()->routeIs('trds.*') }">{{ __('TRD') }}</a>
                <a href="{{ route('series.index') }}" class="block px-4 py-2 text-xs font-medium rounded-md transition-all" :class="{ 'bg-indigo-50 text-indigo-700': request()->routeIs('series.*'), 'text-gray-600 hover:bg-gray-50 hover:text-gray-900': !request()->routeIs('series.*') }">{{ __('Series') }}</a>
                <a href="{{ route('subseries.index') }}" class="block px-4 py-2 text-xs font-medium rounded-md transition-all" :class="{ 'bg-indigo-50 text-indigo-700': request()->routeIs('subseries.*'), 'text-gray-600 hover:bg-gray-50 hover:text-gray-900': !request()->routeIs('subseries.*') }">{{ __('Subseries') }}</a>
                <a href="{{ route('document-types.index') }}" class="block px-4 py-2 text-xs font-medium rounded-md transition-all" :class="{ 'bg-indigo-50 text-indigo-700': request()->routeIs('document-types.*'), 'text-gray-600 hover:bg-gray-50 hover:text-gray-900': !request()->routeIs('document-types.*') }">{{ __('Tipos de Documentos') }}</a>
            </div>
        </div>

        <!-- Divider -->
        <div class="my-3 border-t border-gray-200 mx-4"></div>

        <!-- Estructura Organizacional -->
        <div x-data="{ submenuOpen: {{ (request()->is('structure/*') || request()->is('sections*') || request()->is('subsections*') || request()->is('organizational-structures*')) ? 'true' : 'false' }} }" class="group relative">
            <button @click="submenuOpen = !submenuOpen" 
                    class="w-full relative flex items-center rounded-lg px-4 py-3 text-sm font-medium transition-all duration-200"
                    :class="{ 
                        'justify-start': open, 
                        'justify-center': !open, 
                        'bg-indigo-100 text-indigo-700 shadow-sm ring-1 ring-indigo-200': request()->is('structure/*') || request()->is('sections*') || request()->is('subsections*') || request()->is('organizational-structures*'),
                        'text-gray-600 hover:bg-gray-100 hover:text-gray-900': !(request()->is('structure/*') || request()->is('sections*') || request()->is('subsections*') || request()->is('organizational-structures*'))
                    }">
                <svg class="h-5 w-5 flex-shrink-0 transition-colors" 
                     :class="{ 'mr-3': open, 'text-indigo-700': request()->is('structure/*') || request()->is('sections*') || request()->is('subsections*') || request()->is('organizational-structures*'), 'text-gray-500 group-hover:text-gray-700': !(request()->is('structure/*') || request()->is('sections*') || request()->is('subsections*') || request()->is('organizational-structures*')) }" 
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7a2 2 0 012-2h14a2 2 0 012 2v3H3V7zM6 10h.01M17 10h.01M11 10h.01" />
                </svg>
                <span x-show="open" class="transition-colors ml-3" :class="{ 'text-indigo-700 font-semibold': request()->is('structure/*') || request()->is('sections*') || request()->is('subsections*') || request()->is('organizational-structures*') }">{{ __('Estructura Organizacional') }}</span>
                <svg x-show="open" class="ml-auto h-4 w-4 transition-all text-gray-500 group-hover:text-gray-700" 
                     :class="{ 'rotate-180 text-indigo-700': submenuOpen }" 
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="!open" class="absolute left-full ml-4 top-1/2 -translate-y-1/2 px-3 py-1.5 bg-gray-800 text-white text-xs font-medium rounded-md opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50 shadow-md ring-1 ring-gray-900/10">
                {{ __('Estructura Organizacional') }}
            </div>

            <div x-show="submenuOpen && open" x-transition class="mt-2 space-y-1 pl-8">
                <a href="{{ route('organizational-structures.index') }}" class="block px-4 py-2 text-xs font-medium rounded-md transition-all" :class="{ 'bg-indigo-50 text-indigo-700': request()->routeIs('organizational-structures.*'), 'text-gray-600 hover:bg-gray-50 hover:text-gray-900': !request()->routeIs('organizational-structures.*') }">{{ __('Estructura') }}</a>
                <a href="{{ route('sections.index') }}" class="block px-4 py-2 text-xs font-medium rounded-md transition-all" :class="{ 'bg-indigo-50 text-indigo-700': request()->routeIs('sections.*'), 'text-gray-600 hover:bg-gray-50 hover:text-gray-900': !request()->routeIs('sections.*') }">{{ __('Secciones') }}</a>
                <a href="{{ route('subsections.index') }}" class="block px-4 py-2 text-xs font-medium rounded-md transition-all" :class="{ 'bg-indigo-50 text-indigo-700': request()->routeIs('subsections.*'), 'text-gray-600 hover:bg-gray-50 hover:text-gray-900': !request()->routeIs('subsections.*') }">{{ __('Subsecciones') }}</a>
            </div>
        </div>

        <!-- Divider -->
        <div class="my-3 border-t border-gray-200 mx-4"></div>

        <!-- Administrar Usuarios -->
        <div x-data="{ submenuOpen: {{ request()->is('users/*') ? 'true' : 'false' }} }" class="group relative">
            <button @click="submenuOpen = !submenuOpen" 
                    class="w-full relative flex items-center rounded-lg px-4 py-3 text-sm font-medium transition-all duration-200"
                    :class="{ 
                        'justify-start': open, 
                        'justify-center': !open, 
                        'bg-indigo-100 text-indigo-700 shadow-sm ring-1 ring-indigo-200': request()->is('users/*'),
                        'text-gray-600 hover:bg-gray-100 hover:text-gray-900': !request()->is('users/*')
                    }">
                <svg class="h-5 w-5 flex-shrink-0 transition-colors" 
                     :class="{ 'mr-3': open, 'text-indigo-700': request()->is('users/*'), 'text-gray-500 group-hover:text-gray-700': !request()->is('users/*') }" 
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span x-show="open" class="transition-colors  ml-3" :class="{ 'text-indigo-700 font-semibold': request()->is('users/*') }">{{ __('Administrar Usuarios') }}</span>
                <svg x-show="open" class="ml-auto h-4 w-4 transition-all text-gray-500 group-hover:text-gray-700" 
                     :class="{ 'rotate-180 text-indigo-700': submenuOpen }" 
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="!open" class="absolute left-full ml-4 top-1/2 -translate-y-1/2 px-3 py-1.5 bg-gray-800 text-white text-xs font-medium rounded-md opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50 shadow-md ring-1 ring-gray-900/10">
                {{ __('Administrar Usuarios') }}
            </div>

            <div x-show="submenuOpen && open" x-transition class="mt-2 space-y-1 pl-8">
                <a href="{{ route('users.index') }}" class="block px-4 py-2 text-xs font-medium rounded-md transition-all" :class="{ 'bg-indigo-50 text-indigo-700': request()->routeIs('users.*'), 'text-gray-600 hover:bg-gray-50 hover:text-gray-900': !request()->routeIs('users.*') }">{{ __('Usuarios') }}</a>
                <a href="{{ route('users.roles.index') }}" class="block px-4 py-2 text-xs font-medium rounded-md transition-all" :class="{ 'bg-indigo-50 text-indigo-700': request()->routeIs('users.roles.*'), 'text-gray-600 hover:bg-gray-50 hover:text-gray-900': !request()->routeIs('users.roles.*') }">{{ __('Roles') }}</a>
                <a href="{{ route('users.permissions.index') }}" class="block px-4 py-2 text-xs font-medium rounded-md transition-all" :class="{ 'bg-indigo-50 text-indigo-700': request()->routeIs('users.permissions.*'), 'text-gray-600 hover:bg-gray-50 hover:text-gray-900': !request()->routeIs('users.permissions.*') }">{{ __('Permisos') }}</a>
            </div>
        </div>
    </nav>

    <!-- Perfil de usuario (fijo abajo) -->
    <div class="border-t border-gray-200 p-4 mt-auto bg-gradient-to-t from-gray-50 to-white">
        <div x-data="{ profileOpen: false }" class="relative group">
            <button @click="profileOpen = !profileOpen" 
                    class="w-full flex items-center rounded-lg p-2 transition-all duration-200 hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    :class="{ 'justify-start': open, 'justify-center': !open }">
                <img class="h-10 w-10 rounded-full flex-shrink-0 ring-2 ring-indigo-200 transition-all group-hover:ring-indigo-400" 
                     src="https://ui-avatars.com/api/?name={{ rawurlencode(Auth::user()->name) }}&color=4338CA&background=EEF2FF&bold=true" 
                     alt="{{ Auth::user()->name }}">
                <div x-show="open" class="ml-3 text-left flex-1">
                    <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                </div>
                <svg x-show="open" class="ml-auto h-4 w-4 text-gray-500 transition-transform group-hover:text-indigo-700" :class="{ 'rotate-180': profileOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- Tooltip nombre cuando colapsado -->
            <div x-show="!open" class="absolute left-full ml-4 top-1/2 -translate-y-1/2 px-3 py-1.5 bg-gray-800 text-white text-xs font-medium rounded-md opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50 shadow-md ring-1 ring-gray-900/10">
                {{ Auth::user()->name }}
            </div>

            <!-- Dropdown perfil -->
            <div x-show="profileOpen" x-transition class="absolute left-0 bottom-full mb-2 w-full bg-white rounded-lg shadow-xl border border-gray-200 overflow-hidden ring-1 ring-gray-900/5">
                <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
                    <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                </div>
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors">{{ __('Mi Perfil') }}</a>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors">{{ __('Cerrar Sesión') }}</button>
                </form>
            </div>
        </div>
    </div>
</aside>