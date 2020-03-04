@extends('layouts.user-frontend.user-dashboard')

@section("content")

<div class="container">
    <form method="POST" action="{{route('ipn.coinPay')}}">
        {!! csrf_field() !!}
<input type="text" name="txn_id"/>
<input type="submit" />
</form>
</div>

@endsection