{{ Form::open(array('url'=>slink::createAuthLink('news/store'),'role'=>'form','class'=>'smart-form','id'=>'news-form','method'=>'post','files'=>TRUE)) }}
	<div class="row margin-top-10">
		<section class="col col-6">
			<div class="well">
				<header>Для создания новости заполните форму:</header>
				<fieldset>
					<section>
						<label class="label">Название</label>
						<label class="input"> <i class="icon-append fa fa-list-alt"></i>
							{{ Form::text('title','') }}
						</label>
					</section>
				@if(Allow::valid_access('downloads'))
					<section>
						<label class="label">Изображение</label>
						<label class="input input-file" for="file">
							<div class="button"><input type="file" onchange="this.parentNode.nextSibling.value = this.value" name="file">Выбрать</div><input type="text" readonly="" placeholder="Выбирите файл">
						</label>
					</section>
				@endif
					<section>
						<label class="label">Дата публикации новости</label>
						<label class="input"> <i class="icon-append fa fa-calendar"></i>
							{{ Form::text('date_publication',myDateTime::getConvertCurrentDate(),array('data-dateformat'=>'dd.mm.yy','class'=>'datepicker','id'=>'date_publication','data-mask'=>'99.99.9999')) }}
						</label>
					</section>
					<section>
						<label class="label">Анонс</label>
						<label class="input">
							{{ Form::textarea('preview','',array('class'=>'redactor')) }}
						</label>
					</section>
				@if(Allow::valid_access('languages') && !empty($languages))
					<section>
						<label class="label">Язык:</label>
						<label class="select">
							<select class="lang-change" name="language" autocomplete="off">
							@foreach($languages as $language)
								<option value="{{$language['code']}}">{{$language['name']}}</option>
							@endforeach
							</select> <i></i>
						</label>
					</section>
				@endif
				@if(Allow::valid_access('templates'))
					<section>
						<label class="label">Шаблон:</label>
						<label class="select">
							@foreach($templates as $template)
								<?php $temps[$template->name] = $template->name;?>
							@endforeach
							{{ Form::select('template', $temps,'news', array('class'=>'template-change','autocomplete'=>'off')) }} <i></i>
						</label>
					</section>
				@endif
					<section>
						<label class="label">Содержание</label>
						<label class="textarea">
							{{ Form::textarea('content','',array('class'=>'redactor')) }}
						</label>
					</section>
				</fieldset>
				<footer>
					<a class="btn btn-default no-margin regular-10 uppercase pull-left btn-spinner" href="{{URL::previous()}}">
						<i class="fa fa-arrow-left hidden"></i> <span class="btn-response-text">Назад</span>
					</a>
					<button type="submit" autocomplete="off" class="btn btn-success no-margin regular-10 uppercase btn-form-submit">
						<i class="fa fa-spinner fa-spin hidden"></i> <span class="btn-response-text">Создать</span>
					</button>
				</footer>
			</div>
		</section>
	@if(Allow::enabled_module('seo'))
		<section class="col col-6">
			<div class="well">
				@include('modules.seo.news')
			</div>
		</section>
	@endif
	</div>
{{ Form::close() }}