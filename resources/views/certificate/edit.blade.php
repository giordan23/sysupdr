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
                                        href="{{ route('certificate.index') }}">Certificados</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Crear</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <a href="{{ route('certificate.index') }}" class="btn btn-sm btn-neutral">Atras</a>
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
                    <form method="post" action="{{ route('certificate.update', $certificate) }}">
                        @method('PUT')
                        @csrf

                        <div class="form-group">
                            <label for="title">Titulo</label>
                            <input type="text" class="form-control" id="title" aria-describedby="title"
                                name="title" autocomplete="off" placeholder="Titulo" class="form-control-plaintext"
                                required value="{{ old('title', $certificate->title) }}">
                        </div>

                        <div class="form-group">
                            <label for="author">Autor</label>
                            <input list="author" name="author" class="form-control selectpicker"
                                placeholder="Dni o nombre del autor" autocomplete="off" required
                                value="{{ $certificate->authors->id }}-{{ $certificate->authors->full_name }}">
                            <datalist id="author">
                                @foreach ($authors as $author)
                                    <option value="{{ $author->id }}-{{ $author->full_name }}">
                                        {{ $author->dni }}-{{ $author->full_name }}
                                    </option>
                                @endforeach
                            </datalist>
                        </div>

                        <div class="form-group">
                            <label for="adviser">Asesor</label>
                            <input list="adviser" name="adviser" class="form-control selectpicker"
                                placeholder="Dni o nombre del asesor" autocomplete="off" required
                                value="{{ $certificate->advisers->id }}-{{ $certificate->advisers->full_name }}">
                            <datalist id="adviser">
                                @foreach ($advisers as $adviser)
                                    <option value="{{ $adviser->id }}-{{ $adviser->full_name }}">
                                        {{ $adviser->dni }}-{{ $adviser->full_name }}
                                    </option>
                                @endforeach
                            </datalist>
                        </div>

                        <div class="form-group">
                            <label for="program">Programa</label>
                            <select class="form-control" name="program">
                                <option value="{{ $certificate->program }}">{{ $certificate->program }}</option>
                                @foreach ($certificate_types as $certificate_type)
                                    @if ($certificate->program != $certificate_type)
                                        <option value="{{ $certificate_type }}">{{ ucwords($certificate_type) }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="denominacion_id">Denominacion</label>
                            <input value="{{ $certificate->denominacion->nombre }}" list="denominacion_id"
                                name="denominacion_id" id="denominacion_ide" class="form-control selectpicker"
                                placeholder="Denominación del grado" autocomplete="off" required>
                            <input id="denominacion_ided" type="hidden" name="denominacion_ided">
                            <datalist name="denominacion_id" id="denominacion_id">
                                <option value="{{ $certificate->denominacion->nombre }}">
                                    {{ $certificate->denominacion->nombre }}</option>
                                @foreach ($denominations as $denomination)
                                    @if ($certificate->denominacion->nombre != $denomination->nombre)
                                        <option value="{{ $denomination->nombre }}">{{ ucwords($denomination->nombre) }}
                                        </option>
                                    @endif
                                @endforeach
                            </datalist>
                        </div>
                        <div class="form-group">
                            <label for="originality">Originalidad</label>
                            <input type="text" class="form-control" id="originality" aria-describedby="originality"
                                name="originality" autocomplete="off" placeholder="Originalidad"
                                class="form-control-plaintext" required value="{{ $certificate->originality }}">

                        </div>
                        <div class="form-group">
                            <label for="similitude">Similitud</label>
                            <input type="text" class="form-control" id="similitude" aria-describedby="similitude"
                                name="similitude" autocomplete="off" placeholder="Similitud" class="form-control-plaintext"
                                required value="{{ $certificate->similitude }}">

                        </div>
                        <div class="form-group">
                            <label for="originality">Fecha</label>
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                </div>
                                <input type="date" class="form-control" id="date" aria-describedby="date"
                                    name="date" autocomplete="off" placeholder="Similitud"
                                    class="form-control-plaintext" required value="{{ $certificate->date }}">
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="resolucion">Resolución</label>
                            <div class="input-group input-group-alternative">
                                <div class="custom-file" id="customFile">
                                    <input type="file" class="custom-file-input" name="resolucion" id="resolucion">
                                    <label class="custom-file-label" for="resolucion">
                                        @if ($certificate->resolucion_ruta)
                                            {{ $file_name }}
                                        @elseif (!$certificate->resolucion_ruta)
                                            Seleccionar Archivo
                                        @endif
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="observation">Observación</label>
                            <textarea class="form-control" name="observation" type="text" id="observation">{{ $certificate->observation }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>

            </div>


        </div>
    </div>
    </div>
    @push('js')
        <script>
            document.querySelector('.custom-file-input').addEventListener('change', function(e) {
                var fileName = document.getElementById("resolucion").files[0].name;
                var nextSibling = e.target.nextElementSibling
                nextSibling.innerText = fileName
            })
        </script>
    @endpush
@endsection
