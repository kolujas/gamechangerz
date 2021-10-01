@extends('layouts.panel')

@section('title')
    Listado de Clases | Gamechangerz
@endsection

@section('css')
    <link href={{ asset('css/panel/lesson/list.css') }} rel="stylesheet">
@endsection

@section('tabs')
    @component('components.tab.panel')
    @endcomponent
@endsection

@section('content')
    <li id="lessons" class="tab-content min-h-screen p-12 closed">
        <header class="flex w-full mb-24">
            <h2 class="russo color-white mr-4">Clases</h2>
            <div class="flex items-center">
                <a class="btn btn-one btn-outline overpass" href="/panel/bookings/create">
                    <span class="py-2 px-4">Registrar clase</span>
                </a>
            </div>
        </header>
        <main class="my-2 py-2 flex flex-wrap justify-center rounded">
            <table class="min-w-full grid">
                <thead class="grid">
                    <tr class="grid">
                        <th class="flex items-center px-6 py-3 text-left russo color-white"></th>
                        <th class="flex items-center px-6 py-3 text-left russo color-white col-span-2">Profesor</th>
                        <th class="flex items-center px-6 py-3 text-left russo color-white col-span-2">Usuario</th>
                        <th class="flex items-center px-6 py-3 text-left russo color-white col-span-2 col-span-2">Tipo</th>
                        {{-- <th class="flex items-center px-6 py-3 text-left russo color-white col-span-2 col-span-2">Registrada</th> --}}
                        <th class="flex items-center px-6 py-3 text-left russo color-white col-span-4">Clase</th>
                        <th class="flex items-center px-6 py-3"></th>
                        <th class="flex items-center px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="grid">
                    @if (count($lessons))
                        @foreach ($lessons as $lesson)
                            <tr data-href="/panel/bookings/{{ $lesson->id_lesson }}" class="grid">
                                <td class="flex items-center px-6 py-4 whitespace-no-wrap">
                                    <span class="text-sm overpass">{{ $lesson->id_lesson }}</s>
                                </td>                            
                                <td class="flex items-center px-6 py-4 whitespace-no-wrap color-white overpass col-span-2">{{ $lesson->users->from->username }}</td>
                                <td class="flex items-center px-6 py-4 whitespace-no-wrap color-white overpass col-span-2">{{ $lesson->users->to->username }}</td>
                                <td class="flex items-center px-6 py-4 whitespace-no-wrap color-white overpass col-span-2">{{ $lesson->type->name }}</td>
                                {{-- <td class="flex items-center px-6 py-4 whitespace-no-wrap color-white overpass col-span-2">{{ $lesson->updated_at->format("Y-m-d") }}</td> --}}
                                <td class="grid grid-cols-2 gap-2 px-6 py-4 whitespace-no-wrap color-white overpass col-span-4">
                                    @foreach ($lesson->days as $day)
                                        @if (count($day->hours))
                                            <div class="{{ $day->id_status ? "done" : "" }} grid p-2 bg-one rounded color-white text-sm text-center">
                                                <span class="flex items-center justify-center">{{ $day->date }}</span>
                                                <span class="flex items-center justify-center">{{ $day->hours[0]->from }} - {{ $day->hours[0]->to }}</span>
                                            </div>
                                        @endif
                                        @if (!count($day->hours))
                                            <div class="{{ $day->id_status ? "done" : "" }} grid p-2 bg-one rounded color-white text-sm text-center">
                                                <span class="flex items-center justify-center">{{ $day->date }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                </td>
                                <td class="flex items-center py-4">
                                    @if ($lesson->type->id_type === 2)
                                        <a class="btn btn-one btn-icon" data-id_lesson="{{ $lesson->id_lesson }}" href="#">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @endif
                                </td>
                                @if ($lesson->id_status === 0)
                                    <td class="flex items-center px-6 py-4" title="Rechazada">
                                        <i class="color-red fas fa-ban"></i>
                                    </td>
                                @endif
                                @if ($lesson->id_status === 1)
                                    <td class="flex items-center px-6 py-4" title="Creando">
                                        <i class="color-grey fas fa-spinner"></i>
                                    </td>
                                @endif
                                @if ($lesson->id_status === 2)
                                    <td class="flex items-center px-6 py-4" title="Pago pendiente">
                                        <i class="color-five fas fa-dollar-sign"></i>
                                    </td>
                                @endif
                                @if ($lesson->id_status === 3)
                                    <td class="flex items-center px-6 py-4" title="Aprobada">
                                        <i class="color-white fas fa-check"></i>
                                    </td>
                                @endif
                                @if ($lesson->id_status === 4)
                                    <td class="flex items-center px-6 py-4" title="Terminada">
                                        <i class="color-white fas fa-check-double"></i>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                    @if (!count($lessons))
                        <tr data-href="/panel/bookings/create" class="grid grid-cols-8">
                            <td class="col-span-8 flex items-center justify-center px-6 py-4 whitespace-no-wrap">No existen reservas</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </main>
    </li>
@endsection

@section('js')
    @component('components.modal.activity')
    @endcomponent
    <script type="module" src={{ asset('js/panel/lesson/list.js') }}></script>
@endsection