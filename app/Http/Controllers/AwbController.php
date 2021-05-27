<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AwbImport;
use App\Awb;

use Illuminate\Http\Request;

class AwbController extends Controller
{
    public function index()
    {
        $awb = Awb::All();
        return view('awb.import',compact('awb'));
    }

    public function import(Request $request){
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx',
        ]);
        $file = $request->file('file');
        $nama_file = rand().$file->getClientOriginalName();
        //atas harus diganti tanggal
        $file->move('awb_excel',$nama_file);
        //bawah buat import
        Excel::import(new AwbImport, public_path('/awb_excel/'.$nama_file));
    }
}
