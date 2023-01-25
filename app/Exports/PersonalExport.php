<?php

namespace App\Exports;

use App\Models\Personal;
use App\Models\PersonalCorporativo;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class PersonalExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
   
    public function view(): View
    {
        return view('exports.personal', [
            'personal' => Personal::all()
        ]);
    }
    
}
