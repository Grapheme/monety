@extends('templates.admin.index')

@section('plugins')

    <script src="{{slink::path('system/js/admin/ajax_submit.js')}}"></script>
    <script>

        $('form').ajax_submit('{{slink::createLink('admin/temps/')}}');

    </script>

@stop

@section('content')

    <form action="{{slink::createLink('admin/temps/update/'.$temp->id)}}" class="smart-form">
        <section>
            <label class="label">Name</label>
            <label class="input">
                <input type="text" class="input-lg" name="name" value="{{$temp->name}}">
            </label>
        </section>
        <section>
            <label class="label">Content</label>
            <label class="textarea textarea-resizable">                                         
                <textarea rows="3" class="custom-scroll">{{$temp->content}}</textarea> 
            </label>
        </section>
        <section>
            <button type="submit" class="btn btn-primary">Save</button>
        </section>
    </form>

@stop