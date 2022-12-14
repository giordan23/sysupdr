<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


    <title>Autores</title>
</head>
<style>
    body {
        background-image: url("https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEhenkgch9UxmqX18hsHDEgfPA2iCPlsjSm_0dYmE-hfPVHB3i97ZPfxTTeU-oYt944D-1GzSR03SAehgSEchF-o4_oyPu1SznXCdIcgHwDh1pC8YEKMEvb35zp0NKUiWLTCMWYMjT-dHKhqls82hJdfIWaePp_z_6g01hsIIS_4dlAoc96ycMzFC-yYPA/w784-h1109/Papeleleria%20Acuarela%20Azul%20-%20Documento%20A4.png");
    }

    @page {
        size: A4;
        margin: 0;
    }

    #title {
        margin-top: 25%;
    }

    #titleh1 {
        font-size: 30px;
        color: black;
    }

    #p1 {
        margin-left: 10%;
        margin-right: 10%;
    }

    #titleDoc {
        font-weight: bold;
        color: black;
    }

    #presentado {
        margin-left: 10%;
        margin-top: -3%;

    }

    #fullName {
        font-weight: bold;
        color: black;
        margin-left: 35%;
        margin-top: -3%;
    }

    #parrafo2 {
        margin-left: 10%;
        margin-right: 10%;
    }

    #asesor {
        color: black;
    }

    #table {
        margin-left: 35%;
        border: 1px solid;
        border-color: black;
    }

    #adjunto {
        margin-left: 10%;
        margin-right: 10%;
    }

    #expire {
        margin-top: 1em;
        margin-left: 35%;
    }

    #code {
        margin-left: 10%;
        color: black;
    }

    .margen {
        margin-left: 10%;
        margin-right: 10%;
    }

    .sublist {
        margin-left: 14%;
        margin-right: 10%;
    }

    .td1 {
        padding: 0.3em;
        border-style: solid;
        border-width: 0.1em;
    }

    p,
    img {
        margin: 0;
        padding: 0;
    }

    .c1 {
        padding-left: 30px;
    }

    .c2 {
        padding-right: 30px;
    }
</style>

<body>
    <div class="container">
        <div class="row">
            <div id="title" class="py-1">
                <strong>
                    <p id="titleh1" class="text-danger pt-3 text-center"><i>CERTIFICADO DE SIMILITUD</i></p>
                </strong>
            </div>
            <div class="margen">
                <strong>
                    <p>Por medio del presente y de acuerdo al siguiente detalle:</p>
                </strong>
            </div>
            <div class="sublist pt-1">
                <p class="text-justify">Trabajo de Investigaci??n, @if ($certificate)
                    @endif titulado:
                    <br><strong>"{{ $certificate->title }}"</strong>
                </p>
            </div>
            <div class="sublist pt-1">
                <p>Presentado por: <br><strong>{{ $certificate->authors->full_name }} @if ($certificate->authorSecond)
                            <br> {{ $certificate->authorSecond->full_name }}
                        @endif
                    </strong></p>
            </div>
            <div class="sublist pt-1">
                <p>Docente Asesor(a): <br><strong>{{ $certificate->advisers->full_name }} </strong></p>
            </div>

            <div class="sublist pt-1">
                <p>Para obtener: <br>{!! $message !!}
                    <strong> {{ $certificate->denominacion->mencion }}. </strong>
                </p>
            </div>

            <p id="p1" class="text-justify pt-2">La Unidad de Promoci??n, Difusi??n y Repositorio, <strong>
                    certifica
                    que es
                    un
                    trabajo
                    de investigaci??n original </strong> y que no ha sido presentado ni publicado en revistas cient??ficas
                nacionales e
                internacionales, ni en sitio o portal electr??nico.
                <br>
                Por tanto, en cumplimiento del Art.4?? del Reglamento del Software Anti plagio de la Universidad Nacional
                de
                Huancavelica, se dictamina que el trabajo de investigaci??n fue analizado por el software anti plagio
                TURNITIN
                (realizado por el docente Asesor), se expide el siguiente certificado.
            </p>

            <table id="table" class="pt-2">

                <tr class="tr1">
                    <td class="td1"><strong>ORIGINALIDAD</strong></td>
                    <td class="td1"><strong>SIMILITUD</strong></td>
                </tr>
                <tr class="tr1">
                    <td class="td1 text-center"><strong>{{ $certificate->originality }}%</strong></td>
                    <td class="td1 text-center"><strong>{{ $certificate->similitude }}%</strong></td>
                </tr>
            </table>
        </div>

        <div class="row">
            <div class="col-sm pl-5 ml-4">
                <img src="data:image/png;base64, {!! $qr !!}">
            </div>
            <p class="text-right pr-5 mr-4">
                El presente Certificado se expide el {{ $fecha_emision }}.
            </p>
        </div>
        <div>
            <p id="code" class="pt-5 mt-5">
                {{ $certificate->document_number }}
            </p>
        </div>
    </div>

</body>

</html>
