@if($errors->any() )
    <div class="alert alert-danger">
        <h3>Error Occured!</h3>
        <ul>
            @foreach($errors->all() as $errors)
                <li> {{ $errors }}</li>
            @endforeach
        </ul>
    </div>
@endif
