@extends('layouts.panel')

@section('title')
    Listado de Profesores | GameChangerZ
@endsection

@section('css')
    <link href={{ asset('css/panel/teacher/details.css') }} rel="stylesheet">
@endsection

@section('tabs')
    @component('components.tab.panel')
    @endcomponent
@endsection

@section('content')
    <li id="teacher" class="tab-content min-h-screen p-12 closed">
        <form action="">
            <header class="flex w-full mb-24">
                <h2 class="russo color-white mr-4">Profesor</h2>
                <div class="flex items-center">
                    <a class="btn btn-one btn-outline overpass mx-4" href="/panel/teachers/create">
                        <span class="py-2 px-4">Guardar cambios</span>
                    </a>
                    <a class="btn btn-one btn-outline overpass mx-4" href="/panel/teachers/create">
                        <span class="py-2 px-4">Eliminar profesor</span>
                    </a>
                    <a class="btn btn-one overpass mx-4" href="/panel/teachers/create">
                        <span class="py-2 px-4">Descartar cambios</span>
                    </a>
                </div>
            </header>

            <main class="my-2 py-2 grid grid-cols-4 gap-8">
                
                <label class="text-gray-700 col-span-4">
                    <span class="ml-1 color-white">Destacado</span>
                    <input type="checkbox" value=""/>
                </label>
                <div class="pt-0">
                    <input type="text" placeholder="Nombre del profesor" class="px-3 py-3 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none focus:ring w-full"/>
                </div>
                <div class="pt-0">
                    <input type="text" placeholder="Email" class="px-3 py-3 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none focus:ring w-full"/>
                </div>
                <div class="pt-0 row-span-2">
                    
                </div>
                <div class="pt-0 row-span-2">
                    
                </div>
                <div class="pt-0">
                    <input type="text" placeholder="Username" class="px-3 py-3 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none focus:ring w-full"/>
                </div>
                <div class="pt-0">
                    <input type="text" placeholder="Contraseña" class="px-3 py-3 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none focus:ring w-full"/>
                </div>
                <div class="pt-0 col-span-2">
                    <textarea placeholder="Descripcion del profesor" class="w-16 h-16 px-3 py-2 text-base placeholder-blueGray-300 text-gray-700 placeholder-gray-600 border rounded-lg focus:shadow-outline w-full"></textarea>
                </div>            
                <div class="pt-0 col-span-4">
                    <h3>Idiomas</h3>
                </div>            
                <div class="pt-0 col-span-4 grid grid-cols-4">
                    <h3 class="col-span-4">Juegos</h3>
                    <div>
                        <h4>Nombre de juego</h4>
                        <ul>
                            <li>
                                <label>Habilidad
                                    <input type="checkbox" name="" id="">
                                </label>
                            </li>
                            <li>
                                <label>Habilidad
                                    <input type="checkbox" name="" id="">
                                </label>
                            </li>
                            <li>
                                <label>Habilidad
                                    <input type="checkbox" name="" id="">
                                </label>
                            </li>
                            <li>
                                <label>Habilidad
                                    <input type="checkbox" name="" id="">
                                </label>
                            </li>
                            
                        </ul>
                    </div>
                    <div>
                        <h4>Nombre de juego</h4>
                        <ul>
                            <li>
                                <label>Habilidad
                                    <input type="checkbox" name="" id="">
                                </label>
                            </li>
                            <li>
                                <label>Habilidad
                                    <input type="checkbox" name="" id="">
                                </label>
                            </li>
                            <li>
                                <label>Habilidad
                                    <input type="checkbox" name="" id="">
                                </label>
                            </li>
                            <li>
                                <label>Habilidad
                                    <input type="checkbox" name="" id="">
                                </label>
                            </li>
                            
                        </ul>
                    </div>
                    <div>
                        <h4>Nombre de juego</h4>
                        <ul>
                            <li>
                                <label>Habilidad
                                    <input type="checkbox" name="" id="">
                                </label>
                            </li>
                            <li>
                                <label>Habilidad
                                    <input type="checkbox" name="" id="">
                                </label>
                            </li>
                            <li>
                                <label>Habilidad
                                    <input type="checkbox" name="" id="">
                                </label>
                            </li>
                            <li>
                                <label>Habilidad
                                    <input type="checkbox" name="" id="">
                                </label>
                            </li>
                            
                        </ul>
                    </div>
                </div>            
                <div class="pt-0">
                    <h3>Precio por modalidad</h3>
                    <ul>
                        <li>
                            <label class="grid">
                                <span>
                                    Online
                                </span>
                                <input type="text" name="" id="">
                            </label>
                        </li>
                        <li>
                            <label class="grid">
                                <span>
                                    Offline
                                </span>
                                <input type="text" name="" id="">
                            </label>
                        </li>
                        <li>
                            <label class="grid">
                                <span>
                                    Pack x4 Online
                                </span>
                                <input type="text" name="" id="">
                            </label>
                        </li>
                    </ul>
                </div>  
                <div class="pt-0">
                    <h3>Disponibilidad</h3>
                    <ul>
                        <li>
                            <label class="grid">
                                <span>
                                    Mañana de (8 a 12hs)
                                </span>
                                <input type="text" name="" id="">
                            </label>
                        </li>
                        <li>
                            <label class="grid">
                                <span>
                                    Tarde de (13 a 18hs)
                                </span>
                                <input type="text" name="" id="">
                            </label>
                        </li>
                        <li>
                            <label class="grid">
                                <span>
                                    Noche de (19 a 00hs)
                                </span>
                                <input type="text" name="" id="">
                            </label>
                        </li>
                    </ul>
                </div>           
                <div class="pt-0">
                    <h3>Logros</h3>
                    <ul>
                        <li>
                            <input type="text" placeholder="titulo" name="" id="">
                            <input type="text" placeholder="descripción" name="" id="">
                        </li>
                        <li>
                            <input type="text" placeholder="titulo" name="" id="">
                            <input type="text" placeholder="descripción" name="" id="">
                        </li>
                        <li>
                            <input type="text" placeholder="titulo" name="" id="">
                            <input type="text" placeholder="descripción" name="" id="">
                        </li>
                    </ul>
                </div>           
                <div class="pt-0 col-span-2">
                    <h3>Reseñas</h3>
                </div>           
                <div class="pt-0 col-span-2 blog">
                    <h3>Contenido</h3>
                    @component('components.blog.list', [
                    'posts' => []
                    ])
                    @endcomponent  
                </div>           
            </main>
        </form>
    </li>
@endsection

@section('js')
    <script type="module" src={{ asset('js/panel/teachers/details.js') }}></script>
@endsection