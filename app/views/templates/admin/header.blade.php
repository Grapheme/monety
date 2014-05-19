<header id="header">
	<div id="logo-group"></div>
	<nav role="navigation" class="navbar navbar-default navbar-fixed-top">
		<div class="navbar-header">
			<a href="{{ url(AuthAccount::getStartPage()) }}" class="navbar-brand">Панель управления</a>
		</div>
		<div class="nav navbar-top-links navbar-right margin-top-5">
			<li class="dropdown">
				<a href="#" data-toggle="dropdown" class="dropdown-toggle">
					<i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
				</a>
				<ul class="dropdown-menu dropdown-user">
					<li><a href="#"><i class="fa fa-user fa-fw"></i> Профиль</a></li>
					<li class="divider"></li>
					<li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Завершить сеанс</a>
					</li>
				</ul>
			</li>
		</div>
	</nav>
</header>