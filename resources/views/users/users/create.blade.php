<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-indigo-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-2xl text-gray-800">Crear Nuevo Usuario</h2>
                <nav class="flex text-sm text-gray-600 mt-1">
                    <a href="{{ route('users.index') }}" class="hover:text-indigo-600">Usuarios</a>
                    <span class="mx-2">/</span>
                    <span class="text-indigo-600 font-medium">Crear</span>
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="py-2">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 py-4">
            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <div class="p-8">
                    <form action="{{ route('users.store') }}" method="POST" class="space-y-8">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                            <!-- Columna Izquierda -->
                            <div class="space-y-6">
                                <div>
                                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Nombre <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="identification" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Identificación <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="identification" id="identification" value="{{ old('identification') }}" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                    @error('identification') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Teléfono</label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Contraseña <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" name="password" id="password" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Confirmar Contraseña <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                </div>
                            </div>

                            <!-- Columna Derecha -->
                            <div class="space-y-6">
                                <div>
                                    <label for="section_id" class="block text-sm font-semibold text-gray-700 mb-2">Sección Principal</label>
                                    <select name="section_id" id="section_id"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                        <option value="">Ninguna</option>
                                        @foreach ($sections as $section)
                                            <option value="{{ $section->id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('section_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="position" class="block text-sm font-semibold text-gray-700 mb-2">Posición</label>
                                    <input type="text" name="position" id="position" value="{{ old('position') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                    @error('position') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="active" {{ old('active', true) ? 'checked' : '' }} class="form-checkbox h-5 w-5 text-indigo-600">
                                        <span class="ml-2 text-sm font-semibold text-gray-700">Activo</span>
                                    </label>
                                </div>

                                <!-- Roles -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Roles</label>
                                    <div class="grid grid-cols-2 gap-2">
                                        @foreach ($roles as $role)
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" name="roles[]" value="{{ $role->id }}" {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }} class="form-checkbox h-5 w-5 text-indigo-600">
                                                <span class="ml-2 text-sm text-gray-700">{{ $role->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Permissions -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Permisos Directos</label>
                                    <div class="grid grid-cols-2 gap-2">
                                        @foreach ($permissions as $permission)
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }} class="form-checkbox h-5 w-5 text-indigo-600">
                                                <span class="ml-2 text-sm text-gray-700">{{ $permission->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Secciones Asignadas -->
                        <div class="mt-8">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Secciones Asignadas</label>
                            <div x-data="{ sections: [] }" class="space-y-4">
                                <template x-for="(section, index) in sections" :key="index">
                                    <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-lg">
                                        <select :name="'sections[' + index + '][section_id]'" required
                                                class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                            <option value="">Seleccionar sección</option>
                                            @foreach ($sections as $section)
                                                <option value="{{ $section->id }}" x-bind:selected="section.section_id == {{ $section->id }}">{{ $section->name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" :name="'sections[' + index + '][role_in_section]'" :value="section.role_in_section || ''" placeholder="Rol en sección"
                                               class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                        <button type="button" @click="sections.splice(index, 1)" class="text-red-600 hover:text-red-800 font-medium">Eliminar</button>
                                    </div>
                                </template>
                                <button type="button" @click="sections.push({ section_id: '', role_in_section: '' })"
                                        class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg transition">
                                    Añadir Sección
                                </button>
                            </div>
                        </div>

                        <!-- Subsecciones Asignadas -->
                        <div class="mt-8">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Subsecciones Asignadas</label>
                            <div x-data="{ subsections: [] }" class="space-y-4">
                                <template x-for="(subsection, index) in subsections" :key="index">
                                    <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-lg">
                                        <select :name="'subsections[' + index + '][subsection_id]'" required
                                                class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                            <option value="">Seleccionar subsección</option>
                                            @foreach ($subsections as $subsection)
                                                <option value="{{ $subsection->id }}" x-bind:selected="subsection.subsection_id == {{ $subsection->id }}">{{ $subsection->name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" :name="'subsections[' + index + '][role_in_subsection]'" :value="subsection.role_in_subsection || ''" placeholder="Rol en subsección"
                                               class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                        <button type="button" @click="subsections.splice(index, 1)" class="text-red-600 hover:text-red-800 font-medium">Eliminar</button>
                                    </div>
                                </template>
                                <button type="button" @click="subsections.push({ subsection_id: '', role_in_subsection: '' })"
                                        class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg transition">
                                    Añadir Subsección
                                </button>
                            </div>
                        </div>

                        <div class="flex gap-4 pt-8 border-t">
                            <button type="submit"
                                    class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105">
                                Crear Usuario
                            </button>
                            <a href="{{ route('users.index') }}"
                               class="px-8 py-3 bg-gray-500 hover:bg-gray-600 text-white font-bold rounded-lg transition">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>