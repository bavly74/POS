@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

@if(session('unsuccessMessage'))
    <div class="alert alert-danger">
        {{ session('unsuccessMessage') }}
    </div>
@endif
