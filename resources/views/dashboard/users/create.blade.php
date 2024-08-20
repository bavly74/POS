@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.users')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.users') }}"> @lang('site.users')</a></li>
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

                    <form action="{{ route('dashboard.users.store') }}" method="post" enctype="multipart/form-data">

                        {{ csrf_field() }}


                        <div class="form-group">
                            <label>@lang('site.first_name')</label>
                            <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}">
                        </div>

                        <div class="form-group">
                            <label>@lang('site.last_name')</label>
                            <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}">
                        </div>

                        <div class="form-group">
                            <label>@lang('site.email')</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                        </div>

                        <div class="form-group">
                            <label>@lang('site.image')</label>
                            <input type="file" name="image" class="form-control">
                        </div>


                        <div class="form-group">
                            <label>@lang('site.password')</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>@lang('site.password_confirmation')</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>


                        <div class="form-group">
                            <label>@lang('site.permissions')</label>
                            <div class="nav-tabs-custom">

                                    @php
                                    $permissions=['users','products','categories'];
                                    @endphp

                                    @php
                                    $maps=['create','read','update','delete'];
                                    @endphp

                                <ul class="nav nav-tabs">
                                    @foreach($permissions as $i=>$permission)
                                    <li class="{{ $i == 0 ? 'active' : '' }}"><a href="#{{ $permission }}" data-toggle="tab">@lang('site.' . $permission)</a></li>
                                    @endforeach
                                </ul>



                                <div class="tab-content">
                                @foreach($permissions as $i=>$permission)
                                    <div class="tab-pane {{ $i == 0 ? 'active' : '' }}" id="{{ $permission }}">
                                            @foreach ($maps as $map)
                                                <label><input type="checkbox" name="permissions[]" value="{{ $permission . '_' . $map }}"> @lang('site.' . $map)</label>
                                                @endforeach
                                    </div>
                                @endforeach
                                </div>

                            </div>
                        </div>



                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</button>
                        </div>

                    </form><!-- end of form -->

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
