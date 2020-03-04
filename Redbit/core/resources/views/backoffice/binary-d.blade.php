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
            <h4 class="card-heading-title">Binary Log</h4>
            <div class="card-heading-breadcrumb">
                <div class="breadcrumb-item"><a href="{!! route('binaryd') !!}">Network</a></div>
                <div class="breadcrumb-item active"><a href="#">Binary Log</a></div>
            </div>
        </div>
        <!-- card -->
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered" id="datatable1">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Referrals</th>
                            <th>Username</th>
                            <th>Invest</th> 
                        </tr>
                    </thead>
                    <tbody>
                    @php $i=0;@endphp
                    @foreach($bin as $p)
                        @php $i++;
                        $data = \App\User::where('id', $p->refree_id)->get();
                        @endphp
                        <tr>
                            <td>{{$i}}</td>
                            <td>Receieved</td>
                            <td>{{ $p->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="badge badge-success">Points</div>
                            </td>
                            <td>{{ $data[0]->username }}</td>
                            <td>{{ $p->refree_points }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div><!-- end / card -->
    </div>
</div>      
@endsection