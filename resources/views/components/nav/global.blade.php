<nav id="nav-id" class="nav-menu">
	<div class="nav-row">
		<a href="#menu" class="sidebar-button open-btn left">
			<span class="link-text">Menu</span>
		</a>
		
		<a href="/" class="nav-title">
			<h1>GameChangerz</h1>
		</a>
	</div>

    <div class="nav-row">
		<ul class="nav-menu-list">
			<li>
				<a href="https://www.twitch.tv" target="_blank" class="nav-link">
					@component('components.svg.TwitchSVG')
					@endcomponent
				</a>
			</li>
			<li>
				<a href="https://www.youtube.com" target="_blank" class="nav-link">
					@component('components.svg.YtSVG')
					@endcomponent
				</a>
			</li>
			<li>
				<a href="/profesores" class="nav-link">
					<span class="link-text">Profesores</span>
				</a>
			</li>
			<li>
				<a href="/blog" class="nav-link">
					<span class="link-text">Novedades</span>
				</a>
			</li>
			@if (Auth::check())
				@if (Auth::user()->credits)
					<li>
						<span class="nav-link">
							<span class="link-text">200 Créditos</span>
						</span>
					</li>
				@endif
				<li>
					<a href="/user/{Auth::user()->slug}/profile" class="nav-link">
						@component('components.svg.Group 15SVG')
						@endcomponent
					</a>
				</li>
			@else
				<li>
					<a href="/blog" class="nav-link">
						<i class="link-icon">I</i>
						<span class="link-text">Ingresar</span>
					</a>
				</li>
			@endif
		</ul>
	</div>

    @component('components.nav.sidebar')
	@endcomponent
</nav>