@if (session('success'))
    <div class="flash flash-success" role="status">@include('partials.icon', ['name' => 'check']) {{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="flash flash-error" role="alert">{{ session('error') }}</div>
@endif
@if (session('status'))
    <div class="flash flash-success" role="status">{{ session('status') }}</div>
@endif
@if ($errors->any())
    <div class="flash flash-error" role="alert">
        <div>Please fix the following:
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    </div>
@endif
