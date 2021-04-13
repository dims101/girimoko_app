<?php

namespace App\Imports;

use App\Awb;
use App\Proforma;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Throwable;

class AwbImport implements ToCollection, WithHeadingRow, SkipsOnError
 {
   public function collection(Collection $rows)
    {
        foreach ($rows as $row){
            Proforma::create([
                'no_proforma'=>$row['no_proforma'],
                'koli'=>$row['koli'],
                'no_awb'=>$row['no_awb'],
            ]);
        }
        
        $rows = $rows->unique('no_awb');    
            
        foreach ($rows as $row){

            // $awb = Awb::find($row['no_awb']);
            // dd($rows);
            // if($awb == null){
                Awb::create([
                    'no_awb' => $row['no_awb'],
                    'no_ds' => $row['no_ds'],
                    'kode_dealer' => $row['kode_dealer'],
                    'tanggal_ds' => date('Y-m-d', strtotime(strval($row['tgl_ds']))),
                ]);
            // }

            
        }
   }
   public function onError(Throwable $error)
   {
       
   }
// class AwbImport implements ToModel, WithHeadingRow, SkipsOnError
// {
//     /**
//     * @param array $row
//     *
//     * @return \Illuminate\Database\Eloquent\Model|null
//     */
//     public function model(array $row)
//     {
//         // foreach($data as $row){
//         //     return $row['no_awb'][0];
//         // }

        
//         // foreach($data as $row) {            
//         //     $data = Awb::find($row['no_awb']);
//         //     if (empty($data)) {
//         //        return new Mahasiswa([
//         //             'no_awb' => $row['no_awb'],
//         //             'no_ds' => $row['no_ds'],
//         //             'kode_dealer' => $row['kode_dealer'],
//         //             'tanggal_ds' => date('Y-m-d', strtotime($row['tgl_ds'])),
//         //         ]);
//         //     } 
//         // }

//         $awb = new Awb([
//             'no_awb' => $row['no_awb'],
//             'no_ds' => $row['no_ds'],
//             'kode_dealer' => $row['kode_dealer'],
//             'tanggal_ds' => date('Y-m-d', strtotime(strval($row['tgl_ds']))),
//         ]);
//         $proforma = new Proforma([
//             'no_proforma'=>$row['no_proforma'],
//             'koli'=>$row['koli'],
//             'no_awb'=>$row['no_awb'],
//         ]);
//         return ($this->awb + $this->proforma);
//         // return dd($row['tgl_ds']);
//     }
    
}
