{{ Form::open(array('url'=>slink::createAuthLink('news/send-comment/store'),'role'=>'form','class'=>'smart-form','id'=>'send-comment-form','method'=>'post')) }}
	{{ Form::hidden('item_id',$news->id) }}
	{{ Form::hidden('module_id',Modules::whereUrl('news')->first()->id) }}
	<section>
		<label class="label"></label>
		<label class="textarea">
			{{ Form::textarea('comment','',array('cols'=>80)) }}
		</label>
	</section>
	<button type="submit" autocomplete="off" class="comment-btn btn-form-submit">
		<i class="fa fa-spinner fa-spin hidden"></i> <span class="btn-response-text">Отправить</span>
	</button>
{{ Form::close(); }}