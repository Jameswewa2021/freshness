@extends('layouts.user-frontend.user-dashboard')

@section('style')
    <link href="{{ asset('assets/admin/css/bootstrap-fileinput.css') }}" rel="stylesheet">
    <style>
        input[type="submit"]{
               width: 15% !important;
               color:#fff;
               background-color:#00ADEF;
        }
        @media screen and (max-width: 900px){
            input[type="submit"]{
               width: 100% !important;
               color:#fff;
               background-color:#00ADEF;
                }
        }
        input[type="text"] {
            width: 100%;
        }

        input[type="email"] {
        }
        input[readonly] {
          background-color: #00ADEF;
          color:#fff;
        }
        option{
            background-color: #fff !important;
        }
        .active{
              border-left: 0px solid #1E88E5;
            }
    </style>

@endsection
@section('content')


<div class="clearfix"></div>
<div class="container-fuild">
      <div id="personal" class="tab-pane fade in active">
            <form method="post" id="fornimginp" action="{{route('verify')}}" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                @if($user->id_image == "0")
                    <input style="padding: 30px !important;" type="file" name="id_image" id="id_image"/>
                    <input type="submit" >
                @else
                <input style="font-size:18px;padding: 30px !important;background-color: #00ADEF;color: #fff" type="text" value="Your document is being revised" "/>
                @endif
            </form>
        </div>
</div>
@endsection
@section('script')
    <script src="{{ asset('assets/admin/js/bootstrap-fileinput.js') }}"></script>

    @if (session('message'))

        <script type="text/javascript">

            $(document).ready(function(){

                swal("Success!", "{{ session('message') }}", "success");

            });

        </script>

    @endif

    @if (session('alert'))

        <script type="text/javascript">

            $(document).ready(function(){

                swal("Sorry!", "{!! session('alert') !!}", "error");

            });

        </script>

    @endif

@endsection
