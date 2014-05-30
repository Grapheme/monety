@extends('templates.dashboard')
@section('style')

@stop
@section('content')
<section class=" margin-top-important-10">
	<ul class="nav nav-tabs bordered">
		<li class="active"><a data-toggle="tab" href="#auction">Аукцион</a></li>
		<li><a data-toggle="tab" href="#shop">Магазин</a></li>
	</ul>
	<div class="tab-content" id="lotsTabContent">
		<div id="auction" class="tab-pane fade active in">
		@include('templates.lots',array('lots'=>$auctionLots))
		</div>
		<div id="shop" class="tab-pane fade">
		@include('templates.lots',array('lots'=>$shopLots))
		</div>
	</div>
</section>
@stop
@section('scripts')
	{{HTML::script('js/account/user.js')}}
@stop