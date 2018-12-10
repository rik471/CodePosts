@extends('layouts.app')

@section('content')

    <div class="container">
        <h3>Posts</h3>

        <a href="{{ route('admin.posts.create') }}">Create Post</a>
        <br><br>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Content</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach($posts as $key => $post)
                    <tr>
                        <td>{{$post->id}}</td>
                        <td>{{$post->title}}</td>
                        <td>{{str_limit($post->content, 50)}}...</td>
                        <td>
                            <a name="link_edit_post_{{$key}}" href="{{route('admin.posts.edit', ['id'=>$post->id])}}">
                                Edit
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection