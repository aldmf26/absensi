@include('template._header')
@if ($pesan = Session::get('sukses'))
<div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>    
    <strong>{{ $pesan }}</strong>
</div>
@endif

@if ($pesan = Session::get('error'))
<div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>    
    <strong>{{ $pesan }}</strong>
</div>
@endif