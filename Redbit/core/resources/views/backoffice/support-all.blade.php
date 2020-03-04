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
            <h4 class="card-heading-title">Support</h4>
            <div class="card-heading-breadcrumb">
                <div class="breadcrumb-item"><a href="{!! route('support-all') !!}">Support Ticket</a></div>
            </div>
        </div>
        <!-- card -->
        <div class="col-12 px-0">
            <div class="card" style="background-color: transparent !important;box-shadow: none !important;">
                <div class="card-content px-20 py-5">
                    <span class="mt-1" style="float: right;">
                    <a href="{{ route('support-open') }}"><span class="badge badge-danger"><i class="fa fa-plus "></i> Open New Ticket</span></a>
                    </span>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered" id="datatable1">
                    <thead>
                        <tr>
                            <th>ID#</th>
                            <th>Date</th>
                            <th>Ticket Number</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $i=0;@endphp
                    @foreach($support as $p)
                        @php $i++;@endphp
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->created_at)->format('d F Y h:i A') }}</td>
                            <td>{{ $p->ticket_number }}</td>
                            <td>{{ $p->subject }}</td>
                            <td>
                                @if($p->status == 1)
                                    <i class="fa fa-eye info font-medium-1 mr-1"></i> Open
                                @elseif($p->status == 2)
                                    <i class="fa fa-check success font-medium-1 mr-1"></i> Answer
                                @elseif($p->status == 3)
                                    <i class="fa fa-mail-reply warning font-medium-1 mr-1"></i> Customer Reply
                                @elseif($p->status == 9)
                                    <i class="fa fa-times danger font-medium-1 mr-1"></i> Close
                                @endif
                            </td>
                            <td><a href="{{ route('support-message',$p->ticket_number) }}" class="btn btn-primary">View</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div><!-- end / card -->
    </div>
</div>           
@endsection
@section('script')

    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>


    @if (session('success'))

        <script type="text/javascript">

            $(document).ready(function(){

                swal("Success!", "{{ session('success') }}", "success");

            });

        </script>

    @endif



    @if (session('alert'))

        <script type="text/javascript">

            $(document).ready(function(){

                swal("Sorry!", "{{ session('alert') }}", "error");

            });

        </script>

    @endif

@endsection

