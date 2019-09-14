@if ($message = Session::get('errors'))
    <div class="alert alert-danger" style="width: 100%">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif
