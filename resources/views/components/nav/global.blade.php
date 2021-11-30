<nav id="nav-id" class="nav-menu">
	<div class="nav-row">
		<a href="#menu" class="sidebar-button open-btn left">
			<i class="icon-link fas fa-bars"></i>
		</a>
		
		<a href="/" class="nav-title logo">
			<img src={{ asset('img/logos/028-logotipo_original.png') }} 
				alt="Game Changer Z Logo"/>
			<h1>Gamechangerz</h1>
		</a>
	</div>

    <div class="nav-row">
		<ul class="nav-menu-list">
			<li>
				<form class="flex justify-center lg:justify-between my-4 py-2 pl-4 pr-2 lg:col-span-8 lg:col-start-2 rounded" action="/users" method="GET">
					@isset($search)
						<input class="rounded landing-search" name="username" placeholder="Busca por nombre, etc" type="search" value="{{ $search->username }}">
					@else
						<input class="rounded landing-search" name="username" placeholder="Busca por nombre, etc" type="search" value="">
					@endisset
				</form>          
			</li>
			<li>
				<a href="{{ \App\Models\Platform::first()->link }}" target="_blank" class="nav-link discord">
					@component('components.svg.DiscordSVG')@endcomponent
				</a>
			</li>
			<li>
				<a href="/teachers" class="nav-link">
					<span class="link-text overpass">Coaches</span>
				</a>
			</li>
			<li>
				<a href="/blog" class="nav-link">
					<span class="link-text overpass">Contenido</span>
				</a>
			</li>
			<li>
				<a href="/faq" class="nav-link">
					<span class="link-text overpass">Cómo funciona</span>
				</a>
			</li>
			@if (Auth::check())
				{{-- @if (count($notifications))
					<li id="nav-notification" class="notifications dropdown closed">
						<a href="#" class="nav-link dropdown-header dropdown-link">
							<i class="fas fa-bell"></i>
							<span class="quantity overpass text-sm ml-1">{{ count($notifications) }}</span>
						</a>
						<ul class="dropdown-content px-4">
							@foreach ($notifications as $notification)
								<li>
									@if (isset($notification->data['link']))
										<a href="{{ $notification->data['link'] }}" class="nav-link dropdown-link">
											<span class="link-text overpass">{{ $notification->data['message'] }}</span>
										</a>
									@endif
									@if (!isset($notification->data['link']))
										<p class="nav-link dropdown-link">
											<span class="link-text overpass">{{ $notification->data['message'] }}</span>
										</p>
									@endif
								</li>
							@endforeach
						</ul>
					</li>
				@endif
				@if (!count($notifications))
					<li id="nav-notification" class="notifications">
						<span class="nav-link">
							<i class="fas fa-bell"></i>
						</span>
					</li>
				@endif --}}
				<li id="nav-user" class="dropdown closed">
					<a href="/users/{{ Auth::user()->slug }}/profile" class="nav-link dropdown-header dropdown-link">
						@if (Auth::user()->profile())
							<figure class="profile-image">
								<img src={{ asset("storage/". Auth::user()->profile()) }} alt="{{ Auth::user()->username }} profile image">
							</figure>
						@endif
						@if (!Auth::user()->profile())
							@component('components.svg.ProfileSVG')@endcomponent
						@endif
					</a>
					<ul class="dropdown-content px-4">
						@if (Auth::user()->credits)
							<li>
								<span class="nav-link">
									<span class="link-text">{{ Auth::user()->credits }} Créditos</span>
								</span>
							</li>
						@endif
						<li>
							<a href="/users/{{ Auth::user()->slug }}/profile" class="nav-link dropdown-link">
								<span class="link-text overpass">Ver Perfíl</span>
							</a>
						</li>
						<li>
							<a href="/users/{{ Auth::user()->slug }}/profile#advanced" class="nav-link dropdown-link">
								<span class="link-text overpass">Configuración Avanzada</span>
							</a>
						</li>
						<li>
							<a href="/logout" class="nav-link dropdown-link">
								<span class="link-text overpass">Cerrar Sesión</span>
							</a>
						</li>
					</ul>
				</li>
			@endif
			@if (!Auth::check())
				<li>
					<a href="#login" class="nav-link">
						<i class="link-icon fas fa-sign-in-alt"></i>
						<span class="link-text overpass">Ingresar</span>
					</a>
				</li>
			@endif
		</ul>
	</div>

    @component('components.nav.sidebar')@endcomponent
</nav>