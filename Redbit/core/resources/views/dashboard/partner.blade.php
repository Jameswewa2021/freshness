@extends('layouts.dashboard')

@section('content')

    <button data-toggle="modal" data-target="#addnew" style="margin-top: -76px;" class="btn btn-primary pull-right bold"><i class="fa fa-plus"></i> Add New Partner</button>


    <div class="row">
        <div class="col-md-12">

            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"> </a>
                    </div>
                </div>
                <div class="portlet-body">


                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Partner Name</th>
                            <th>Logo</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="products-list" name="products-list">
                        @if($partners)
                            @foreach ($partners as $partner)
                                <tr id="partner-{{$partner->id}}">
                                    <td>{{$partner->id}}</td>
                                    <td>{{$partner->name}}</td>
                                    <td><img src="{{ asset('assets/images/' . $partner->logo) }}" alt="{{$partner->name}}" style="max-height: 100px;max-width: 100px;"></td>
                                    <td>
                                        <button data-id="{{ $partner->id }}" data-name="{{ $partner->name }}" data-logo="{{ asset('assets/images/' . $partner->logo) }}" class="btn btn-warning editbtn" role="button">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger dltbtn" role="button" item="{{ $partner->id }}" data-toggle="model" data-target="#dltmodel">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="dltmodel" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Partner</h4>
                </div>
                <form id="dltform" method="post">
                    {{ csrf_field() }}
                    {{ method_field('delete') }}
                    <div class="modal-body">
                        <p>Are You Sure To Delete The Partner?</p>
                        <input type="hidden" name="id" id="dltid">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div id="addnew" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add New Partner</h4>
                </div>
                <form action="{{ route('partner.store') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>Enter Partner Name: </p>
                        <div class="form-group">
                            <input type="text" name="name" placeholder="Partner Name" class="form-control">
                        </div>
                        <p>Select Partner Logo: </p>
                        <div class="form-group">
                            <input type="file" name="logo" placeholder="Select Logo" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div id="editmodal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update Partner</h4>
                </div>
                <form action="{{ route('partner.update') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="modal-body">
                        <p>Enter Partner Name: </p>
                        <div class="form-group">
                            <input type="hidden" id="edit_id" name="id">
                            <input id="edit_name" type="text" name="name" placeholder="Partner Name" class="form-control">
                        </div>
                        <p>
                            <img src="" id="edit_logo" style="max-width: 100px;max-height: 100px;" alt="">
                        </p>
                        <p>Select Partner Logo: </p>
                        <div class="form-group">
                            <input type="file" name="logo" placeholder="Select Logo" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <meta name="_token" content="{!! csrf_token() !!}" />
    <!-- Modal for DELETE -->

@endsection
@section('scripts')
    @if (session('alert'))

        <script type="text/javascript">

            $(document).ready(function(){

                swal("Sorry!", "{!! session('alert') !!}", "error");

            });

        </script>

    @endif



    <script>
        (function ($) {
            $(document).ready(function () {
                $('.dltbtn').click(function (e) {
                    var id = $(this).attr('item');
                    var url = '{{ url('admin/partner-delete') }}';
                    $('#dltform').attr('action', url);
                    $('#dltid').val(id);
                    $('#dltmodel').modal();
                });
                $('.editbtn').click(function (e) {
                    var id = $(this).data('id');
                    var name = $(this).data('name');
                    var logo = $(this).data('logo');
                    var url = '{{ url('admin/partner-edit') }}';
                    $('#edit_id').val(id);
                    $('#edit_name').val(name);
                    $('#edit_logo').attr('src', logo);
                    $('#editmodal').modal();
                });
            });
        })(jQuery);
    </script>

@endsection