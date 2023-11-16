@extends('master')

@section('header')
<div class='container mb-4'>
    <h2 class='text-center'>Form</h2>
</div>
@endsection

@section('content')
<div class="container">
    <form method='post' action='form/saveInfo'>
        @csrf
        <div class="mb-3 row">
            <label for="inputName" class="col-4 col-form-label">Name</label>
            <div class="col-8 mb-3">
                @isset($name)
                    <input type="text" class="form-control" name="inputName" value={{$name}} id="inputName" required>
                @else
                    @isset($nameError)
                    <input type="text" class="form-control border-danger" name="inputName" id="inputName" required>
                    @else
                    <input type="text" class="form-control" name="inputName" id="inputName" required>
                    @endisset
                @endisset
            </div>

            <label for="inputSurname" class="col-4 col-form-label">Surname</label>
            <div class="col-8 mb-3">
                @isset ($surname)
                    <input type="text" class="form-control" name="inputSurname" value={{$surname}} id="inputSurname" required>
                @else
                    @isset($surnameError)
                    <input type="text" class="form-control border-danger" name="inputSurname" id="inputSurname" required>
                    @else
                    <input type="text" class="form-control" name="inputSurname" id="inputSurname" required>
                    @endisset
                @endisset
            </div>
            
            <label for="inputNif" class="col-4 col-form-label">Nif</label>
            <div class="col-8 mb-3">
                @isset ($nif)
                    @isset($nifError)
                        @if($nifError)
                        <input type="text" class="form-control border-danger" value={{$nif}} name="inputNif" id="inputNif" required>
                        @else
                        <input type="text" class="form-control" value={{$nif}} name="inputNif" id="inputNif" required>
                        @endif
                    @else
                    <input type="text" class="form-control" name="inputNif" value={{$nif}} id="inputNif" required>
                    @endisset
                @else
                    @isset($nifError)
                    <input type="text" class="form-control border-danger" name="inputNif" id="inputNif" required>
                    @else
                    <input type="text" class="form-control" name="inputNif" id="inputNif" required>
                    @endisset
                @endisset
            </div>
            
            <label for="inputSex" class="col-4 col-form-label">Sex</label>
            <div class="col-8 mb-3">
                @isset ($sex)
                    <input type="text" class="form-control" name="inputSex" value={{$sex}} id="inputSex" required>
                @else
                    @isset($sexError)
                    <input type="text" class="form-control border-danger" name="inputSex" id="inputSex" required>
                    @else
                    <input type="text" class="form-control" name="inputSex" id="inputSex" required>
                    @endisset
                @endisset
            </div>
            
            <label for="inputCivilState" class="col-4 col-form-label">Civil state</label>
            <div class="col-8 mb-3">
                @isset ($civilState)
                    <input type="text" class="form-control" name="inputCivilState" value={{$civilState}} id="inputCivilState" required>
                @else
                    @isset($civilError)
                    <input type="text" class="form-control border-danger" name="inputCivilState" id="inputCivilState" required>
                    @else
                    <input type="text" class="form-control" name="inputCivilState" id="inputCivilState" required>
                    @endisset
                @endisset
            </div>
        </div>

        <div class="mb-3 row">
            <div class="offset-sm-4 col-sm-8">
                <button type="submit" class="btn btn-primary">Send</button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('footer')

@endsection