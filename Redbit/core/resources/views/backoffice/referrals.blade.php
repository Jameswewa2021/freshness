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
            <h4 class="card-heading-title">Referrals</h4>
            <div class="card-heading-breadcrumb">
                <div class="breadcrumb-item"><a href="{!! route('binaryd') !!}">Network</a></div>
                <div class="breadcrumb-item active"><a href="#">Referrals</a></div>
            </div>
        </div>
        <!-- card -->
        <div class="col-12 px-0">
            <div class="card" style="background-color:#3A3A3A !important">
                <div class="card-content px-20 py-5">
                    <h3 class="text-white" style="margin-right: 10px !important">Total Referrals: {{$active_user + $inactive_user}}</h3>
                    <h3 class="text-white" style="margin-right: 10px !important">Active Referrals: {{$active_user}}</h3>
                    <h3 class="text-white" style="margin-right: 10px !important">Inctive Referrals: {{$inactive_user}}</h3>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered" id="datatable1">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Status</th>
                            <th>Username</th>
                            <th>Joining</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $i=0;@endphp
                    @foreach($ref as $p)
                    @php $i++;@endphp
                        <tr>
                            <td>{{$i}}</td>
                            <td>
                               @if($p->r_limit != 0)
                               <div class="badge badge-primary">Active</div>
                               @else
                               <div class="badge badge-danger">Inactive</div>
                               @endif
                            <td>{{ $p->username }}</td>
                            </td>
                            <td>{{ $p->created_at->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div><!-- end / card -->
    </div>
</div>      
@endsection