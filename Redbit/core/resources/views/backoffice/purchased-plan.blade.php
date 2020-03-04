@extends('layouts.user-frontend.user-dashboard')
@section('content')

    <div class="content_padding">
        <div class="container" style="min-width: 50%; max-width: 90%;">
            <div class="row">
                <div class="col-md-12">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="admin-header-text">
                                <h3> Purchased Plan</h3>
                            </div>

                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-bordered table-hover" id="sample_1">

                                <thead>
                                <tr>
                                    <th>ID#</th>
                                    <th>Purchase Date</th>
                                    <th>Title</th>
                                    <th>Price</th>
                                    <!-- <th>Speed</th>
                                    <th>Return Per Day</th>
                                    <th>Miner</th> -->
                                    <th>Status</th>
                                </tr>
                                </thead>

                                <tbody>
                                @php $i=0;@endphp
                                @foreach($logs as $log)
                                    @php $i++;@endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $log->created_at->format('d M, Y')  }}</td>
                                        <td>{{ $log->plan->title }}</td>
                                        <td>{{ $log->plan->price }} {{ $basic->currency }}</td>
                                        <!-- <td>{{ $log->plan->speed }}</td>
                                        <td>{{ $log->plan->return }} {{ $log->plan->category->code }}</td>
                                        <td>{{ $log->plan->category->name }}</td> -->
                                        <td>
                                            @if($log->status == 0)
                                                <button class="btn btn-warning">Pending</button>
                                            @elseif($log->status == 2)
                                                <button class="btn btn-danger">Refunded</button>
                                            @elseif($log->status == 1)
                                                <button class="btn btn-success">Activate</button>
                                            @elseif($log->status == -10)
                                                <button class="btn btn-danger">Expaired</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection