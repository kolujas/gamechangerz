<nav id="nav-id" class="nav-menu">
	<div class="nav-row">
		<a href="#menu" class="sidebar-button open-btn left">
			<span class="link-text">Menu</span>
		</a>
		
		<a href="/" class="nav-title">
			<h1>NavMenuJS</h1>
		</a>
	</div>

    <div class="nav-row">
		<ul class="nav-menu-list">
			<li>
				<a href="/" class="nav-link">
					<span class="link-text">Home</span>
				</a>
			</li>
			<li>
				<a href="/log-in" class="nav-link">
					<span class="link-text">Log In</span>
				</a>
			</li>
		</ul>
	</div>

    @component('components.nav.sidebar')
	@endcomponent
</nav>