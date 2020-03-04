@extends('layouts.user-frontend.user-dashboard')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title-wrap bar-success">
                    <h4 class="card-title">New Ticket</h4>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body px-0">
                    {!! Form::open(['role'=>'form','id'=>'formSubmit','class'=>'form-horizontal','files'=>true]) !!}
                        <div class="col-12">
                            <div class="form-group">
                                <div class="col-md-12 px-0">
                                    <div class="col-md-12 input-group">
                                        <input id="subject" name="subject" class="form-control" value="" type="text" placeholder="Subject" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <textarea name="message" id="" cols="30" rows="6" style="overflow:hidden;"
                                              class="form-control bold input-lg textarea-custome" placeholder="Message" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <div class="col-12">
                                    <button type="button" class="btn-gradient-primary text-white"
                                            data-toggle="modal" data-target="#DelModal">
                                        Confirm and Open
                                    </button>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><strong>Confirmation</strong> </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body py-2">
                <strong>Are you sure you want to open Ticket?</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                <button type="button" id="btnYes" class="btn btn-primary"><i class="fa fa-check"></i>Yes</button>
            </div>

        </div>
    </div>
</div>

@endsection
@section('script')
    <script type='text/javascript'>
        $('#btnYes').click(function() {
            $('#formSubmit').submit();
        });
    </script>
@endsection