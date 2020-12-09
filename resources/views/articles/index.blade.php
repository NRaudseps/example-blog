@extends('layouts.app')
@section('content')
    <div class="container">
        <div style="display: flex">
            <a href="{{ route('articles.create') }}" class="btn btn-primary btn-sm">
                Create new article
            </a>
            <form action="/articles/lazy" method="post">
                @csrf

                <button type="submit" class="btn btn-primary btn-sm" style="margin-left: 20px;">The Lazy Button</button>
            </form>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Created at</th>
                <th scope="col">Updated at</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($articles as $article)
                <tr>
                    <th scope="row">{{ $article->id }}</th>
                    <td>
                        <a href="{{ route('articles.show', $article) }}">
                            {{ $article->title }}
                        </a>
                    </td>
                    <td>{{ $article->created_at->format('Y-m-d h:i') }}</td>
                    <td>{{ $article->updated_at->format('Y-m-d h:i') }}</td>
                    <td>
                        @can('update', $article)
                            <a href="{{ route('articles.edit', $article) }}" class="btn btn-sm btn-warning">
                                Edit
                            </a>
                        @endcan
                        @can('delete', $article)
                            <form method="post" action="{{ route('articles.destroy', $article) }}"
                                  style="display: inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure?')">
                                    Delete
                                </button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function startTime() {
            var today = new Date();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
            m = checkTime(m);
            s = checkTime(s);
            document.getElementById('txt').innerHTML =
                h + ":" + m + ":" + s;
            var t = setTimeout(startTime, 500);
        }
        function checkTime(i) {
            if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
            return i;
        }
    </script>
    </head>

    <body onload="startTime()">

    <div id="txt"></div>

@endsection
