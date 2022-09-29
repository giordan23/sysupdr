@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')

    <div class="container-fluid mt--7">

        <div class="card shadow">
            <nav class="navbar navbar-light bg-light justify-content-between">
                <a class="navbar-brand">Autores</a>
                <form class="form-inline" {{ route('author.index') }} method="get">
                    <input class="form-control mr-sm-2" type="search" name="data" placeholder="Busca nombre o dni"
                        aria-label="Search">
                    <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Buscar</button>
                </form>

                <a href="{{ route('author.create') }}" class="btn btn-sm btn-success">Nuevo</a>

            </nav>
            <form action="{{ route('author.report', ['download' => 'pdf']) }}" method="post">
                @csrf
                @method('POST')
            <div class="form-control">

                    <div class="input-daterange datepicker row align-items-center" data-date-format="yyyy-mm-dd">
                        <div class="col">
                            <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="Fecha de inicio" type="text"
                                        value="{{ date('Y-m-d') }}" id="startDate" name="startDate">
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="Fecha de fin" type="text"
                                        value="{{ date('Y-m-d', strtotime(date('Y-m-d'))) }}" id="endDate"
                                        name="endDate">
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">

                                <button type="submit" class="btn-icon-clipboard" title="Descargar">
                                    <div>
                                        <i class="ni ni-cloud-download-95"></i>
                                        <span>Descargar</span>
                                    </div>
                                </button>

                            </div>
                        </div>

                    </div>
                </div>
            </form>
            <div class="card-body">
                @if (session('notification'))
                    <div class="alert alert-success" role="alert">
                        {{ session('notification') }}
                    </div>
                @endif
            </div>

            <div class="table-responsive">
                <!-- Specialities table -->
                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
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
                            <th class="text-center">
                                OPC
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($authors as $author)
                            <tr>
                                <td class="text-center">
                                    {{ $author->id }}
                                </td>
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
                                    {{ $author->amount_paid }}
                                </td>
                                <td class="text-center">
                                    {{ $author->program }}
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">

                                        <form action="{{ route('author.destroy', $author) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('author.edit', $author) }}"
                                                class="btn btn-sm btn-primary">Editar</a>
                                            {{-- <button type="submit" class="btn btn-sm btn-danger">Eliminar</button> --}}
                                            <input type="submit" value="Elminar" class="btn btn-sm btn-danger"
                                                onclick="return confirm('¡SI ELIMINA UN AUTOR ELIMINARA LOS CERTIFICADOS ASOCIADOS A ESTE!')">

                                        </form>

                                    </div>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

        @include('layouts.footers.auth')
    </div>
@endsection
