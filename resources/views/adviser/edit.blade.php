@extends('layouts.app')
@section('content')
    <div class="header bg-gradient-primary pb-6 pt-5 pt-md-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Crear</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="/home"><i class="fas fa-home"></i></a></li>
                                {{-- <li class="breadcrumb-item"><a href="#">Pac</a></li> --}}
                                <li class="breadcrumb-item active" aria-current="page"><a
                                        href="{{ route('adviser.index') }}">Asesores</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Crear</li>
                            </ol>
                        </nav>
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <p>Corrige los siguientes errores:</p>
                                <ul>
                                    @foreach ($errors->all() as $message)
                                        <li>{{ $message }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <a href="{{ route('adviser.index') }}" class="btn btn-sm btn-neutral">Atras</a>
                        {{-- <a href="#" class="btn btn-sm btn-neutral">Filters</a> --}}
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="main-content" id="panel">
        <!-- Topnav -->

        <!-- Page content -->
        <div class="container-fluid mt--6">



            <div class="card shadow">

                {{-- form --}}
                <div class="card-body">
                    <form method="post" action="{{ route('adviser.update', $adviser) }}">
                        @method('PUT')
                        @csrf

                        <div class="form-group">
                            <label for="dni">DNI</label>
                            <input type="text" class="form-control" id="dni" aria-describedby="dni" name="dni"
                                autocomplete="off" placeholder="DNI" class="form-control-plaintext" required
                                value="{{ old('dni', $adviser->dni) }}">
                        </div>

                        <div class="form-group">
                            <label for="fullName">Nombre Completo</label>
                            <input type="text" class="form-control" id="fullName" aria-describedby="fullName"
                                name="fullName" autocomplete="off" placeholder="Autor" class="form-control-plaintext"
                                value="{{ old('fullName', $adviser->full_name) }}" required>
                        </div>


                        <div class="form-group">
                            <label for="faculty">Facultad</label>
                            <input type="text" class="form-control" id="faculty" aria-describedby="faculty"
                            name="faculty" autocomplete="off" placeholder="Facultad"
                            class="form-control-plaintext" value="{{ old('faculty', $adviser->faculty) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Correo</label>
                            <input type="email" class="form-control" id="email" aria-describedby="email"
                            name="email" autocomplete="off" placeholder="Correo"
                            class="form-control-plaintext" value="{{ old('email', $adviser->email) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="orcid">ORCID</label>
                            <input type="orcid" class="form-control" id="orcid" aria-describedby="orcid"
                            name="orcid" autocomplete="off" placeholder="ORCID"
                            class="form-control-plaintext" value="{{ old('orcid', $adviser->orcid) }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>

            </div>


        </div>
    </div>



    </div>
@endsection
