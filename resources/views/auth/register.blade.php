@extends('template.guest')
@section('content')

{!! Form::open(array('url'=>'auth/register')) !!}
    {!! csrf_field() !!}
<table class="table table-bordered">
<tr><td>Name</td><td><input type="text" name="name" value="{{ old('name') }}" class="form-control"></td></tr>
<tr><td>Email</td><td><input type="email" name="email" value="{{ old('email') }}" class="form-control"></td></tr>
<tr><td>Password</td><td><input type="password" name="password" class="form-control"></td></tr>
<tr><td>Confirm Password</td><td><input type="password" name="password_confirmation" class="form-control"></td></tr>
<tr><td colspan="2"><button type="submit" class="btn btn-danger btn-sm">Register</button></td></tr>
</table>
</form>
@stop