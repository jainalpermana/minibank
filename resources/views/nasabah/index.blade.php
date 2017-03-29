
 @extends('template.master')
@section('content')

{!! link_to('nasabah/create','tambah data',['class'=>'btn btn-danger btn-sm']) !!}
<hr>

{!! Form::open(array('url'=>'nasabah/search')) !!}
{!! Form::text('keyword','',['class'=>'form-control','placeholder'=>'masukan alamat nasabah']) !!}
{!! Form::submit('lakukan pencarian',['class'=>'btn btn-danger btn-sm']) !!}
{!! Form::close() !!}
<hr>
<table class="table table-bordered">
	<tr><th>No Rekening</th><th>Nama Lengkap</th><th>Alamat</th><th></th></tr>
	@foreach($nasabah as $n)
	<tr>
	<td>{{ $n->no_rekening }}</td>
	<td>{{ $n->nama_lengkap }}</td>
	<td>{{ $n->alamat }}</td>
	<td>{!! link_to('nasabah/'.$n->id.'/edit','Edit',['class'=>'btn btn-default btn-sm']) !!}
	{!! link_to('nasabah/'.$n->id,'Detail',['class'=>'btn btn-default btn-sm']) !!}
		{!! Form::open(array('method'=>'delete','url'=>'nasabah/'.$n->id))!!}
		{!! Form::hidden('_delete','DELETE') !!}
		{!! Form::submit('Delete',['class'=>'btn btn-danger btn-sm'])!!}
		{!! Form::close()!!}
		</td></tr>
	@endforeach 
</table>
{!! $nasabah->render() !!}
@stop

