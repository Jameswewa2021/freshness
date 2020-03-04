@extends('layouts.dashboard')
@section('content')


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
                            <th>Date</th>
                            <th>Trx ID</th>
                            <th>User</th>
                            <th>Type</th>
                            <th>Earning</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @php $i=0;@endphp
                        @foreach($log as $p)
                            @php $i++;@endphp
                            <tr>
                                <td>{{ $p->created_at->format('d M Y')  }}</td>
                                <td>{{ $p->transaction_id }}</td>
                                <td>{{ $p->user->username }}</td>
                                <td>{{ $p->type }}</td>
                                <td>
                                    @if($p->type == 'general')
                                        @php
                                            $currency = $basic->currency;
                                        @endphp
                                        {{ $p->method->name }}
                                    @elseif($p->type == 'coin')
                                        @php
                                            $wallet = App\UserData::findOrFail($p->method_id);
                                            $currency = isset($wallet->miner)?$wallet->miner->code:'';
                                        @endphp
                                        {{ $wallet->miner->code }}
                                    @elseif($p->type == 'PM')
                                        @php
                                            $wallet = App\UserData::findOrFail($p->method_id);
                                            $currency = isset($wallet->miner)?$wallet->miner->code:'';
                                        @endphp
                                        {{ $wallet->miner->name }}
                                        @elseif($p->type == 'BTC')
                                        @php
                                            $wallet = App\UserData::findOrFail($p->method_id);
                                            $currency = isset($wallet->miner)?$wallet->miner->code:'';
                                        @endphp
                                        {{ $wallet->miner->name }}
                                    @endif
                                </td>
                                <td>${{ $p->net_amount }}</td>
                                <td>
                                    @if($p->status == 0 )
                                        <span class="label label-warning bold uppercase"><i class="fa fa-spinner"></i> Pending</span>
                                    @elseif($p->status == 1)
                                        <span class="label label-success bold uppercase"><i class="fa fa-check"></i> Complete</span>
                                    @elseif($p->status == 2)
                                        <span class="label label-danger bold uppercase"><i class="fa fa-times"></i> Refund</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('single-withdraw-view',$p->id) }}" class="btn btn-primary btn-xs bold uppercase">View</a>
                                    @if($p->status == 0)
                                        <a href="#" data-id="{{ $p->id }}" class="btn btn-success btn-xs bold uppercase confir">Confirm</a>
                                         <a href="#" data-id="{{ $p->id }}" class="btn btn-danger btn-xs bold uppercase refund">Refund</a> 
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div><!-- ROW-->
    <div class="modal fade" id="con" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><strong>Confirmation..!</strong> </h4>
                </div>

                <div class="modal-body">
                    <strong>Are you sure to Confirm This Withdraw..?</strong>
                </div>
                <div class="modal-footer">
                    <form method="post" action="{{ route('withdraw-confirm') }}" class="form-inline">
                        {!! csrf_field() !!}
                        <input type="hidden" name="id" class="abir_id" value="0">
                        <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
                        <button type="submit" class="btn btn-success"> Yes I'm Sure..!</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="ref" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"> <i class='fa fa-exclamation-triangle'></i><strong>Confirmation..!</strong> </h4>
                </div>

                <div class="modal-body">
                    <strong>Are you sure you want to Refund This Withdraw..?</strong>
                </div>
                <div class="modal-footer">
                    <form method="post" action="{{ route('withdraw-refund') }}" class="form-inline">
                        {!! csrf_field() !!}
                        <input type="hidden" name="id" class="abir_id" value="0">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Yes I'm Sure..!</button>
                    </form>
                </div>

            </div>
        </div>
    </div>


@endsection
@section('scripts')

    <script>
        $(document).ready(function () {

            $(document).on("click", '.confir', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $(".abir_id").val(id);
                $('#con').modal();
            });

        });
        $(document).ready(function () {

            $(document).on("click", '.refund', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $(".abir_id").val(id);
                $('#ref').modal();
            });

        });
    </script>

@endsection
