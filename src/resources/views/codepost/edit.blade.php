@extends('layouts.app')

@section('content')

    <?php
    $textState = $post->state == $post::STATE_PUBLISHED ? "Draft" : "Publish";
    $classState = $post->state == $post::STATE_PUBLISHED ? "warning" : "success";
    $state =  $post->state == $post::STATE_PUBLISHED ? $post::STATE_DRAFT : $post::STATE_PUBLISHED;
    ?>

    <div class="container">

        <h3>Edit Post</h3>
        <h3><span class="label label-{{ $post->state == $post::STATE_PUBLISHED ? "success" : "warning" }}">
                {{$post->state == $post::STATE_PUBLISHED ? "Publish" : "Draft" }}
            </span></h3>
        {!! Form::model(['method'=>'put','route' => [ 'admin.posts.update', $post->id]]) !!}

        <div class="form-group">
            {!! Form::label('title',"Title:") !!}
            {!! Form::text('title',  null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
                {!! Form::label('content', "Content:") !!}
                <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
                <textarea name="content" class="form-control my-editor">
                    {!! old('content') ? old('content') : $post->content !!}
                </textarea>
                <script>
                    var editor_config = {
                        path_absolute : "/",
                        selector: "textarea.my-editor",
                        plugins: [
                            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                            "searchreplace wordcount visualblocks visualchars code fullscreen",
                            "insertdatetime media nonbreaking save table contextmenu directionality",
                            "emoticons template paste textcolor colorpicker textpattern"
                        ],
                        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
                        relative_urls: false,
                        file_browser_callback : function(field_name, url, type, win) {
                            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                            var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                            var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                            if (type == 'image') {
                                cmsURL = cmsURL + "&type=Images";
                            } else {
                                cmsURL = cmsURL + "&type=Files";
                            }

                            tinyMCE.activeEditor.windowManager.open({
                                file : cmsURL,
                                title : 'Filemanager',
                                width : x * 0.8,
                                height : y * 0.8,
                                resizable : "yes",
                                close_previous : "no"
                            });
                        }
                    };

                    tinymce.init(editor_config);
                </script>
            </div>
        </div>

        <div class="form-group">
            {!! Form::submit('Submit', ['class' => 'btn btn-lg btn-block btn-primary ']) !!}
        </div>

        {!! Form::close() !!}
        @can('publish_post')
            {!! Form::open(['method'=>'patch', 'route' => [ 'admin.posts.update_state', $post->id]]) !!}
            <div class="form-group">
                {!! Form::hidden('state', $state) !!}
                {!! Form::submit($textState, ['class' => "btn btn-lg btn-block btn-$classState"]) !!}
            </div>
            {!! Form::close() !!}
        @endcan
    </div>
@endsection