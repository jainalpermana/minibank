<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Nasabah;
use App\Transaksi;
use Auth;
use Input;
use fpdf;
use Session;
use App\Http\Requests\createNasabah;

class NasabahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function __construct()
    {
    	$this->middleware('periksaLogin');
    }


    public function index()
    {
        //

        $fpdf = new \fpdf\FPDF();
        $nasabah         = Nasabah::paginate(2);
        $data['nasabah'] = $nasabah->setPath('nasabah');
        return view('nasabah.index',$data);
    }


    public function status_login()
    {
        if(Auth::check())
        {
            // kondisi true
            //echo "sudah login";
            $user = Auth::user();
            echo $user->email;

        }else{
            // kondisi false
            echo "belum login";
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */

    public function search(Request $request)
    {
        $keyword = $request['keyword'];
        $nasabah         = Nasabah::where('alamat','=',$keyword)->paginate(2);
        $data['nasabah'] = $nasabah->setPath('nasabah');
        return view('nasabah.index',$data);
    }

    public function create()
    {
        return view('nasabah.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(createNasabah $request)
    {
        $filename  = Input::file('foto')->getClientOriginalName();
        $size      = Input::file('foto')->getSize();
        Input::file('foto')->move(public_path().'/foto/',$filename);
        $data = $request->all();
        $data = array(
            'nama_lengkap'=>Input::get('nama_lengkap'),
            'alamat'=>Input::get('alamat'),
            'no_rekening' => Input::get('no_rekening'),
            'foto' =>$filename );
        Nasabah::create($data);
        return redirect('nasabah');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
       $transaksi = \DB::table('transaksis')
                   ->join('users','users.id','=','transaksis.user_id')
                   ->get();
        $data['transaksi'] = $transaksi;
        $data['nasabah'] = Nasabah::find($id);
        return view('nasabah.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $data['nasabah'] = Nasabah::find($id);
        return view('nasabah.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, createNasabah $request)
    {

        $data = $request->all();
        $nasabah = Nasabah::find($id);
        $nasabah->update($data);
        return redirect('nasabah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $nasabah = Nasabah::find($id);
        $nasabah->delete();
        return redirect('nasabah');
    }


    public function transaksi(Request $request){
    	$jenis = $request->jenis_transaksi;
    	$nasabah = Nasabah::find($request->nasabah_id);
    	$saldo   = $nasabah->saldo;
    	if($jenis=='debet')
    	{
    		// tambah saldo
    		$newSaldo = ( $saldo+$request->jumlah);
    		$nasabah->saldo = $newSaldo;
    		$nasabah->save();
    		$pesan = 'Berhasil Debet';
    		$this->prosesTransaksi();
    	}else{
    		// chek dulu saldonya cukup atau tidak
    		if($saldo<$request->jumlah)
    		{
    			// redireck dengan pesan bahwa saldo kurang
    			$pesan = 'Maaf saldo tidak mencukupi';
    		}else{
    			// lakukan penurangan saldo
    			$newSaldo = ( $saldo-$request->jumlah);
    			$nasabah->saldo = $newSaldo;
    			$nasabah->save();
    			$pesan = 'Berhasil Kredit';
    			$this->prosesTransaksi();
    		}

    	}
    	Session::flash('message',$pesan);
        return redirect('nasabah/'.$request->nasabah_id);
    }

    function prosesTransaksi()
    {
    	        $transaksi = New transaksi($request->all());
        Auth::user()->createBy()->save($transaksi);
    }


    function contoh()
    {
        $transaksi = Transaksi::find(6);
       return  $transaksi->nasabah()->get();
    }

    
}
