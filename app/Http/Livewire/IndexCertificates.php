<?php

namespace App\Http\Livewire;

use App\Models\Certificate;
use Livewire\Component;
use Livewire\WithPagination;

class IndexCertificates extends Component
{
    use WithPagination;

    public $search, $certificate_types, $certificate_filter;


    public function mount()
    {
        $this->search = null;
        $this->certificate_filter = 'all';
        $this->certificate_types = ['BACHILLER', 'TITULO', 'MAESTRIA', 'DOCTORADO', 'SEGUNDA ESPECIALIDAD', 'FAEDIS', 'FOCAM', 'PROGRAMA 066'];
    }

    public function render()
    {


        $certificates = Certificate::when($this->certificate_filter != 'all', function ($query) {
            return $query->where('program', $this->certificate_filter)->where(function ($q) {
                return $q->when($this->search != null, function ($qry) {
                    return $qry->where('title', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('program', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('faculty', 'LIKE', '%' . $this->search . '%');
                });
            });
        })


            // where(
            //     $this->certificate_filter != 'all',
            //     function ($q) {
            //         return $q->where('program', $this->certificate_filter);
            //     }

            // )->where($this->search != null, function ($query) {
            //     return $query->where('title', 'LIKE', '%' . $this->search . '%')
            //         ->orWhere('program', 'LIKE', '%' . $this->search . '%')
            //         ->orWhere('faculty', 'LIKE', '%' . $this->search . '%');
            // })
            ->orderByDesc('id')->paginate(10);

        return view('livewire.index-certificates', compact('certificates'));
    }
}
