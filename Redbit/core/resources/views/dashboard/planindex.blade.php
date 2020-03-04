@extends('layouts.dashboard')

@section('content')


    <div class="row">
        <div class="col-md-12">

            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption uppercase">
                        <strong><i class="fa fa-info-circle"></i> {{ $page_title }}</strong>
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"> </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                        <thead>
                        <tr>
                            <th> ID </th>
                            <th> Title </th>
                            <th> Price </th>
                            <!-- <th> Speed </th>
                            <th> Miner </th> -->
                            <th> Edit </th>
                        </tr>
                        </thead>
                        <tbody>

                        @if($plans)

                            @foreach($plans as $plan)

                                <tr>
                                    <td> {{ $plan->id }} </td>
                                    <td> {{ $plan->title }} </td>
                                    <td> {{ $plan->price }} </td>
                                    <!-- <td> {{ $plan->speed }} </td>
                                    <td> {{ isset($plan->category)?$plan->category->name:'' }} </td> -->
                                    <td>
                                        <a href="{{ route('plan.edit', $plan->id) }}" class="btn btn-warning" role="button">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>

                            @endforeach

                        @endif

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
@endsection