@extends('layouts.user-frontend.user-dashboard')

@section('style')
<style type="text/css">
    .table_s1 td i {
    margin-right: 10px;
}
.table-hover tbody tr:hover {
    background-color: rgba(244, 246, 249, 0.5);
}
.table_s1 thead{
    background-color: #3449BD;
    color: #ffffff;
}
.table_s1 .badge-pill {
    font-size: 12px;
}
.page-item.active .page-link{
    background-color: #3449BD !important;
}
</style>
@endsection
@section('content')
<div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title-wrap bar-success">
                        <h4 class="card-title">Transfer Detail</h4>
                    </div>
                </div>
                <div class="card-body collapse show">
                    <div class="card-block card-dashboard table-responsive">
                        <table class="table table-hover table_s1 default-ordering" width="100%" cellspacing="0">
                            <thead >
                                <tr>
                                    <th>Date</th>
                                    <th>Username</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=0;@endphp
                                @foreach($log as $p)
                                    @php $i++;@endphp
                                    <tr>
                                        <td>{{ $p->created_at->format('d M Y') }}</td>
                                        <td>{{ $p->name }}</td>
                                        <td>${{ $p->amount }}</td>
                                        <td><span class="mb-0 btn-sm btn text-white bg-warning round">{{$p->type}}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>          
                        </table>                
                    </div>
                </div>
            </div>
        </div>
    </div>       
@endsection