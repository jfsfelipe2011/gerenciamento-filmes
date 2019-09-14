@if ($message = Session::get('success'))
    <div class="alert alert-success" style="width: 100%">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif
