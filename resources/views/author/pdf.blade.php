<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Autores</title>
</head>

<body>
    <header class="header text-center">
        <h1>Autores Registrados</h1>
        <span>Monto Total: S/. {{ $total }}</span>
    </header>
    <table class="table table-bordered text-center">
        <thead>
            <tr class="table-active">
                <th class="text-center">
                    Nº
                </th>
                <th class="text-center">
                    Nombres
                </th>
                <th class="text-center">
                    Dni
                </th>
                <th class="text-center">
                    Nº Boucher
                </th>
                <th class="text-center">
                    Monto Pagado
                </th>
                <th class="text-center">
                    Programa
                </th>
            </tr>
        </thead>
        <tbody>
            @php

                {{ $i=1; }}
            @endphp
            {{-- @while ($i<=count($authors)); --}}


            @foreach ($authors as $author)

                    <tr>
                        <th scope="row">{{ $author->id }}</th>
                        <td class="text-center">
                            {{ $author->full_name }}
                        </td>
                        <td class="text-center">
                            {{ $author->dni }}
                        </td>
                        <td class="text-center">
                            {{ $author->n_boucher }}
                        </td>
                        <td class="text-center">
                            S/. {{ $author->amount_paid }}
                        </td>
                        <td class="text-center">
                            {{ $author->program }}
                        </td>
                    </tr>


                @endforeach
                {{-- @endwhile --}}
        </tbody>
    </table>
</body>

</html>
