@extends('template.guest')
@section('content')

{!! Form::open(array('url'=>'auth/login')) !!}
    {!! csrf_field() !!}

<table class="table table-bordered">
    <tr><td>Email</td><td><input type="email" name="email" value="{{ old('email') }} " class="form-control"></td></tr>
    <tr><td>Password</td><td><input type="password" name="password" id="password" class="form-control"></td></tr>
    <tr><td>Remember</td><td><input type="checkbox" name="remember"> Remember Me</td></tr>
    <tr><td colspan="2"><button type="submit" class="btn btn-primary btn-sm">Login</button></td></tr>
</table>
</form>
@stop