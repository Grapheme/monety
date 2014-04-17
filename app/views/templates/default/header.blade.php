<header id="header">
	<div id="logo-group">
		<span id="logo"><a href="/">Monety.PRO</a></span>
	</div>
	<div class="pull-right">
		@if(Auth::check())
		<div id="logout" class="btn-header transparent pull-right">
			<span> <a href="{{url('logout')}}" title="Завершение сеанса"><i class="fa fa-sign-out"></i></a> </span>
		</div>
		<div class="btn-header transparent pull-right">
			<span> <a href="{{url(AuthAccount::getStartPage())}}" title="Личный кабинет"><i class="fa fa-dashboard"></i></a> </span>
		</div>
		@else
			<div class="btn-header transparent pull-right">
				<span> <a href="{{ url('login') }}" title=""><i class="fa fa-user "></i> Вход</a> </span>
			</div>
		@endif
	</div>
</header>