@extends('layouts.dashboard')

@section('content')

    @if(count($user))

        <div class="row">
            <div class="col-md-12">


                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                        </div>
                        <div class="tools"> </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="sample_1">

                            <thead>
                            <tr>
                                <th>ID#</th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>ROI</th>
                                <th>Binary</th>
                                <th>Direct</th>
                                <th>Cash wallet</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $i=0;@endphp
                            @foreach($user as $p)
                                @php $i++;@endphp
                                <tr>
                                    @php
                                    $bal = \App\UserData::where("user_id","=",$p->id)->get();
                                    @endphp
                                    <td>{{ $i }}</td>
                                    <td>{{ $p->username }}</td>
                                    <td>{{$p->name}}</td>
                                    <td>{{ $bal[0]->balance }}</td>
                                    <td>{{ $bal[1]->balance }}</td>
                                    <td>{{ $bal[2]->balance }}</td>
                                    <td>{{ $bal[4]->balance }}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div><!-- ROW-->

    @else

        <div class="text-center">
            <h3>No User Found</h3>
        </div>
    @endif
@endsection