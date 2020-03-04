@extends('layouts.user-frontend.user-dashboard')
@section('style')
<style type="text/css">
.badge{
    font-size:13px !important;
}
thead{
    background-color: #FF0000;
    ;
}
thead th{
    color:#ffffff !important;
}
</style>
@endsection
@section('content')
<div class="main-content">
    <div class="main-body">
        <div class="card-heading d-flex a-i-center j-c-between">
            <h4 class="card-heading-title">Deposit Logs</h4>
            <div class="card-heading-breadcrumb">
                <div class="breadcrumb-item"><a href="{!! route('deposit-history') !!}">Financials</a></div>
                <div class="breadcrumb-item active"><a href="#">Deposit Logs</a></div>
            </div>
        </div>
        <!-- card -->
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered" id="datatable1">
                    <thead>
                        <tr>
                            <th>Deposit Date</th>
                            <th>Transaction ID</th>
                            <th>Deposit Method</th>
                            <th>Send Amount</th>
                            <th>Deposit Charge</th>
                            <th>Deposit Balance</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $i=0;@endphp
                    @foreach($deposit as $p)
                        @php $i++;@endphp
                        <tr>
                            <td>{{ $p->created_at->format('d-F-Y h:i A') }}</td>
                            <td>{{ $p->transaction_id }}</td>
                            <td>{{ isset($p->method)?$p->method->name:'' }}</td>
                            <td>{{ $p->net_amount }} {{ $basic->currency }}</td>
                            <td>{{ $p->charge }} {{ $basic->currency }}</td>
                            <td>{{ $p->amount }} {{ $basic->currency }}</td>
                            <td><div class="badge badge-success"><i class="fa fa-check"></i> Completed</div></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div><!-- end / card -->
    </div>
</div>
@endsection