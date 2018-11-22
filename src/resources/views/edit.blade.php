@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Edit Post</h3>

        {!! Form::model($post, ['method'=>'put', 'route'=> 'admin.posts.update', $post->id]) !!}

        <div class="form-group">
            {!! Form::label('Title', "Title") !!}
            {!! Form::text('title', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('Content', "Content") !!}
            {!! From::textarea('content', null, ['class'=>'form-control'])!!}
        </div>

        <div class="form-group">
            {!! Form::submit('Submit'. ['class'=>'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

    </div>
@endsection