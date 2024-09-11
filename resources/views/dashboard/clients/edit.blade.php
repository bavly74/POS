@extends('layouts.dashboard.app')

<style>
    .phone-input {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        width: 50%;
    }
    .phone-input input {
        margin-right: 10px;
    }
    .remove-btn {
        color: red;
        cursor: pointer;
    }

    .address-input{
        display: flex;
        width: 50%;
    }
</style>

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.clients')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.clients.index') }}"> @lang('site.clients')</a></li>
                <li class="active">@lang('site.add')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('site.add')</h3>
                </div><!-- end of box header -->

                <div class="box-body">

                    @include('partials._errors')

                    <form action="{{ route('dashboard.clients.update',$client->id) }}" method="post" >

                        {{ csrf_field() }}


                        <div class="form-group">
                            <label>@lang('site.name')</label>
                            <input type="text" name="name" class="form-control" value="{{ $client->name }}">
                        </div>


                        @foreach($client->phone as $i=>$phone)
                            <div id="phoneContainer" class="form-group">
                                <label>@lang('site.phone') - {{$i+1}} </label>
                                <div class="phone-input">
                                    <input type="text" name="phone[]"  class="form-control" placeholder="Enter phone number" value="{{$phone}}" {{$i==0?'required':''}} >
                                    @if($i==0) <button type="button" class="btn btn-primary" id="addPhone">+ Phone</button>@else <span class="remove-btn btn btn-danger">-</span> @endif
                                </div>
                            </div>
                        @endforeach

                        @foreach($client->address as $i=>$address)
                            <div id="addressContainer" class="form-group">
                                <label>@lang('site.address') - {{$i+1}} </label>
                                <div class="address-input">
                                    <textarea name="address[]" class="form-control" placeholder="Enter address">{{$address}}</textarea>
                                    @if($i==0) <button type="button" class="btn btn-primary" id="addAddress">+ Address</button> @else  <span class="remove-address-btn btn btn-danger">-</span> @endif
                                </div>
                            </div>
                        @endforeach

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</button>
                        </div>

                    </form><!-- end of form -->

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#addPhone').on('click', function() {
            $('#phoneContainer').append(`

                    <div class="phone-input form-group">
                    <label>@lang('site.phone')</label>
                        <input type="text" name="phone[]" class="form-control" placeholder="Enter phone number" required>
                        <span class="remove-btn btn btn-danger">-</span>
                    </div>
                `);
        });

        $('#phoneContainer').on('click', '.remove-btn', function() {
            $(this).closest('.phone-input').remove();
        });
    });


    $(document).ready(function() {
        $('#addAddress').on('click', function() {
            $('#addressContainer').append(`
                   <div class="address-input form-group">
                    <label>@lang('site.address')</label>
                   <textarea name="address[]" class="form-control" placeholder="Enter address"></textarea>
                        <span class="remove-address-btn btn btn-danger">-</span>
                    </div>
                `);
        });

        $('#addressContainer').on('click', '.remove-address-btn', function() {
            $(this).closest('.address-input').remove();
        });
    });



</script>

