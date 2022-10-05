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
                    <form method="post" action="{{ route('certificate.store') }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf

                        <div class="form-group">
                            <label for="title">Titulo</label>
                            <input type="text" class="form-control" id="title" aria-describedby="title"
                                name="title" autocomplete="off" placeholder="Titulo" class="form-control-plaintext"
                                value="{{ old('title') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="author">Autor</label>
                            <input list="author" name="author" id="authore" class="form-control selectpicker"
                                placeholder="Dni o nombre del autor" autocomplete="off" required>
                            <input id="authored" type="hidden" name="authored">
                            <datalist id="author">
                                @foreach ($authors as $author)
                                    <option value="{{ $author->id }}-{{ $author->full_name }}">
                                        {{ $author->dni }}-{{ $author->full_name }}
                                    </option>
                                @endforeach
                            </datalist>
                            <div class="custom-control custom-control-alternative custom-checkbox mb-3">
                                <input class="custom-control-input" id="add_author" type="checkbox" onclick="addAuthor()">
                                <label class="custom-control-label" for="add_author">Segungo Autor</label>
                            </div>
                            <div id="content" style="display: none;">
                                <label for="author2">2º Autor</label>
                                <input list="author2" name="author2" id="authore2" class="form-control selectpicker"
                                    placeholder="Dni o nombre del autor" autocomplete="off">
                                <input id="authored2" type="hidden" name="authored2">
                                <datalist id="author2">
                                    @foreach ($authors as $author)
                                        <option value="{{ $author->id }}-{{ $author->full_name }}">
                                            {{ $author->dni }}-{{ $author->full_name }}
                                        </option>
                                    @endforeach
                                </datalist>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="adviser">Asesor</label>
                            <input list="adviser" name="adviser" id="advisere" class="form-control selectpicker"
                                placeholder="Dni o nombre del asesor" autocomplete="off" required>
                            <input id="advisered" type="hidden" name="advisered">
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
                            <input list="program" name="program" id="programe" class="form-control selectpicker"
                                placeholder="Programa" autocomplete="off" required>
                            <input id="programed" type="hidden" name="programed">
                            <datalist name="program" id="program">
                                @foreach ($certificate_types as $certificate_type)
                                    <option value="{{ $certificate_type }}">{{ ucwords($certificate_type) }}</option>
                                @endforeach
                            </datalist>
                        </div>

                        {{-- <div class="form-group">
                            <label for="faculty">Facultad</label>
                            <input type="text" class="form-control" id="faculty" aria-describedby="faculty"
                                name="faculty" autocomplete="off" placeholder="Facultad" class="form-control-plaintext"
                                required value="{{ old('faculty') }}">
                        </div> --}}
                        <div class="form-group">
                            <label for="denominacion_id">Denominacion</label>
                            <input list="denominacion_id" name="denominacion_id" id="denominacion_ide"
                                class="form-control selectpicker" placeholder="Denominación del grado" autocomplete="off"
                                required>
                            <input id="denominacion_ided" type="hidden" name="denominacion_ided">
                            <datalist name="denominacion_id" id="denominacion_id">
                                {{-- <option value="">Selecione...</option> --}}
                                @foreach ($denominations as $denomination)
                                    <option value="{{ $denomination->nombre }}">{{ ucwords($denomination->nombre) }}
                                    </option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="form-group">
                            <label for="similitude">Similitud</label>
                            <input type="number" step="0.01" class="form-control" id="similitude"
                                aria-describedby="similitude" name="similitude" autocomplete="off"
                                placeholder="Similitud" class="form-control-plaintext" required
                                value="{{ old('similitude', 0) }}" onclick="porcentaje()">

                        </div>
                        <div class="form-group">
                            <label for="originality">Originalidad</label>
                            <input type="number" step="0.01" class="form-control" id="originality"
                                aria-describedby="originality" name="originality" autocomplete="off"
                                placeholder="Originalidad" class="form-control-plaintext" required
                                value="{{ old('originality', 100) }}" onclick="porcentaje()">

                        </div>
                        <div class="form-group">
                            <label for="originality">Fecha</label>
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                </div>
                                <input class="form-control datepicker" data-date-format="yyyy-mm-dd" name="date"
                                    placeholder="Selecciona" type="text" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="originality">Resolución</label>
                            <div class="input-group input-group-alternative">
                                <div class="custom-file" id="customFile">
                                    <input type="file" class="custom-file-input" name="resolucion" id="resolucion"
                                        aria-describedby="fileHelp">
                                    <label class="custom-file-label" for="resolucion">
                                        Seleccionar Archivo
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="observation">Observación</label>
                            <textarea class="form-control" name="observation" type="text" id="observation">{{ old('observation') }}</textarea>


                        </div>

                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>

            </div>


        </div>
    </div>



    </div>
@endsection
@push('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script>
        $("#authore").bind("keyup keydown change", function() {
            var value = $(this).val();
            var justId = value.split("-")
            $('#authored').val(justId[0]);

        });

        $("#advisere").bind("keyup keydown change", function() {
            var value3 = $(this).val();
            var justId3 = value3.split("-")
            $('#advisered').val(justId3[0]);

        });
    </script>
    <script>
        function addAuthor() {
            var checkBox = document.getElementById("add_author");
            var author_sec = document.getElementById("content");
            if (checkBox.checked == true) {
                author_sec.style.display = "block";
                $("#authore2").bind("keyup keydown change", function() {
                    var value2 = $(this).val();
                    var justId2 = value2.split("-")
                    $('#authored2').val(justId2[0]);

                });
            } else {
                author_sec.style.display = "none";
            }
        }
    </script>
    <script>
        function porcentaje() {
            var similitude = document.getElementById("similitude").value;
            // var similitude = document.getElementById("similitude").value;
            var cien = 100;
            try {
                totalP = cien - (similitude);
                if (totalP < 0) {
                    similitude.value = "0";
                } else {
                    document.getElementById("originality").value = totalP;
                }
            } catch (e) {}
        }
    </script>
    <script>
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = document.getElementById("resolucion").files[0].name;
            var nextSibling = e.target.nextElementSibling
            nextSibling.innerText = fileName
        })
    </script>
@endpush
