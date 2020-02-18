<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{asset('assets/datatables.min.css')}}">
    </head>
    <body>
{{--        @dump($articles)--}}
        <table id="table_id" class="display">
            <thead>
                <tr>
                <th>Title</th>
                <th>Image</th>
                <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $article)
                    <tr>
                        <td><a href="{{$article->link}}" target="_blank">{{$article->title}}</a></td>
                        <td><img src="{{$article->image}}" width=330px, height=220px/, alt="empty"></td>
                        <td>{{$article->date}}</td>
                    </tr>
                @empty
                    <h1 style="color:rgba(169,25,0,0.74);text-align:center">article is empty</h1>
                @endforelse
            </tbody>
        </table>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="{{asset('assets/datatables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/MyScript/workdatatable.js')}}"></script>
</html>
