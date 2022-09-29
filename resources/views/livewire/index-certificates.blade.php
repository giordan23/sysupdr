<div class="container-fluid mt--7">

    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="mb-0">{{ __('Certificados') }}</h3>
                </div>
            </div>
            <div class="row align-items-center pt-3">
                {{-- <form class="form-inline" {{ route('certificate.index') }} method="get"> --}}
                <div class="col-4">
                    <label class="small" for="">Filtro por programa</label>
                    <select wire:model="certificate_filter" class="form-control" type="search" name="data"
                        placeholder="Buscar" aria-label="Search">
                        <option value="all">==Todos==</option>
                        @foreach ($certificate_types as $certificate_type)
                            <option value="{{ $certificate_type }}">{{ $certificate_type }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-4">
                    <label class="small" for="">Busqueda por titulo, programa o facultad</label>
                    <input wire:model="search" class="form-control" type="search" name="data" placeholder="Buscar"
                        aria-label="Search">
                </div>
                {{-- </form> --}}
                <div class="col text-right pt-3">
                    <a href="{{ route('certificate.create') }}" class="btn btn-md btn-success">Nuevo Certificado</a>
                    {{-- <a href="{{ route('generate-pdf',['download'=>'pdf']) }}" class="btn btn-sm btn-success"> <i class="ni ni-cloud-download-95"></i></a> --}}
                </div>
            </div>
        </div>
        @if (session('notification'))
            <div class="card-body">
                <div class="alert alert-success" role="alert">
                    {{ session('notification') }}
                </div>
            </div>
        @endif

        <div class="table-responsive">
            <!-- Specialities table -->
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">OPC</th>
                        <th class="text-center">Nº</th>
                        <th class="text-center">Title</th>
                        <th class="text-center">Autor</th>
                        <th class="text-center">Asesor</th>
                        <th class="text-center">Programa</th>
                        <th class="text-center">Facultad</th>
                        <th class="text-center">Originalidad</th>
                        <th class="text-center">Similitud</th>
                        <th class="text-center">Fecha</th>
                        <th class="text-center">Codigo</th>
                        <th class="text-center">Observación</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($certificates as $certificate)
                        <tr>
                            <td class="text-center">
                                <div class="dropdown">
                                    <form action="{{ route('certificate.destroy', $certificate) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('certificate.edit', $certificate) }}"
                                            class="btn btn-sm btn-primary">Editar</a>
                                        {{-- <button type="submit" class="btn btn-sm btn-danger">Eliminar</button> --}}
                                        <input type="submit" value="Elminar" class="btn btn-sm btn-danger"
                                            onclick="return confirm('¿Desea elimiar..?')">

                                    </form>

                                    <a href="{{ route('certificate.report', ['download' => 'pdf', 'certificate' => $certificate]) }}"
                                        target="_blank" class="btn btn-sm btn-primary" title="Descargar">
                                        <i class="ni ni-cloud-download-95"></i>

                                    </a>
                                </div>

                            </td>
                            <td class="text-center">
                            </td>

                            <td class="text-center" title="{{ $certificate->title }}">
                                {{ Str::limit($certificate->title, 10, $end = '...') }}

                            </td>
                            <td class="text-center" title="{{ $certificate->authors->full_name }}">
                                {{ Str::limit($certificate->authors->full_name, 10, $end = '...') }}

                                @if ($certificate->authorSecond == null)
                                @else
                                    <br> y {{ Str::limit($certificate->authorSecond->full_name, 10, $end = '...') }}
                                @endif
                            </td>
                            <td class="text-center" title="{{ $certificate->advisers->full_name }}">
                                {{ Str::limit($certificate->advisers->full_name, 10, $end = '...') }}

                            </td>
                            <td class="text-center">
                                {{ $certificate->program }}
                            </td>
                            <td class="text-center" title="{{ $certificate->faculty }}">
                                {{ Str::limit($certificate->faculty, 10, $end = '...') }}
                            </td>
                            <td class="text-center">
                                {{ $certificate->originality }}%
                            </td>
                            <td class="text-center">
                                {{ $certificate->similitude }}%
                            </td>
                            <td class="text-center">
                                {{ $certificate->date }}
                            </td>
                            <td class="text-center">
                                {{ $certificate->document_number }}
                            </td>
                            <td class="text-center">
                                @if ($certificate->observation == null)
                                    -
                                @else
                                    {{ $certificate->observation }}
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="card-body">
                {{ $certificates->links('pagination::bootstrap-4') }}
            </div>
        </div>

    </div>

    @include('layouts.footers.auth')
</div>
