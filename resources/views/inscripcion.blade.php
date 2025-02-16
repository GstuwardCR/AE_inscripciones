<!DOCTYPE html>
{{-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> --}}
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Inscripciones</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="https://aducv.ich.pe/assets/ico/favicon.ico">
    <!-- ViteJS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="antialiased">

    <main class="py-2"> {{-- quitar la class --}}
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class='flex w-full justify-center pb-2  '>
                <img src='https://ichintranetalumnos.s3.us-east-1.amazonaws.com/mod_simulacros/Slider-simulacrogratuito_feb-sistemas.jpg'
                    alt='banner inscripciones mobile' class='block w-full rounded-md md:hidden' />
                <img src='https://ichintranetalumnos.s3.us-east-1.amazonaws.com/mod_simulacros/Slider-simulacrogratuito_feb-sistemas.jpg'
                    alt='banner inscripciones desktop' class='hidden w-full rounded-md md:block' />
            </div>

            <div x-data="{ tab: 'tab1' }" class="px-1.5">
                <div class="flex border-b">
                    <button @click="tab = 'tab1'"
                        :class="tab === 'tab1' ? 'border-sky-700 border text-white bg-sky-700' :
                            'border-sky-700 border text-gray-500'"
                        class="px-4 py-2 border-b-2 w-full rounded-l-md">Datos</button>
                    <button @click="tab = 'tab2'"
                        :class="tab === 'tab2' ? 'border-sky-700 border text-white bg-sky-700' :
                            'border-sky-700 border text-gray-500'"
                        class="px-4 py-2 border-b-2 w-full rounded-r-md">Verifica tu Inscripción</button>
                </div>

                <div class="p-1.5">
                    <div x-show="tab === 'tab1'">
                        <!-- Your content -->
                        <div class="p-3 max-w-full">

                            @if (!empty($simulacros))
                                <div class="w-full bg-white/90">
                                    <form method="POST" id="formulario" action="{{ route('inscripcion.store') }}">
                                        @csrf

                                        <div class="space-y-4">
                                            <div
                                                class='$bg w-full rounded-md py-2 text-center text-2xl font-semibold text-white bg-sky-700'>
                                                INSCRIPCIONES
                                            </div>

                                            {{-- nombre completo --}}
                                            <div
                                                class="flex flex-col md:flex-row justify-center items-start gap-4 md:gap-2">

                                                <div class="relative w-full">
                                                    <input type="text" id="alu_nom" name="alu_nom"
                                                        value="{{ old('alu_nom') }}" placeholder=" "
                                                        class="peer block w-full rounded-md border-x-4 border border-gray-300 bg-transparent px-3 pt-5 pb-2 text-sm text-gray-900 focus:border-sky-700 focus:ring-1 focus:ring-sky-700 outline-none"
                                                        oninput="this.value = this.value.toUpperCase().replace(/[^a-zA-ZñÑáéíóúÁÉÍÓÚ\s]/g, '')"
                                                        required>

                                                    <label for="alu_nom"
                                                        class="absolute left-3 top-1 text-xs text-gray-500 transition-all peer-placeholder-shown:top-5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-1 peer-focus:text-xs peer-focus:text-sky-700 peer-focus:bg-white px-1">
                                                        Nombres
                                                    </label>

                                                    @error('alu_nom')
                                                        <p class="mt-1 text-sm text-red-600">{{ __($message) }}</p>
                                                    @enderror
                                                </div>

                                                <div class="relative w-full">
                                                    <input type="text" id="ape_pat" name="ape_pat"
                                                        value="{{ old('ape_pat') }}" placeholder=" "
                                                        class="peer block w-full rounded-md border border-gray-300 border-x-4 bg-transparent px-3 pt-5 pb-2 text-sm text-gray-900 focus:border-sky-700 focus:ring-1 focus:ring-sky-700 outline-none"
                                                        oninput="this.value = this.value.toUpperCase().replace(/[^a-zA-ZñÑáéíóúÁÉÍÓÚ\s]/g, '')"
                                                        required>

                                                    <label for="ape_pat"
                                                        class="absolute left-3 top-1 text-xs text-gray-500 transition-all peer-placeholder-shown:top-5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-1 peer-focus:text-xs peer-focus:text-sky-700 peer-focus:bg-white px-1">
                                                        Apellido Paterno
                                                    </label>

                                                    @error('ape_pat')
                                                        <p class="mt-1 text-sm text-red-600">{{ __($message) }}</p>
                                                    @enderror
                                                </div>

                                                <div class="relative w-full">
                                                    <input type="text" id="ape_mat" name="ape_mat"
                                                        value="{{ old('ape_mat') }}" placeholder=" "
                                                        class="peer block w-full rounded-md border border-gray-300 border-x-4 bg-transparent px-3 pt-5 pb-2 text-sm text-gray-900 focus:border-sky-700 focus:ring-1 focus:ring-sky-700 outline-none"
                                                        oninput="this.value = this.value.toUpperCase().replace(/[^a-zA-ZñÑáéíóúÁÉÍÓÚ\s]/g, '')"
                                                        required>

                                                    <label for="ape_mat"
                                                        class="absolute left-3 top-1 text-xs text-gray-500 transition-all peer-placeholder-shown:top-5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-1 peer-focus:text-xs peer-focus:text-sky-700 peer-focus:bg-white px-1">
                                                        Apellido Materno
                                                    </label>

                                                    @error('ape_mat')
                                                        <p class="mt-1 text-sm text-red-600">{{ __($message) }}</p>
                                                    @enderror
                                                </div>

                                            </div>

                                            {{-- dni - fecha - celular --}}
                                            <div
                                                class="flex flex-col md:flex-row justify-center items-center gap-4 md:gap-2">
                                                <!-- DNI -->
                                                <div class="relative w-full">
                                                    <input type="text" id="num_documen" name="num_documen"
                                                        value="{{ old('num_documen') }}" placeholder=" "
                                                        class="peer block w-full rounded-md border border-gray-300 border-x-4 bg-transparent px-3 pt-5 pb-2 text-sm text-gray-900 focus:border-sky-700 focus:ring-1 focus:ring-sky-700 outline-none"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                        required>

                                                    <label for="num_documen"
                                                        class="absolute left-3 top-1 text-xs text-gray-500 transition-all peer-placeholder-shown:top-5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-1 peer-focus:text-xs peer-focus:text-sky-700 peer-focus:bg-white px-1">
                                                        DNI
                                                    </label>

                                                    @error('num_documen')
                                                        <p class="mt-1 text-sm text-red-600">{{ __($message) }}</p>
                                                    @enderror
                                                </div>

                                                <!-- Fecha -->
                                                <div class="relative w-full">
                                                    <input type="date" id="fecha" name="fecha"
                                                        value="{{ old('fecha') }}"
                                                        class="peer block w-full rounded-md border border-gray-300 border-x-4 bg-transparent px-3 pt-5 pb-2 text-sm text-gray-900 focus:border-sky-700 focus:ring-1 focus:ring-sky-700 outline-none"
                                                        required>

                                                    <label for="fecha"
                                                        class="absolute left-3 top-1 text-xs text-gray-500 transition-all peer-placeholder-shown:top-5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-1 peer-focus:text-xs peer-focus:text-sky-700 peer-focus:bg-white px-1">
                                                        Fecha de Nacimiento
                                                    </label>

                                                    @error('fecha')
                                                        <p class="mt-1 text-sm text-red-600">{{ __($message) }}</p>
                                                    @enderror
                                                </div>

                                                <!-- Celular -->
                                                <div class="relative w-full">
                                                    <input type="text" id="col_tel" name="col_tel"
                                                        value="{{ old('col_tel') }}" placeholder=" " maxlength="9"
                                                        class="peer block w-full rounded-md border border-gray-300 border-x-4 bg-transparent px-3 pt-5 pb-2 text-sm text-gray-900 focus:border-sky-700 focus:ring-1 focus:ring-sky-700 outline-none"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                        required>

                                                    <label for="col_tel"
                                                        class="absolute left-3 top-1 text-xs text-gray-500 transition-all peer-placeholder-shown:top-5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-1 peer-focus:text-xs peer-focus:text-sky-700 peer-focus:bg-white px-1">
                                                        Celular
                                                    </label>

                                                    @error('col_tel')
                                                        <p class="mt-1 text-sm text-red-600">{{ __($message) }}</p>
                                                    @enderror
                                                </div>

                                            </div>

                                            {{-- correo - sede - ciclo  --}}
                                            <div
                                                class="flex flex-col md:flex-row justify-center items-start gap-4 md:gap-2">

                                                <!-- Correo -->
                                                <div class="relative w-full">
                                                    <input type="email" id="email" name="email"
                                                        value="{{ old('email') }}" placeholder=" "
                                                        class="peer block w-full rounded-md border border-gray-300 border-x-4 bg-transparent px-3 pt-5 pb-2 text-sm text-gray-900 focus:border-sky-700 focus:ring-1 focus:ring-sky-700 outline-none"
                                                        required>

                                                    <label for="email"
                                                        class="absolute left-3 top-1 text-xs text-gray-500 transition-all peer-placeholder-shown:top-5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-1 peer-focus:text-xs peer-focus:text-sky-700 peer-focus:bg-white px-1">
                                                        Correo
                                                    </label>

                                                    @error('email')
                                                        <p class="mt-1 text-sm text-red-600">{{ __($message) }}</p>
                                                    @enderror
                                                </div>

                                                <!-- Sede -->
                                                <div class="relative w-full">
                                                    <select id="grado" name="sede"
                                                        class="peer block w-full rounded-md border border-gray-300 border-x-4 bg-transparent px-3 pt-5 pb-2 text-sm text-gray-900 focus:border-sky-700 focus:ring-1 focus:ring-sky-700 outline-none appearance-none"
                                                        required>
                                                        <option value="" hidden>Seleccione</option>
                                                        @foreach ($sedes as $sede)
                                                            <option value="{{ $sede->loc_id }}"
                                                                {{ old('sede') == $sede->loc_id ? 'selected' : '' }}>
                                                                {{ $sede->loc_desc }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                    <label for="sede"
                                                        class="absolute left-3 top-1 text-xs text-gray-500 transition-all peer-placeholder-shown:top-5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-1 peer-focus:text-xs peer-focus:text-sky-700 peer-focus:bg-white px-1">
                                                        Sede
                                                    </label>

                                                    @error('sede')
                                                        <p class="mt-1 text-sm text-red-600">{{ __($message) }}</p>
                                                    @enderror
                                                </div>

                                                <!-- Ciclo -->
                                                <div class="relative w-full">
                                                    <select id="ciclo" name="ciclo"
                                                        class="peer block w-full rounded-md border border-gray-300 border-x-4 bg-transparent px-3 pt-5 pb-2 text-sm text-gray-900 focus:border-sky-700 focus:ring-1 focus:ring-sky-700 outline-none appearance-none"
                                                        required>
                                                        <option value="" hidden>Seleccione</option>
                                                        @foreach ($ciclos as $ciclo)
                                                            <option value="{{ $ciclo->nombre }}"
                                                                {{ old('ciclo') == $ciclo->nombre ? 'selected' : '' }}>
                                                                {{ $ciclo->descripcion }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                    <label for="ciclo"
                                                        class="absolute left-3 top-1 text-xs text-gray-500 transition-all peer-placeholder-shown:top-5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-1 peer-focus:text-xs peer-focus:text-sky-700 peer-focus:bg-white px-1">
                                                        Ciclo
                                                    </label>

                                                    @error('ciclo')
                                                        <p class="mt-1 text-sm text-red-600">{{ __($message) }}</p>
                                                    @enderror
                                                </div>

                                            </div>

                                            {{-- terminos y condicion --}}
                                            <div class="flex items-center justify-center gap-1 py-1">
                                                <label
                                                    class="relative flex cursor-pointer items-center rounded-full p-3"
                                                    for="t_y_c" data-ripple-dark="true">
                                                    <input id="t_y_c" type="checkbox" required
                                                        {{ old('t_y_c') ? 'checked' : '' }}
                                                        onchange="document.querySelector('button[onclick=\'show_modal_confirm()\']').disabled = !this.checked;"
                                                        class="before:content[``] peer relative h-5 w-5 cursor-pointer appearance-none rounded-md border border-blue-sky-700 transition-all before:absolute before:top-2/4 before:left-2/4 before:block before:h-12 before:w-12 before:-translate-y-2/4 before:-translate-x-2/4 before:rounded-full before:bg-blue-gray-500 before:opacity-0 before:transition-opacity checked:border-[#337ab7] checked:bg-[#337ab7] checked:before:bg-[#337ab7] hover:before:opacity-10">
                                                    <div
                                                        class="pointer-events-none absolute top-2/4 left-2/4 -translate-y-2/4 -translate-x-2/4 text-white opacity-0 transition-opacity peer-checked:opacity-100">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                                            viewBox="0 0 20 20" fill="currentColor"
                                                            stroke="currentColor" stroke-width="1">
                                                            <path fill-rule="evenodd"
                                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </div>
                                                </label>
                                                <label
                                                    class="mt-px cursor-pointer select-none font-light text-gray-800"
                                                    for="t_y_c">
                                                    He leído y acepto los <a
                                                        href="https://aduni.edu.pe/simulacro-presencial-san-marcos/"
                                                        target="_blank"
                                                        class="text-sky-700 hover:underline font-bold">Términos y
                                                        Condiciones</a>
                                                    y <a href="https://aduni.edu.pe/autorizacion-para-el-uso-y-tratamiento-de-datos-personales/"
                                                        target="_blank"
                                                        class="text-sky-700 hover:underline font-bold">la
                                                        Autorización para el uso y tratamiento de los datos
                                                        personales.</a>
                                                </label>
                                            </div>

                                            <div class="flex justify-center">
                                                <button type="button" onclick="show_modal_confirm()" disabled
                                                    class="flex justify-center items-center py-3 px-6 text-sm font-medium text-center text-white rounded-lg bg-sky-700 sm:w-fit hover:bg-sky-700/90 disabled:bg-sky-700/75">
                                                    <svg viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                                        <path fill-rule="evenodd"
                                                            d="M5.478 5.559A1.5 1.5 0 0 1 6.912 4.5H9A.75.75 0 0 0 9 3H6.912a3 3 0 0 0-2.868 2.118l-2.411 7.838a3 3 0 0 0-.133.882V18a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3v-4.162c0-.299-.045-.596-.133-.882l-2.412-7.838A3 3 0 0 0 17.088 3H15a.75.75 0 0 0 0 1.5h2.088a1.5 1.5 0 0 1 1.434 1.059l2.213 7.191H17.89a3 3 0 0 0-2.684 1.658l-.256.513a1.5 1.5 0 0 1-1.342.829h-3.218a1.5 1.5 0 0 1-1.342-.83l-.256-.512a3 3 0 0 0-2.684-1.658H3.265l2.213-7.191Z"
                                                            clip-rule="evenodd" />
                                                        <path fill-rule="evenodd"
                                                            d="M12 2.25a.75.75 0 0 1 .75.75v6.44l1.72-1.72a.75.75 0 1 1 1.06 1.06l-3 3a.75.75 0 0 1-1.06 0l-3-3a.75.75 0 0 1 1.06-1.06l1.72 1.72V3a.75.75 0 0 1 .75-.75Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="ml-2">REGISTRARSE</span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @else
                                <span
                                    class="flex items-center justify-center gap-x-1.5 rounded-md bg-red-200 px-3 py-2 my-4 text-xl font-medium text-red-700">
                                    <svg class="h-3 w-3 fill-sky-700" viewBox="0 0 6 6" aria-hidden="true">
                                        <circle cx="3" cy="3" r="3" />
                                    </svg>
                                    <!-- Este formulario estará disponible desde el 31 de Agosto hasta el 14 de Septiembre de 2024. -->
                                    Este formulario se encuentra cerrado.
                                </span>
                            @endif
                        </div>
                        <!-- Your content -->
                    </div>
                    <div x-show="tab === 'tab2'">
                        <!-- Your content -->
                        <div class="p-3 max-w-full">

                            @if (!empty($simulacros))
                                <div class="w-full bg-white/90">
                                    <form method="POST" id="formulario_buqueda"
                                        action="{{ route('inscripcion.search') }}">
                                        @csrf

                                        <div class="space-y-4">
                                            <div
                                                class='$bg w-full rounded-md py-2 text-center text-2xl font-semibold text-white bg-sky-700 uppercase'>
                                                VERIFICA TU Inscripción
                                            </div>

                                            <div
                                                class="flex flex-col md:flex-row justify-center items-center gap-4 md:gap-2 w-full">

                                                <div class="flex flex-col md:flex-row w-9/12">

                                                    <div class="relative w-full">
                                                        <input type="text" id="dni" name="dni"
                                                            value="{{ old('dni') }}" placeholder=" "
                                                            class="peer block w-full rounded-md border border-gray-300 border-x-4 bg-transparent px-3 pt-5 pb-2 text-sm text-gray-900 focus:border-sky-700 focus:ring-1 focus:ring-sky-700 outline-none"
                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                            required>

                                                        <label for="dni"
                                                            class="absolute uppercase left-3 top-1 text-xs text-gray-500 transition-all peer-placeholder-shown:top-5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-1 peer-focus:text-xs peer-focus:text-sky-700 peer-focus:bg-white px-1">
                                                            DNI O CODIGO DE Inscripción
                                                        </label>

                                                        @error('dni')
                                                            <p class="mt-1 text-sm text-red-600">{{ __($message) }}</p>
                                                        @enderror
                                                    </div>
                                                    <div class="w-full flex justify-center items-center">
                                                        <button type="submit"
                                                            class="flex justify-center items-center py-3 px-6 text-sm font-medium text-center text-white rounded-lg bg-sky-700 sm:w-fit hover:bg-sky-700/90 disabled:bg-sky-700/75">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 24 24" fill="currentColor"
                                                                class="size-6">
                                                                <path
                                                                    d="M8.25 10.875a2.625 2.625 0 1 1 5.25 0 2.625 2.625 0 0 1-5.25 0Z" />
                                                                <path fill-rule="evenodd"
                                                                    d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.125 4.5a4.125 4.125 0 1 0 2.338 7.524l2.007 2.006a.75.75 0 1 0 1.06-1.06l-2.006-2.007a4.125 4.125 0 0 0-3.399-6.463Z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                            <span class="ml-2">Consultar Inscripción</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            @else
                                <span
                                    class="flex items-center justify-center gap-x-1.5 rounded-md bg-red-200 px-3 py-2 my-4 text-xl font-medium text-red-700">
                                    <svg class="h-3 w-3 fill-sky-700" viewBox="0 0 6 6" aria-hidden="true">
                                        <circle cx="3" cy="3" r="3" />
                                    </svg>
                                    <!-- Este formulario estará disponible desde el 31 de Agosto hasta el 14 de Septiembre de 2024. -->
                                    Este formulario se encuentra cerrado.
                                </span>
                            @endif
                        </div>
                        <!-- Your content -->
                    </div>
                </div>
            </div>

        </div>

    </main>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                Toast.fire({
                    icon: 'error',
                    title: '{{ $error }}'
                });
            </script>
        @endforeach
    @endif


    @if (session('success'))
        <script>
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            })
        </script>
        <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

        {{-- MODAL --}}
        <div class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">

            <div id="bg-modal-success" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity">
            </div>

            <div id="content-modal-success" class="fixed inset-0 z-10 w-screen overflow-y-auto ">
                <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                    <div
                        class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                        {{-- CLOSE --}}
                        <div class="absolute right-0 top-0 hidden pr-4 pt-4 sm:block">
                            <button type="button" onclick="close_modal_cerrar_1()"
                                class="rounded-md bg-white text-gray-400 hover:bg-gray-200">
                                <span class="sr-only">Close</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        {{-- BODY --}}
                        <div>
                            <div class="mt-3">
                                <h3 class="text-2xl text-center font-bold leading-6 text-gray-900 uppercase flex items-center justify-center gap-2"
                                    id="modal-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25" fill="green"
                                        class="size-16">
                                        <path fill-rule="evenodd"
                                            d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Zm7.007 6.387a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ session('tipo') == 'existente' ? 'Inscripción encontrada' : 'Inscripción registrada' }}
                                </h3>

                                <div class="my-3 w-11/12 mx-auto text-left flex flex-col">
                                    @php $datos = session('datos_inscripcion'); @endphp
                                    @if ($datos)
                                        <div class="text-sm text-gray-600">Código: <strong
                                                class="text-lg">{{ $datos['codigo'] }}</strong></div>
                                        <div class="text-sm text-gray-600">Nombres: <strong
                                                class="text-lg">{{ $datos['nombres'] }}</strong></div>
                                        <div class="text-sm text-gray-600">Apellidos: <strong
                                                class="text-lg">{{ $datos['apellidos'] }}</strong></div>
                                        <div class="text-sm text-gray-600">Sede: <strong
                                                class="text-lg">{{ $datos['sede'] }}</strong></div>
                                        <div class="text-sm text-gray-600">Área: <strong
                                                class="text-lg">{{ $datos['area'] }}</strong></div>
                                        <div class="text-sm text-gray-600">Fecha y Hora: <strong
                                                class="text-lg">{{ $datos['fecha'] }}</strong></div>
                                    @else
                                        <div class="text-sm text-gray-600">No hay datos disponibles.</div>
                                    @endif
                                </div>

                            </div>
                        </div>
                        {{-- BUTTONS --}}
                        <div class="flex flex-col md:flex-row justify-center items-center gap-2 py-2">
                            {{--  md:justify-end --}}
                            <button type="button" onclick="construir_ficha('visualizar', this.dataset.inscripcion)"
                                data-inscripcion='@json(session('datos_inscripcion'))' id="verFicha"
                                class="flex justify-center items-center w-full md:w-fit rounded-md bg-emerald-500 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-emerald-400 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                <span class="ml-2">VISUALIZAR FICHA</span>
                            </button>

                            <button type="button" onclick="construir_ficha('descargar', this.dataset.inscripcion)"
                                data-inscripcion='@json(session('datos_inscripcion'))' id="desFicha"
                                class="flex justify-center items-center w-full md:w-fit rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                                <span class="ml-2">DESCARGAR FICHA</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- MODAL --}}
    @endif

    @if (session('error') !== null)
        {{-- MODAL --}}
        <div class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">

            <div id="bg-modal-error" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity">
            </div>

            <div id="content-modal-error" class="fixed inset-0 z-10 w-screen overflow-y-auto ">
                <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                    <div
                        class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">

                        {{-- BODY --}}
                        <div>
                            <div class="mt-3">
                                <h3 class="text-2xl text-center font-bold leading-6 text-gray-900 uppercase flex items-center justify-center gap-2"
                                    id="modal-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25" fill="red"
                                        class="size-16">
                                        <path fill-rule="evenodd"
                                            d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                                            clip-rule="evenodd" />
                                    </svg>

                                    {{ session('error') }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- MODAL --}}
        <script>
            setTimeout(() => {
                $('#bg-modal-error').addClass('hidden');
                $('#content-modal-error').addClass('hidden');
            }, 3500);
        </script>
    @endif

    @if (!empty($simulacros))
        {{-- MODAL --}}
        <div class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">

            <div id="bg-modal-confirm" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity hidden">
            </div>

            <div id="content-modal-confirm" class="fixed inset-0 z-10 w-screen overflow-y-auto hidden">
                <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                    <div
                        class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                        {{-- CLOSE --}}
                        <div class="absolute right-0 top-0 hidden pr-4 pt-4 sm:block">
                            <button type="button" onclick="close_modal_confirm()"
                                class="rounded-md bg-white text-gray-400 hover:bg-gray-200">
                                <span class="sr-only">Close</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        {{-- BODY --}}
                        <div>
                            <div class="mt-3">
                                <h3 class="text-base text-center font-bold leading-6 text-gray-900 uppercase"
                                    id="modal-title">
                                    ¿Está seguro de registrar los datos?
                                </h3>
                                <div class="my-2">
                                    <span class="text-sm text-gray-500">
                                        Nota: Una vez registrados los datos no se podrán eliminar.
                                    </span>
                                </div>
                            </div>
                        </div>
                        {{-- BUTTONS --}}
                        <div class="flex flex-col md:flex-row justify-center md:justify-end items-center gap-2 py-2">
                            <button type="button" onclick="close_modal_confirm()"
                                class="w-full justify-center rounded-md bg-white border border-black px-3 py-2 text-sm font-semibold text-black shadow-sm sm:w-auto hover:text-white hover:bg-black">
                                No, Cerrar
                            </button>
                            <button type="button" onclick="send_form(this)"
                                class="w-full justify-center rounded-md bg-[#e7273e] px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#e7273e]/85 sm:w-auto">
                                Si, Registrar Datos
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- MODAL --}}

        <script>
            const close_modal_cerrar = () => {
                $('#bg-modal-existing-document').addClass('hidden');
                $('#content-modal-existing-document').addClass('hidden');
            }

            const close_modal_existing_dni = () => {
                $('#bg-modal-existing-dni').addClass('hidden');
                $('#content-modal-existing-dni').addClass('hidden');
            }

            const close_modal_cerrar_1 = () => {
                $('#bg-modal-success').addClass('hidden');
                $('#content-modal-success').addClass('hidden');
            }

            const close_modal_confirm = () => {
                $('#bg-modal-confirm').addClass('hidden');
                $('#content-modal-confirm').addClass('hidden');
            }

            const show_modal_confirm = () => {
                //var campos = document.querySelectorAll("input[required], select[required]");
                var campos = document.querySelectorAll("#formulario input[required], #formulario select[required]");

                campos.forEach(function(campo) {
                    campo.classList.remove('border-red-600');
                    campo.classList.remove('focus:border-red-600');
                    campo.classList.remove('focus:ring-red-600');
                });

                var primerCampoSinValor = null;
                campos.forEach(function(campo) {
                    if (!campo.value.trim()) {
                        campo.classList.add('border-red-600');
                        campo.classList.add('focus:border-red-600');
                        campo.classList.add('focus:ring-red-600');
                        if (!primerCampoSinValor) {
                            primerCampoSinValor = campo;
                        }
                    }
                });

                if (primerCampoSinValor) {
                    primerCampoSinValor.focus();
                    Toast.fire({
                        icon: "error",
                        title: 'Por favor completa todos los campos vacios.',
                        timer: 2000,
                    });
                } else {
                    $('#bg-modal-confirm').removeClass('hidden');
                    $('#content-modal-confirm').removeClass('hidden');
                }
            };

            const send_form = (element) => {
                $(element).prop("disabled", true);
                $(element).addClass("cursor-not-allowed flex justify-center items-center gap-2");
                $(element).html(`
                    <svg class="animate-spin" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-loader-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 3a9 9 0 1 0 9 9"></path>
                    </svg>
                    <span>Registrando...</span>
                `);

                let inputs = $("input").not("[name='_token']");
                inputs.each(function() {
                    $(this).val($(this).val().toUpperCase());
                })

                // $("form").submit();
                $("#formulario").submit();

            }

            function construir_ficha(type, inscripcion) {
                try {
                    let data = JSON.parse(inscripcion);
                    console.log("Datos de inscripción:", data);

                    if (typeof JsBarcode === "undefined") {
                        throw new Error("JsBarcode no está definido. Verifica que el script se haya cargado.");
                    }

                    // Crear un canvas en memoria para generar el código de barras
                    let canvas = document.createElement("canvas");
                    JsBarcode(canvas, data.codigo, {
                        format: "CODE128"
                    });
                    let barcode = canvas.toDataURL("image/png"); // Convertir a Base64

                    // Cargar la imagen de fondo correctamente
                    let fondo = new Image();
                    fondo.src = "{{ asset('storage/img/modelo.jpg') }}";

                    fondo.onload = function() {
                        if (!window.jspdf) {
                            throw new Error(
                                "jsPDF no está definido. Verifica que el script se haya cargado correctamente.");
                        }
                        const {
                            jsPDF
                        } = window.jspdf;
                        let doc = new jsPDF({
                            orientation: "portrait",
                            unit: "mm",
                            format: [120, 150]
                        });

                        doc.addImage(fondo, "JPG", 5, 5, 110, 139);
                        doc.setFontSize(13);
                        doc.text(29, 47, data.dni).setFontSize(15);
                        doc.text(20, 59.7, `${data.nombres}`).setFontSize(
                            13);
                        doc.text(20, 65, `${data.apellidos}`).setFontSize(
                            13);

                        let new_sede_area = "";

                        switch (`${data.sede}`) {
                            case "SAN JUAN DE LURIGANCHO":
                                new_sede_area = "SJL";
                                break;
                            case "BOLIVIA 537":
                                new_sede_area = "BOLIVIA";
                                break;
                            default:
                                new_sede_area = data.sede;
                                break;
                        }
                        doc.text(30, 71, new_sede_area);
                        doc.text(30, 77, 'Área ' + data.area);
                        doc.text(48, 83, data.fecha).setFontSize(13);
                        doc.text(86, 89, data.codigo);

                        // Agregar código de barras
                        doc.addImage(barcode, "PNG", 35, 95, 55, 35);

                        if (type === "descargar") {
                            doc.save("ficha_inscripcion.pdf");
                        } else if (type === "visualizar") {
                            doc.output("dataurlnewwindow", "ficha_inscripcion.pdf");
                        }

                    };

                    fondo.onerror = function() {
                        console.error("Error al cargar la imagen de fondo. Verifica la ruta.");
                    };
                } catch (error) {
                    console.error("Error al generar ficha:", error);
                }
            }
        </script>
    @endif
</body>

</html>
