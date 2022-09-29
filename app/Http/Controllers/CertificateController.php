<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCertificateRequest;
use App\Http\Requests\UpdateCertificateRequest;
use App\Models\Adviser;
use App\Models\Author;
use App\Models\Certificate;
use Illuminate\Http\Request;
use \Barryvdh\DomPDF\Facade\Pdf  as PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;


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

        return view('certificate.create', compact('authors', 'advisers', 'certificate_types'));
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
            'faculty' => 'required',
            'originality' => 'required|numeric',
            'similitude' => 'required|numeric',
            'date' => 'date_format:Y-m-d',
            'author' => 'required',
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
            // 'authored2.exists' => 'No se encontro al segundo autor',
            'authored2.different' => 'Seleccione el autor diferente al primero',
            'advisered.required' => 'El asesor es requerido',
            'advisered.exists' => 'No se encontro al asesor',

        ];
        $this->validate($request, $rules, $messages);
        // $authorId = $request->input('author');
        // $chain1 = $authorId;
        // $separator1 = "-";
        // $separatedAuthor = explode($separator1, $chain1);
        // $author=(int)$separatedAuthor[0];

        // $advisersId = $request->input('adviser');
        // $chain = $advisersId;
        // $separator = "-";
        // $separatedAdviser = explode($separator, $chain);
        // $author=(int)$separatedAdviser[0];

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
        $certificate->second_author_id = $request->input('authored2');
        $certificate->adviser_id = $request->input('advisered');
        $certificate->program = $program;
        $certificate->document_number = $doc_num;

        $certificate->faculty = $request->input('faculty');
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
        view()->share(['certificate' => $certificate]);
        if ($request->has('download')) {
            PDF::setOptions(['dpi' => '150', 'defaultFont' => 'sans-serif']);
            $pdf = PDF::loadView('certificate.pdf');
            $pdf->setPaper('a4');
            return $pdf->stream('certificado.pdf');
        }
        return view('certificate.pdf');
    }
}
