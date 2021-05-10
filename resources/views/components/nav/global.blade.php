<nav id="nav-id" class="nav-menu">
	<div class="nav-row">
		<a href="#menu" class="sidebar-button open-btn left">
			<i class="icon-link fas fa-bars"></i>
		</a>
		
		<a href="/" class="nav-title logo">
			<img src={{ asset('img/logos/logo-largo.png') }} 
				alt="Game Changer Z Logo"/>
			<h1>GameChangerZ</h1>
		</a>
	</div>

    <div class="nav-row">
		<ul class="nav-menu-list">
			<li>
				<a href="https://www.twitch.tv" target="_blank" class="nav-link">
					@component('components.svg.TwitchSVG')@endcomponent
				</a>
			</li>
			<li>
				<a href="https://www.youtube.com" target="_blank" class="nav-link">
					@component('components.svg.YtSVG')@endcomponent
				</a>
			</li>
			<li>
				<a href="/teachers" class="nav-link">
					<span class="link-text">Profesores</span>
				</a>
			</li>
			<li>
				<a href="/blog" class="nav-link">
					<span class="link-text">Novedades</span>
				</a>
			</li>
			@if (Auth::check())
				<li id="nav-user" class="dropdown closed">
					<a href="/users/{{ Auth::user()->slug }}/profile" class="nav-link dropdown-header dropdown-link">
						@component('components.svg.Group 15SVG')@endcomponent
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
								<span class="link-text">Ver Perfíl</span>
							</a>
						</li>
						<li>
							<a href="/logout" class="nav-link dropdown-link">
								<span class="link-text">Cerrar Sesión</span>
							</a>
						</li>
					</ul>
				</li>
			@endif
			@if (!Auth::check())
				<li>
					<a href="#login" class="nav-link">
						<i class="link-icon fas fa-sign-in-alt"></i>
						<span class="link-text">Ingresar</span>
					</a>
				</li>
			@endif
		</ul>
	</div>

    @component('components.nav.sidebar')@endcomponent
</nav>