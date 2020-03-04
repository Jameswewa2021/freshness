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
            <h4 class="card-heading-title">Earning Details</h4>
            <div class="card-heading-breadcrumb">
                <div class="breadcrumb-item active"><a href="{!! route('roi') !!}">Earnings</a></div>
            </div>
        </div>
        <!-- card -->
        <div class="col-12 px-0">
            <div class="card" style="background-color:#3A3A3A !important">
                <div class="card-content px-20 py-5">
                    <h3 class="text-white" style="float:left;margin-right: 10px !important"><strong>Total Earned:</strong></h3>
                    <h3 class="text-white"><strong>$ {{Auth::user()->total}}</strong></h3>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered" id="datatable1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Earning Type</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $i=0;@endphp
                    @foreach($log as $p)
                        @php $i++;@endphp
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{ $p->created_at->format('d M Y') }}</td>
                            <td>${{ $p->amount }}</td>
                            <td>
                                @if($p->type == "Direct" )
                                    <div class="badge badge-warning">Direct</div>
                                @elseif($p->type == "Binary")
                                    <div class="badge badge-danger">Binary</div>
                                @elseif($p->type == "Daily")
                                    <div class="badge badge-success">Daily ROI</div>
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