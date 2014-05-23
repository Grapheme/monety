{{ Form::open(array('url'=>slink::createAuthLink('register-lot/store'),'role'=>'form','class'=>'smart-form','id'=>'register-lot-form','method'=>'post')) }}
	<div class="row margin-top-10">
		<section class="col col-6">
			<div class="well">
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
					<div class="tab-content padding-10" id="productTabContent">
						<div id="data" class="tab-pane fade active in">
							<section>
								<label class="label">Название лота</label>
								<label class="input"> <i class="icon-append fa fa-list-alt"></i>
									{{ Form::text('name','') }}
								</label>
							</section>
						@if(!empty($categories))
							<section>
								<label class="label">Категория:</label>
								<label class="select">
									<select class="category-change" name="category" autocomplete="off">
									@foreach($categories as $category_title => $category)
										<optgroup label="{{ $category_title }}">
										@if(!empty($category['sub_categories']))
											@foreach($category['sub_categories'] as $sub_category)
											<option value="{{ $sub_category['id'] }}">{{ $sub_category['title'] }}</option>
											@endforeach
										@endif
										</optgroup>
									@endforeach
									</select> <i></i>
								</label>
							</section>
						@else
							{{ Form::hidden('category',0) }}
						@endif
					@if(!empty($productsExtendedAttributes))
						@foreach($productsExtendedAttributes as $attrName => $attributes)
							<section>
								<?php $productAttr = array();?>
								<label class="label">{{ $attrName }}</label>
								<label class="select">
									@foreach($attributes as $attribute)
										<?php $productAttr[$attribute->title] = $attribute->title;?>
									@endforeach
									{{ Form::select('attribute['.$attrName.']',$productAttr,NULL,array('autocomplete'=>'off')) }} <i></i>
								</label>
							</section>
						@endforeach
					@endif
							<section>
								<label class="label">Содержание</label>
								<label class="textarea">
									{{ Form::textarea('content','',array('class'=>'redactor')) }}
								</label>
							</section>
							<section>
								<label class="label">Способ продажи</label>
								<div class="inline-group">
									<label class="radio">
										<input type="radio" id="lot-in-shop" name="radio-inline"><i></i>Выставить товар в магазин
									</label>
									<div class="note">
										Товар будет выставлен по фиксированной цене.
									</div>
									<label class="radio">
										<input type="radio" id="lot-in-auction" name="radio-inline"><i></i>Выставить товар на аукцион
									</label>
									<div class="note">
										Товар будет выставлен на торги. Покупателем станет участник, предложивший наивысшую цену.
									</div>
								</div>
							</section>
						</div>
					@if(Allow::valid_access('downloads'))
						<div id="images" class="tab-pane fade">
							<div action="{{ slink::createAuthLink('catalogs/products/upload-product-photo') }}" class="dropzone dz-clickable" id="ProductImageDropZone"></div>
						</div>
					@endif
					</div>
				</fieldset>
				<footer>
					<button type="submit" autocomplete="off" class="btn btn-success no-margin regular-10 uppercase btn-form-submit">
						<i class="fa fa-spinner fa-spin hidden"></i> <span class="btn-response-text">Далее</span>
					</button>
				</footer>
			</div>
		</section>
	</div>
{{ Form::close() }}