@extends('layouts.panel')

@section('title')
    Clase @if (isset($lesson->id_lesson))
        de {{ $lesson->users->from->username }}
    @else
        > Nueva
    @endif | GameChangerZ
@endsection

@section('css')
    <link href={{ asset('css/panel/lesson/details.css') }} rel="stylesheet">
@endsection

@section('tabs')
    @component('components.tab.panel')
    @endcomponent
@endsection

@section('content')
    <li id="lesson" class="tab-content min-h-screen p-12 closed hive">
        <form id="lesson-form" action="#" method="post" enctype="multipart/form-data">
            @csrf
            @method("POST")

            <header class="flex w-full mb-24">
                <h2 class="russo color-white mr-4 uppercase">Clase <span class="overpass color-black">></span> @if (isset($lesson->id_lesson))
                    {{ $lesson->users->from->username }}
                @else
                    Nueva
                @endif</h2>
                <div class="flex items-center">
                    <a class="btn btn-one btn-icon editBtn" href="#update">
                        <i class="fas fa-pen"></i>
                    </a>
                    <a class="btn btn-one btn-icon deleteBtn ml-4" href="#delete">
                        <i class="fas fa-trash"></i>
                    </a>
                    <div class="msg-modal hidden mr-4">
                        <input type="text" class="px-5 py-4 rounded form-input lesson-form" placeholder='Escribí "BORRAR" para confirmar' name="message">
                    </div>
                    <button type="submit" class="btn btn-white btn-icon hidden submitBtn form-submit lesson-form">
                        <i class="fas fa-check"></i>
                    </button>
                    <a class="btn btn-three btn-icon ml-4 hidden cancelBtn" href="#">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </header>

            <main class="my-2 py-2 grid grid-cols-8 gap-8">
                <div class="pt-0 col-span-2">
                    <select name="id_user_from" class="px-5 py-4 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full form-input lesson-form editable" @if(isset($lesson->id_lesson)) disabled @endif>
                        <option class="overpass" disabled @if (!old("id_user_from", $lesson->id_user_from)) selected @endif>Profesor</option>
                        @foreach ($teachers as $teacher)
                            <option class="overpass" value="{{ $teacher->id_user }}" @if (old("teacher", $lesson->id_user_from) === $teacher->id_user) selected @endif>{{ $teacher->username }}</option>
                        @endforeach
                    </select>
                    <span class="block color-white error support lesson-form support-box hidden support-id_user_from mt-2 overpass"></span>
                </div>

                <div class="pt-0 col-span-2">
                    <select name="id_user_to" class="px-5 py-4 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full form-input lesson-form editable" @if(isset($lesson->id_lesson)) disabled @endif>
                        <option class="overpass" disabled @if (!old("id_user_to", $lesson->id_user_to)) selected @endif>Usuario</option>
                        @foreach ($users as $user)
                            <option class="overpass" value="{{ $user->id_user }}" @if (old("user", $lesson->id_user_to) === $user->id_user) selected @endif>{{ $user->username }}</option>
                        @endforeach
                    </select>
                    <span class="block color-white error support lesson-form support-box hidden support-id_user_to mt-2 overpass"></span>
                </div>

                <div class="pt-0 col-span-2 col-start-1">
                    <select name="id_type" class="px-5 py-4 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full form-input lesson-form editable" @if(isset($lesson->id_lesson)) disabled @endif>
                        <option class="overpass" disabled @if (!old("id_type", $lesson->type->id_type)) selected @endif>Tipo de clase</option>
                        @foreach ($types as $type)
                            <option class="overpass" value="{{ $type->id_type }}" @if (old("id_type", $lesson->type->id_type) === $type->id_type) selected @endif>{{ $type->name }}</option>
                        @endforeach
                    </select>
                    <span class="block color-white error support lesson-form support-box hidden support-id_type mt-2 overpass"></span>
                </div>

                <div class="pt-0 col-span-2">
                    <select name="id_method" class="px-5 py-4 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full form-input lesson-form editable" @if(isset($lesson->id_lesson)) disabled @endif>
                        <option class="overpass" disabled @if (!old("id_method", $lesson->id_method)) selected @endif>Metodo de pago</option>
                        @foreach ($methods as $method)
                            <option class="overpass" value="{{ $method->id_method }}" @if (old("id_method", $lesson->id_method) === $method->id_method) selected @endif>{{ $method->name }}</option>
                        @endforeach
                    </select>
                    <span class="block color-white error support lesson-form support-box hidden support-id_method mt-2 overpass"></span>
                </div>

                <div class="pt-0 col-span-2 col-start-1">
                    <select name="id_status" class="px-5 py-4 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full form-input teacher-form editable" @if(isset($lesson->id_lesson)) disabled @endif>
                        <option class="overpass" disabled @if (!old("id_status", $lesson->id_status)) selected @endif>Estado</option>
                        <option class="overpass" value="0" @if (old("id_status", $lesson->id_status) === 0) selected @endif>Rechazada</option>
                        <option class="overpass" value="2" @if (old("id_status", $lesson->id_status) === 2) selected @endif>Pendiente de pago</option>
                        <option class="overpass" value="2" @if (old("id_status", $lesson->id_status) === 3) selected @endif>Aprobada</option>
                        <option class="overpass" value="2" @if (old("id_status", $lesson->id_status) === 4) selected @endif>Terminada</option>
                    </select>
                    <span class="block color-white error support teacher-form support-box hidden support-id_status mt-2 overpass"></span>
                </div>

                <div class="pt-0 col-span-4 col-start-1">
                    <div class="grid grid-cols-2 gap-8 dates">
                        @for ($i = 0; $i < count($lesson->days); $i++)
                            <label class="color-white col-start-1" @if ($lesson->days[$i]->id_status) title="Concluida" @endif>
                                <span class="russo">Fecha @if (count($lesson->days)) {{ $i + 1 }} @endif</span>
                                <input type="date" name="dates[{{ $i + 1 }}]" placeholder="Fecha de clase" value="{{ old("date[" . ($i + 1) . "]", $lesson->days[$i]->date) }}" class="px-5 py-4 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full lesson-form form-input editable mt-8" @if(isset($lesson->id_lesson)) disabled @endif/>
                            </label>
                            @if ($lesson->type->id_type !== 2)
                                <label class="color-white" @if ($lesson->days[$i]->id_status) title="Concluida" @endif>
                                    <span class="russo">Horario @if (count($lesson->days)) {{ $i + 1 }} @endif</span>
                                    <select name="hours[{{ $i + 1}}]" class="px-5 py-4 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full form-input lesson-form editable mt-8" @if(isset($lesson->id_lesson)) disabled @endif>
                                        @foreach ($hours as $hour)
                                            <option class="overpass" value="{{ $hour->id_hour }}" @if (old("hours[" . ($i + 1) . "]", $lesson->days[$i]->hours[0]->id_hour) === $hour->id_hour) selected @endif>{{ $hour->from }} - {{ $hour->to }}</option>
                                        @endforeach
                                    </select>
                                </label>
                            @endif
                        @endfor
                    </div>
                    <span class="block color-white error support lesson-form support-box hidden support-dates mt-2 overpass"></span>
                    <span class="block color-white error support lesson-form support-box hidden support-hours mt-2 overpass"></span>
                </div>         
            </main>
        </form>
    </li>
@endsection

@section('js')
    <script>
        const hours = @json($hours);
        const lesson = @json($lesson);
    </script>
    <script type="module" src={{ asset('js/panel/lesson/details.js') }}></script>
@endsection