<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index()
    {
        // el listado si que sale filtrado por el usuario logueado
        $facturas = Auth::user()->invoices()->orderBy('id')->get();

        return view('facturas.index', compact('facturas'));
    }

    public function show($id)
    {
        // cargamos la factura por id
        $factura = Invoice::findOrFail($id);

        return view('facturas.show', compact('factura'));
    }

    public function download($id)
    {
        $factura = Invoice::findOrFail($id);

        // montamos el pdf al vuelo con los datos de la factura
        $html = view('facturas.pdf', compact('factura'))->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4');
        $dompdf->render();

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.$factura->numero.'.pdf"',
        ]);
    }
}
