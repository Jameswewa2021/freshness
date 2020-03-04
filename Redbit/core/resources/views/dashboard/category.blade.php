@extends('layouts.dashboard')

@section('content')

    <button data-toggle="modal" data-target="#addnew" style="margin-top: -76px;" class="btn btn-primary pull-right bold"><i class="fa fa-plus"></i> Add New Miner</button>


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
                            <th>Miner Name</th>
                            <th>Coin Code</th>
                            <th>Plans</th>
                            <th>Edit</th>
                        </tr>
                        </thead>
                        <tbody id="products-list" name="products-list">
                        @if($categories)
                            @foreach ($categories as $category)
                                <tr id="category-{{$category->id}}">
                                    <td>{{$category->id}}</td>
                                    <td>{{$category->name}}</td>
                                    <td>{{$category->code}}</td>
                                    <td>{{ count($category->plans) }} Plans</td>
                                    <td>
                                        <button data-id="{{ $category->id }}" data-name="{{ $category->name }}" data-code="{{ $category->code }}" class="btn btn-warning editbtn" role="button">
                                            <i class="fa fa-edit"></i>
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
    <div id="addnew" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add New Miner</h4>
                </div>
                <form action="{{ route('category.store') }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>Miner Name: </p>
                        <div class="form-group">
                            <input type="text" name="name" placeholder="Bitcoin Miner" class="form-control">
                        </div>
                        <p>Coin Code: </p>
                        <div class="form-group">
                            <input type="text" name="code" placeholder="btc" class="form-control">
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
                    <h4 class="modal-title">Update Miner</h4>
                </div>
                <form action="{{ route('category.update') }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="modal-body">
                        <p>Miner Name: </p>
                        <div class="form-group">
                            <input type="hidden" id="edit_id" name="id">
                            <input id="edit_name" type="text" name="name" placeholder="BitCoin Miner" class="form-control">
                        </div>
                        <p>Coin Code: </p>
                        <div class="form-group">
                            <input id="edit_code" type="text" name="code" placeholder="btc" class="form-control">
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
                    var url = '{{ url('admin/category-delete') }}';
                    $('#dltform').attr('action', url);
                    $('#dltid').val(id);
                    $('#dltmodel').modal();
                });
                $('.editbtn').click(function (e) {
                    var id = $(this).data('id');
                    var name = $(this).data('name');
                    var code = $(this).data('code');
                    var url = '{{ url('admin/category-edit') }}';
                    $('#edit_id').val(id);
                    $('#edit_name').val(name);
                    $('#edit_code').val(code);
                    $('#editmodal').modal();
                });
            });
        })(jQuery);
    </script>

@endsection