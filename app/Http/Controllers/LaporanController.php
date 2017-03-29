<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use fpdf;
class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function pdf()
    {
        //
        $pdf = new \fpdf\FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(8,8,'No',1,0);
        $pdf->Cell(40,8,'Tanggal',1,0);
        $pdf->Cell(30,8,'No Rekening',1,0);
        $pdf->Cell(40,8,'Nama ',1,0);
        $pdf->Cell(20,8,'Jumlah',1,0);
        $pdf->Cell(25,8,'Operator',1,1);

       $transaksi = \DB::table('transaksis')
                   ->join('users','users.id','=','transaksis.user_id')
                   ->join('nasabahs','nasabahs.id','=','transaksis.nasabah_id')
                   ->select('nasabahs.no_rekening','nasabahs.nama_lengkap','transaksis.created_at',
                            'transaksis.jumlah','users.name')
                   ->get();
        $no=1;
         $pdf->SetFont('Arial','',11);
        foreach ($transaksi as $t) {
        $pdf->Cell(8,8,$no,1,0);
        $pdf->Cell(40,8,tgl_indo($t->created_at),1,0);
        $pdf->Cell(30,8,$t->no_rekening,1,0);
        $pdf->Cell(40,8,$t->nama_lengkap,1,0);
        $pdf->Cell(20,8,$t->jumlah,1,0);
        $pdf->Cell(25,8,$t->name,1,1);
        $no++;
        }
        $pdf->Output();
        die;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */

    function excel()
    {
        $transaksi = \DB::table('transaksis')
                   ->join('users','users.id','=','transaksis.user_id')
                   ->join('nasabahs','nasabahs.id','=','transaksis.nasabah_id')
                   ->select('nasabahs.no_rekening','nasabahs.nama_lengkap','transaksis.created_at',
                            'transaksis.jumlah','users.name')
                   ->get();

        \Excel::create('Data Transaksi',function($excel) use ($transaksi)
        {
            $excel->sheet('data transaksi',function($sheet) use ($transaksi)
            {
                $row=1;
                $sheet->row($row,array(
                    'No','Tanggal','No Rekening','Nama','Jumlah','Operator'));
                $no=1;
                foreach ($transaksi as $t) {
                    $sheet->row(++$row,array(
                        $no,
                        $t->created_at,
                        $t->no_rekening,
                        $t->nama_lengkap,
                        $t->jumlah,
                        $t->name));
                    $no++;
                }

            });
        })->export('xls');
    }


}
