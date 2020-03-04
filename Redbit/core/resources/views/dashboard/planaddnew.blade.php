@extends('layouts.dashboard')
@section('style')
    <link href="{{ asset('assets/admin/css/bootstrap-toggle.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
    <style>
        @font-face {
            font-family: 'Glyphicons Halflings';

            src: url('{{ asset('assets/fonts/glyphicons-halflings-regular.eot') }}');
            src: url('{{ asset('assets/fonts/glyphicons-halflings-regular.eot?#iefix') }}') format('embedded-opentype'), url('{{ asset('assets/fonts/glyphicons-halflings-regular.woff2') }}') format('woff2'), url('{{ asset('assets/fonts/glyphicons-halflings-regular.woff') }}') format('woff'), url('{{ asset('assets/fonts/glyphicons-halflings-regular.ttf') }}') format('truetype'), url('{{ asset('assets/fonts/glyphicons-halflings-regular.svg#glyphicons_halflingsregular') }}') format('svg');
        }
    </style>
@endsection
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
                <div class="portlet-body form">
                    <form action="{{ route('plan.store') }}" method="post" class="form-horizontal" role="form">
                        {{ csrf_field() }}
                        <div class="form-body">

                            <div class="row">

                                <div class="col-md-4">

                                    <div class="form-group">
                                        <label class="col-md-12 bold uppercase">Plan Title</label>
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-font"></i>
                                                </span>
                                                <input type="text" class="form-control" placeholder="Plan Title" name="title">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group">
                                        <label class="col-md-12 bold uppercase">Price</label>
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Price" name="price">
                                                <span class="input-group-addon">
                                                    {{ $basic->currency }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-12 bold uppercase">Speed</label>
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-space-shuttle"></i>
                                                </span>
                                                <input type="text" class="form-control" placeholder="Speed" name="speed">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-12 bold uppercase">Miner</label>
                                        <div class="col-md-12">
                                            <select name="category_id" id="category_id" class="form-control">
                                                @if(count($categories))
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}" data-code="{{ $category->code }}">{{ $category->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-12 bold uppercase">Description</label>
                                        <div class="col-md-12">
                                            <input name="description" id="description" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-12 bold uppercase">PLAN STATUS</label>
                                        <div class="col-md-12">
                                            <input data-toggle="toggle" checked data-onstyle="success" data-offstyle="danger" data-on="Active" data-off="Deactive" data-width="100%" type="checkbox" name="status">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-12 bold uppercase">Period</label>
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <input type="number" class="form-control" value="2" placeholder="Period" id="period" name="period">
                                                <span class="input-group-addon">
                                                    <select name="ptyp" id="ptyp">
                                                        <option value="day">Day</option>
                                                        <option value="month">Month</option>
                                                        <option value="year" selected>Year</option>
                                                    </select>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-12 bold uppercase">Return Amount (Per Day)</label>
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Return Per Day" name="return">
                                                <span class="input-group-addon" id="coin_code">
                                                    {{ $basic->currency }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="items-container">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-md-12 bold uppercase">Feature <ins class="ind">1</ins></label>
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="features[]">
                                                    <span class="input-group-addon rmv" style="background-color: #ed6b75;border-color: #ea5460;color: #fff;cursor: pointer;">
                                                        <i class="fa fa-remove"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-4 col-md-offset-8">
                                    <button class="btn btn-success btn-block" id="additem">Add Feature</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn green btn-block">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('assets/admin/js/bootstrap-toggle.min.js') }}"></script>
    <script>
        (function ($) {
            $(document).ready(function () {
                $('#additem').click(function(e){
                    e.preventDefault();
                    var index = parseInt($('#items-container .form-group').last().find('.ind').text());
                    //console.log(index);
                    var html = '<div class="col-md-4"><div class="form-group"><label class="col-md-12 bold uppercase">Feature <ins class="ind">'+(index+1)+'</ins></label><div class="col-md-12"><div class="input-group"><input type="text" class="form-control" name="features[]"><span class="input-group-addon rmv" style="background-color: #ed6b75;border-color: #ea5460;color: #fff;cursor: pointer;"><i class="fa fa-remove"></i></span></div></div></div></div>';
                    $('#items-container').append(html);
                });
                $('body').on('click', '.rmv', function () {
                    $(this).closest('.form-group').fadeOut('slow', function() {
                        $(this).remove();
                    });
                });
                $('#category_id').change(function () {
                    var code = $(this).find('option:selected').data('code');
                    $('#coin_code').text(code);
                });
            });
        })(jQuery);
    </script>
@endsection