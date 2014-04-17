<aside id="left-panel">
	<nav>
		<ul>
	@foreach(SystemModules::getSidebarModules() as $name => $module)
		@if(!Modules::where('url',$name)->exists())
			@if(empty($module[2]) || allow::valid_access($module[2]))
				<li{{ (slink::segment(2) == $name)?' class="active"':''}}>
					<a href="{{slink::createLink($name)}}" title="{{{$module[0]}}}">
						<i class="fa fa-lg fa-fw {{$module[1]}}"></i> <span class="menu-item-parent">{{{$module[0]}}}</span>
					</a>
				</li>
			@endif
		@endif
	@endforeach
		</ul>
	</nav>
	<span class="minifyme"> <i class="fa fa-arrow-circle-left hit"></i> </span>
</aside>