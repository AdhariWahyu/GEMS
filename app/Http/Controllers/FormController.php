<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Overtime;
use Barryvdh\DomPDF\Facade\Pdf;

class FormController extends Controller
{
    public function preview($id)
    {
        $form = Overtime::find($id);
        return view('form.index', compact('form'));
    }

    public function download($id)
    {
        $form = Overtime::find($id);
        $pdf = Pdf::loadView('form.index', [
            'form' => $form
        ])->setPaper('a4')->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        $name = 'FORM-' . $form->id . '.pdf';
        return $pdf->download($name);
    }
}
