<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $file }}</title>
    </head>
    <body>
        <h1> Log : {{$file}} </h1>
        <pre> 
{{$content}}
        </pre>
        <hr/>
        @if($route !== null)
        <form action="{{$route}}" method="POST" style="margin:16px;">
            @csrf
            <input type="submit" value="Effacer le fichier" style="color: red; font-weight: 800; font-size: large; padding: 16px;" />
        </form>
        @endif
    </body>
</html>
