<?php

namespace App\Http\Controllers;

use App\Models\Adviser;
use App\Models\Author;
use App\Models\Certificate;
use App\Models\Denominacion;
use Illuminate\Http\Request;
use \Barryvdh\DomPDF\Facade\Pdf  as PDF;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // $certificates = Certificate::orderByDesc('id')->paginate(5);
        return view('certificate.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authors = Author::get();
        $advisers = Adviser::get();
        $certificate_types = ['BACHILLER', 'TITULO', 'MAESTRIA', 'DOCTORADO', 'SEGUNDA ESPECIALIDAD', 'FAEDIS', 'FOCAM', 'PROGRAMA 066'];
        $denominations = Denominacion::all();

        return view('certificate.create', compact('authors', 'advisers', 'certificate_types', 'denominations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCertificateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|min:3',
            'originality' => 'required|numeric',
            'similitude' => 'required|numeric',
            'date' => 'date_format:Y-m-d',
            'author' => 'required',
            'denominacion_id' => 'required',
            'adviser' => 'required',
            'authored' => 'required|exists:App\Models\Author,id',
            'authored2' => 'different:authored',
            'advisered' => 'required|exists:App\Models\Adviser,id'

        ];
        $messages = [
            'originality.numeric' => 'La originalidad tiene que ser numeros.',
            'similitude.numeric' => 'La similitud tiene que ser numeros.',
            'date.date_format' => 'La fecha no esta en el formato correcto.',
            'authored.required' => 'El autor es requerido',
            'authored.exists' => 'No se encontro al autor',
            'authored2.different' => 'Seleccione el autor diferente al primero',
            'advisered.required' => 'El asesor es requerido',
            'advisered.exists' => 'No se encontro al asesor',

        ];
        $this->validate($request, $rules, $messages);

        $program = $request->input('program');

        $nro_doc = Certificate::where('program', $program)->count() + 1;
        $nro_ceros = '';
        // dd($nro_doc);

        if ($nro_doc < 10) {
            $nro_ceros = '000';
        } elseif ($nro_doc < 100 && $nro_doc > 9) {
            $nro_ceros = '00';
        } elseif ($nro_doc < 1000 && $nro_doc > 99) {
            $nro_ceros  = '0';
        } else {
            $nro_ceros = '';
        }

        $doc_num = "Nº " . $nro_ceros . $nro_doc . "-" . Carbon::now()->format('Y');

        $certificate = new Certificate();
        $certificate->title = strtoupper($request->input('title'));
        $certificate->author_id = $request->input('authored');
        $certificate->author2_id = $request->input('authored2');
        $certificate->denominacion_id = $request->input('denominacion_id');
        $certificate->adviser_id = $request->input('advisered');
        $certificate->program = $program;
        $certificate->document_number = $doc_num;

        // $certificate->faculty = $request->input('faculty');
        $certificate->originality = $request->input('originality');
        $certificate->similitude = $request->input('similitude');
        $certificate->date = $request->input('date');
        $certificate->observation = $request->input('observation');
        $certificate->save();

        $notification = 'EL certificado se ha registrado correctamente';
        return redirect('certificate')->with(compact('notification'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function show(Certificate $certificate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $certificate = Certificate::findOrFail($id);
        $authors = Author::get();
        $advisers = Adviser::get();
        return view('certificate.edit', compact('certificate', 'authors', 'advisers'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCertificateRequest  $request
     * @param  \App\Models\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Certificate $certificate)
    {
        $authorId = $request->input('author');
        $chain1 = $authorId;
        $separator1 = "-";
        $separatedAuthor = explode($separator1, $chain1);

        $advisersId = $request->input('adviser');
        $chain = $advisersId;
        $separator = "-";
        $separatedAdviser = explode($separator, $chain);

        $certificate = Certificate::find($certificate->id);
        $certificate->title = $request->input('title');
        $certificate->author_id = (int)$separatedAuthor[0];
        $certificate->adviser_id = (int)$separatedAdviser[0];
        $certificate->program = $request->input('program');
        $certificate->faculty = $request->input('faculty');
        $certificate->originality = $request->input('originality');
        $certificate->similitude = $request->input('similitude');
        $certificate->date = $request->input('date');
        $certificate->observation = $request->input('observation');
        $certificate->update();

        if ($certificate) {

            $notification = 'El certificado se ha actualizado correctamente!';
        } else {
            $notification = 'Ocurrio un problema al registrar el certificado.';
        }
        return redirect('certificate')->with(compact('notification'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Certificate $certificate)
    {
        $certificateTitle = $certificate->tile;
        $certificate->delete();

        $notification = "El certificado $certificateTitle se elimino correctamente.";
        return redirect('certificate')->with(compact('notification'));
    }
    public function reportCertificate(Request $request)
    {
        $certificate = Certificate::findOrFail($request->input('certificate'));

        $header_focam = null;
        $header_p066 = null;
        $header_faedis = null;
        $mencion_titulo = null;
        $grado = null;
        $message = null;

        switch ($certificate->program) {
            case 'BACHILLER':
                $grado = '<strong> Grado académico de Bachiller</strong>';
                $message = 'El ' . $grado . ' en:';
                break;
            case 'TITULO':
                $mencion_titulo = '<strong> LICENCIADO EN CIENCIAS DE LA EDUCACION</strong>';
                $grado = "<strong> Titulo profesional</strong>";
                $message = 'El ' . $grado . ' de:';
                break;
            case 'MAESTRIA':
                $grado = '<strong> Grado académico de Maestro</strong>';
                $message = 'El ' . $grado . ' en la mención de:';
                break;
            case 'DOCTORADO':
                $grado = '<strong> Grado académico de Doctor</strong>';
                $message = 'El ' . $grado . ' en:';
                break;
            case 'SEGUNDA ESPECIALIDAD':
                $grado = '<strong> Título Profesional de Segunda Especialidad</strong>';
                $message = 'El ' . $grado . ' en:';
                break;
            case 'FAEDIS':
                $header_faedis = 'FONDO DE APOYO ECONÓMICO A LOS DOCENTES INVESTIGADORES (FAEDI)';
                break;
            case 'FOCAM':
                $header_focam = 'FONDO DE DESAROLLO SOCIOECONÓMICO DE CAMISEA (FOCAM) ';
                $grado = '<strong> Titulo profesional</strong>';
                $message = 'El ' . $grado . ' de:';
                break;
            case 'PROGRAMA 066':
                $header_p066 = 'PROGRAMA 066 ';
                $grado = '<strong>Titulo profesional</strong>';
                $message = 'El ' . $grado . ' de:';
                break;
        }

        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $fecha = Carbon::parse($certificate->created_at);
        // dd($certificate->created_at);
        $mes = $meses[($fecha->format('n')) - 1];
        // dd($mes);
        $fecha_emision = $fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y');
        // dd($fecha_emision);
        $num_doc = $certificate->document_number;
        function mapped_implode($glue, $array, $symbol = '=')
        {
            return implode(
                $glue,
                array_map(
                    function ($k, $v) use ($symbol) {
                        return $k . $symbol . $v;
                    },
                    array_keys($array),
                    array_values($array)
                )
            );
        }

        $data = [
            $certificate->program,
            $num_doc,
            $certificate->authors->full_name,
            $certificate->authorSecond ? $certificate->authorSecond->full_name : null,
            $certificate->advisers->full_name,
            'P,n_doc,a_1,a_2,asesor'
        ];
        $datos = mapped_implode(', ', $data, ' => ');

        $qr = base64_encode(QrCode::style('round')->generate($datos));
        // $qr = QrCode::size(100)->format('png')->generate('Make me into a QrCode!', '../public/qrcodes/qrcode ' . $certificate->updated_at . $num_doc . '.svg');
        // dd($qr);

        view()->share([
            'certificate' => $certificate, 'fecha_emision' => $fecha_emision, 'grado' => $grado, 'message' => $message, 'mencion_titulo' => $mencion_titulo, 'header_focam' => $header_focam, 'header_p066' => $header_p066, 'mencion_titulo' => $mencion_titulo
        ]);
        if ($request->has('download')) {
            PDF::setOptions(['dpi' => '150', 'defaultFont' => 'sans-serif']);
            $pdf = PDF::loadView('certificate.pdf', compact('qr'));
            $pdf->setPaper('a4');
            return $pdf->stream('certificado.pdf');
        }
        return view('certificate.pdf');
    }
}
