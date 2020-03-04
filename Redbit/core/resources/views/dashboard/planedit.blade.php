@extends('layouts.dashboard')
@section('style')
    <link href="{{ asset('assets/admin/css/bootstrap-toggle.min.css') }}" rel="stylesheet">
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
                    <form action="{{ route('plan.update', $plan->id) }}" method="post" class="form-horizontal" role="form">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
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
                                                <input type="text" class="form-control" placeholder="Plan Title" name="title"
                                                       value="{{ $plan->title }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-12 bold uppercase">Price</label>
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Price" name="price" value="{{ $plan->price }}">
                                                <span class="input-group-addon">
                                                    {{ $basic->currency }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                                <!-- <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-12 bold uppercase">Speed</label>
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-space-shuttle"></i>
                                                </span>
                                                <input type="text" class="form-control" placeholder="Speed" name="speed" value="{{ $plan->speed }}">
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            
                             <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-12 bold uppercase">PLAN STATUS</label>
                                        <div class="col-md-12">
                                            <input data-toggle="toggle" {{ $plan->status == 1 ? 'checked' : '' }} data-onstyle="success" data-offstyle="danger" data-on="Active" data-off="Deactive" data-width="100%" type="checkbox" name="status">
                                        </div>
                                    </div>
                                </div>
                            
                            </div>

                            <!-- <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-12 bold uppercase">Miner</label>
                                        <div class="col-md-12">
                                            <select name="category_id" id="category_id" class="form-control">
                                                @if($categories)
                                                    @foreach($categories as $category)
                                                        @if($plan->category_id == $category->id)
                                                            <option value="{{ $category->id }}" selected data-code="{{ $category->code }}">{{ $category->name }}</option>
                                                        @else
                                                            <option value="{{ $category->id }}" data-code="{{ $category->code }}">{{ $category->name }}</option>
                                                        @endif
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
                                            <input name="description" id="description" class="form-control" value="{{ $plan->description }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-12 bold uppercase">PLAN STATUS</label>
                                        <div class="col-md-12">
                                            <input data-toggle="toggle" {{ $plan->status == 1 ? 'checked' : '' }} data-onstyle="success" data-offstyle="danger" data-on="Active" data-off="Deactive" data-width="100%" type="checkbox" name="status">
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                            <div class="row">

                                <!-- <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-12 bold uppercase">Period</label>
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <input type="number" class="form-control" value="{{ $plan->period }}" placeholder="Period" id="period" name="period">
                                                <span class="input-group-addon">
                                                    <select name="ptyp" id="ptyp">
                                                        <option value="day" {{ ($plan->ptyp == 'day')?'selected':'' }}>Day</option>
                                                        <option value="month" {{ ($plan->ptyp == 'month')?'selected':'' }}>Month</option>
                                                        <option value="year" {{ ($plan->ptyp == 'year')?'selected':'' }}>Year</option>
                                                    </select>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-12 bold uppercase">Return Per Day</label>
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Return Per Day" name="return" value="{{ $plan->return }}">
                                                <span class="input-group-addon" id="coin_code">
                                                    {{ $plan->category->code }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->

                                <div id="items-container">

                                    @if($features)

                                        <?php $i = 1; ?>

                                        @foreach($features as $feature)

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="col-md-12 bold uppercase">Feature <ins class="ind">{{ $i }}</ins></label>
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="features[]" value="{{ $feature }}">
                                                            <span class="input-group-addon rmv" style="background-color: #ed6b75;border-color: #ea5460;color: #fff;cursor: pointer;">
                                                        <i class="fa fa-remove"></i>
                                                    </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php $i++; ?>

                                        @endforeach

                                    @endif

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
                                    <button type="submit" class="btn green btn-block">Submit</button>
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
    <script>
        (function ($) {
            $(document).ready(function () {
                $('form selector').submit(function (e) {
                    e.preventDefault();
                    var val = $('input selector').val();
                    if (val > 0 && val < 999) {
                        return true;
                    } else {
                        // show any error msg
                    }
                });
            });
        })(jQuery);
    </script>
@endsection