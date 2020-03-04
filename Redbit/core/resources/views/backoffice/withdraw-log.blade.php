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
            <h4 class="card-heading-title">Withdraw Logs</h4>
            <div class="card-heading-breadcrumb">
                <div class="breadcrumb-item"><a href="{!! route('withdraw-log') !!}">Financials</a></div>
                <div class="breadcrumb-item active"><a href="#">Withdraw Logs</a></div>
            </div>
        </div>
        <!-- card -->
        <div class="col-12 px-0">
            <div class="card" style="background-color:#3A3A3A !important">
                <div class="card-content px-20 py-5">
                    <h3 class="text-white" style="float:left;margin-right: 10px !important"><strong>Total Withdraws:</strong></h3>
                    <h3 class="text-white"><strong>$ {{$withdraw}}</strong></h3>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered" id="datatable1">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Transaction ID</th>
                            <th>Method</th>
                            <th>Charges</th>
                            <th>Net Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $i=0;@endphp
                    @foreach($log as $p)
                        @php $i++;@endphp
                        <tr>
                            <td>{{ $p->created_at->format('d M Y')  }}</td>
                            <td>{{ $p->transaction_id }}</td>
                            <td>
                                @if($p->type == 'general')
                                    @php
                                        $currency = $basic->currency;
                                    @endphp
                                    {{ $p->method->name }}
                                @elseif($p->type == 'coin')
                                    @php
                                        $data = \App\UserData::find($p->method_id);
                                        $currency = isset($data)?$data->miner->code:'';
                                    @endphp
                                    {{ $p->type }}
                                @elseif($p->type == 'PM')
                                    @php
                                        $data = \App\UserData::find($p->method_id);
                                        $currency = isset($data)?$data->miner->code:'';
                                    @endphp
                                    {{ $p->type }}
                                @elseif($p->type == 'BTC')
                                    @php
                                        $data = \App\UserData::find($p->method_id);
                                        $currency = isset($data)?$data->miner->code:'';
                                    @endphp
                                    {{ $p->type }}
                                @endif
                            </td>
                            <td>${{ $p->charge }}</td>
                            <td>${{ $p->net_amount }}</td>
                            <td>
                                @if($p->status == 0 )
                                    <div class="badge badge-warning"><i class="fa fa-spinner"></i> Pending</div>
                                @elseif($p->status == 1)
                                    <div class="badge badge-success"><i class="fa fa-check"></i> Complete</div>
                                @elseif($p->status == 2)
                                    <div class="badge badge-danger"><i class="fa fa-times"></i> Refund</div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div><!-- end / card -->
    </div>
</div>           
@endsection