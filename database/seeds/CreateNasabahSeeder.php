<?php

use Illuminate\Database\Seeder;

class CreateNasabahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         //delete users table records
         DB::table('nasabahs')->delete();
         //insert some dummy records
         DB::table('nasabahs')->insert(array(
             array('nama_lengkap'=>'desi handayani','alamat'=>'langsa','no_rekening'=>'09872634'),
             array('nama_lengkap'=>'rafika yuni','alamat'=>'lhokseumawe','no_rekening'=>'19827648'),
             array('nama_lengkap'=>'johni kapluk','alamat'=>'kuala simpang','no_rekening'=>'12098376'),
          ));
    }
}
