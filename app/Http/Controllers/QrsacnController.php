<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use Illuminate\Http\Request;

class QrsacnController extends Controller
{
    public function QrcodeScanMachine($id)
    {
        $mc = Machine::where('machine_code',$id)->first();
        return view('qr-machine-all',compact('mc'));
    }
}
