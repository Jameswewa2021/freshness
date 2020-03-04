@extends('layouts.dashboard')

@section('content')

    <div class="row">
        <div class="col-md-12">

            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption uppercase">
                        <strong><i class="fa fa-info-circle"></i> {{ $page_title }}</strong>
                    </div>
                    <div class="tools">
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-hover table-bordered" id="sample_1">
                        <thead>
                        <tr>
                            <th >Status</th>
                            <th >Date</th>
                            <th >Package</th>
                            <th >Remaining Limit</th>
                            <th >Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                         @php $i=0;@endphp
                        @foreach($logs as $p)
                            @php $i++;
                            $data = \App\Packages::where('pid', $p->package_id)->get();
                            $limit = \App\User::where('id', $p->user_id)->get();
                            @endphp
                            <tr>
                                <td class="text-truncate">
                                    @if($p->status == "0" )
                                    <i class="la la-dot-circle-o danger font-medium-1 mr-1"></i>Expired
                                    @elseif($p->status == "1")
                                    <i class="la la-dot-circle-o success font-medium-1 mr-1"></i>Active
                                    @endif
                                </td>
                                <td class="text-truncate"><span >{{ $p->created_at->format('d M Y') }}</span></td>
                                <td class="text-truncate">
                                    {{$data[0]->package_name}}
                                </td>
                                <td class="text-truncate p-1">{{$limit[0]->r_limit}}</td>
                                <td class="text-truncate p-1">{{$data[0]->amount}}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
@endsection

@section('nic', 'shanto')