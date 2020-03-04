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
            <h4 class="card-heading-title">Purchased Packages</h4>
            <div class="card-heading-breadcrumb">
                <div class="breadcrumb-item"><a href="{!! route('package') !!}">Packages</a></div>
                <div class="breadcrumb-item active"><a href="#">Purchased Packages</a></div>
            </div>
        </div>
        <!-- row -->
        <div class="row row-md">
            <!-- col -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Package</th>
                                        <th>Remaining Days</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php $i=0;@endphp
                                @foreach($log as $p)
                                    @php $i++;
                                    $data = \App\Packages::where('pid', $p->package_id)->get();
                                    @endphp
                                    <tr>
                                        <td>{{ $p->created_at->format('d M Y') }}</td>
                                        <td><div class="badge badge-danger">{{$data[0]->package_name}}</div></td>
                                        <td>{{$p->r_week}}</td>
                                        <td>
                                        @if($p->status == "0" )
                                            <div class="badge badge-danger">Expired</div>
                                        @elseif($p->status == "1")
                                            <div class="badge badge-success">Active</div>
                                        @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div><!-- end / col -->
        </div><!-- end / row -->
    </div>
</div>     
@endsection