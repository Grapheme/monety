<div id="register-lot-form-search" class="margin-bottom-10" {{ Input::has('product_id') ? 'style="display: none;"' : '' }}>
	{{ Form::open(array('url'=>slink::createAuthLink('register-lot/search-products'),'role'=>'form','class'=>'smart-form','id'=>'search-product-form','method'=>'post')) }}
		<header>Воспользуйтесь поиском для выставления Вашего лота:</header>
		<fieldset>
			<section>
				<label class="label">Введите название товарной позиции</label>
				<label class="input">
					{{ Form::text('product_name','') }}
				</label>
			</section>
		</fieldset>
		<footer>
			<button type="submit" autocomplete="off" class="btn btn-success no-margin regular-10 uppercase btn-form-submit">
				<i class="fa fa-spinner fa-spin hidden"></i> <span class="btn-response-text">Поиск</span>
			</button>
		</footer>
	{{ Form::close() }}
</div>
<div class="margin-top-10" id="register-lot-form-search-response">{{ Input::has('product_id') ? $product : '' }}</div>
<div id="register-lot-properties" {{ Input::has('product_id') ? '' : 'style="display: none;"' }}>
	{{ Form::open(array('url'=>slink::createAuthLink('register-lot/store'),'role'=>'form','class'=>'smart-form','id'=>'register-lot-form','method'=>'post')) }}
		{{ Form::hidden('product_id',$product_id,array('id'=>'register-lot-product-id')) }}
		<header>Чтобы выставить лот заполните форму:</header>
		<fieldset>
			<ul class="nav nav-tabs bordered">
				<li class="active">
					<a data-toggle="tab" href="#data">Данные</a>
				</li>
			@if(Allow::valid_access('downloads'))
				<li>
					<a data-toggle="tab" href="#images">Изображения</a>
				</li>
			@endif
			</ul>
			<div class="tab-content margin-top-important-10" id="productTabContent">
				<div id="data" class="tab-pane fade active in">
					<section>
						<label class="label">Название лота</label>
						<label class="input"> <i class="icon-append fa fa-list-alt"></i>
							{{ Form::text('title','') }}
						</label>
					</section>
			@if(!empty($productsExtendedAttributes))
				@foreach($productsExtendedAttributes as $attrName => $attributes)
					<section>
						<?php $productAttr = array();?>
						<label class="label">{{ $attrName }}</label>
						<label class="select">
							@foreach($attributes as $attribute)
								<?php $productAttr[$attribute->title] = $attribute->title;?>
							@endforeach
							{{ Form::select('attribute['.$attrName.']',$productAttr,NULL,array('autocomplete'=>'off','class'=>'select2')) }}
						</label>
					</section>
				@endforeach
			@endif
					<section>
						<label class="label">Описание лота</label>
						<label class="textarea">
							{{ Form::textarea('description','',array('class'=>'redactor')) }}
						</label>
					</section>
					<section>
						<label class="label">Способ продажи</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio">
									<input type="radio" autocomplete="off" id="lot-in-shop" value="1" name="type_lot">
									<i></i>
									Выставить товар в магазин
								</label>
								<div class="note">Товар будет выставлен по фиксированной цене.</div>
							</div>	
						</div>
						<div class="row">
							<div class="col col-12">
								<label class="radio">
									<input type="radio" autocomplete="off" id="lot-in-auction" value="2" name="type_lot">
									<i></i>
									Выставить товар на аукцион
								</label>
								<div class="note">Товар будет выставлен на торги. Покупателем станет участник, предложивший наивысшую цену.</div>
							</div>
						</div>
					</section>
					<div id="lot-properties" style="display: none;">
						<section class="lot-properties-in-shop lot-properties-in-auction">
							<label class="label">Количество, шт.</label>
							<label class="input"><i class="icon-append fa fa-list-alt"></i>
								{{ Form::text('quantity','') }}
							</label>
						</section>
						<section class="lot-properties-in-shop">
							<label class="label">Цена, руб.</label>
							<label class="input"><i class="icon-append fa fa-ruble"></i>
								{{ Form::text('shop_price','') }}
							</label>
							<div class="note">За одну монету</div>
						</section>
						<section class="lot-properties-in-auction">
							<label class="label">Начальная цена, руб.</label>
							<label class="input"><i class="icon-append fa fa-ruble"></i>
								{{ Form::text('auction_start_price','') }}
							</label>
						</section>
						<section class="lot-properties-in-auction">
							<label class="label">Цена, руб.</label>
							<label class="input"><i class="icon-append fa fa-ruble"></i>
								{{ Form::text('auction_blitc_price','') }}
							</label>
							<div class="note">Купить сейчас!</div>
						</section>
						<section class="lot-properties-in-auction">
							<label class="label">Длительность, дни</label>
							<label class="select">
								<?php $auctionPeriod = array(3,5,7,10,14,21);?>
								{{ Form::select('auction_period',$auctionPeriod,NULL,array('autocomplete'=>'off')) }} <i></i>
							</label>
						</section>
					</div>
				</div>
			@if(Allow::valid_access('downloads'))
				<div id="images" class="tab-pane fade">
					<div action="{{ slink::createAuthLink('register-lot/upload-lot-photo') }}" class="dropzone dz-clickable" id="ProductImageDropZone"></div>
				</div>
			@endif
			</div>
		</fieldset>
		<footer>
			<button type="submit" autocomplete="off" class="btn btn-success no-margin regular-10 uppercase btn-form-submit">
				<i class="fa fa-spinner fa-spin hidden"></i> <span class="btn-response-text">Выставить лот</span>
			</button>
		</footer>
	{{ Form::close() }}
</div>