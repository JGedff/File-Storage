@extends('master')

@section('header')
<div class="container">
    <h3 class='text-danger'>The information was not saved</h3>
</div>
@endsection

@section('content')
<div class="container">
    <p class='mt-4 mb-0'><strong>Check out that all fields aren't empty and the nif field is a real nif</strong></p>
    <p>This is your information:</p>
    <div class='container'>
        <div>
            <div class="flex">
                @if ($name)
                    <div>
                        <p class="mr-5">Name:</p>
                    </div>
                    <div>
                        <p>{{$name}}</p>
                    </div>
                @else
                    <div>
                        <p class="mr-5 text-danger">Name:</p>
                    </div>
                    <div>
                        <p class="text-danger">This field is required</p>
                    </div>
                @endif
            </div>
            <hr />
            <div class="flex">
                @if ($surname)
                    <div>
                        <p class="mr-5">Surname:</p>
                    </div>
                    <div>
                        <p>{{$surname}}</p>
                    </div>
                @else
                    <div>
                        <p class="mr-5 text-danger">Surname:</p>
                    </div>
                    <div>
                        <p class="text-danger">This field is required</p>
                    </div>
                @endif
            </div>
            <hr />
            <div class="flex">
                @if ($nif && !$nifError)
                    <div>
                        <p class="mr-5">Nif:</p>
                    </div>
                    <div>
                        <p>{{$nif}}</p>
                    </div>
                @elseif (!$nif)
                    <div>
                        <p class="mr-5 text-danger">Nif:</p>
                    </div>
                    <div>
                        <p class="text-danger">This field is required</p>
                    </div>
                @elseif ($nifError)
                    <div>
                        <p class="mr-5 text-danger">Nif:</p>
                    </div>
                    <div>
                        <p class="text-danger">{{$nif}}</p>
                        <p class="text-danger">Please, check that your nif is a real nif</p>
                    </div>
                @endif
            </div>
            <hr />
            <div class="flex">
                @if ($sex)
                    <div>
                        <p class="mr-5">Sex:</p>
                    </div>
                    <div>
                        <p>{{$sex}}</p>
                    </div>
                @else
                    <div>
                        <p class="mr-5 text-danger">Sex:</p>
                    </div>
                    <div>
                        <p class="text-danger">This field is required</p>
                    </div>
                @endif
            </div>
            <hr />
            <div class="flex">
                @if ($civilState)
                    <div>
                        <p class="mr-5">Civil state:</p>
                    </div>
                    <div>
                        <p>{{$civilState}}</p>
                    </div>
                @else
                    <div>
                        <p class="mr-5 text-danger">Civil state:</p>
                    </div>
                    <div>
                        <p class="text-danger">This field is required</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<div class="container">
    <form method='post' class="p-2" action='/'>
        @csrf
        <div style='display: none'>
            <input type="text" class="form-control" value={{$name}} name="inputName" id="inputName">
            <input type="text" class="form-control" value={{$surname}} name="inputSurname" id="inputSurname">
            <input type="text" class="form-control" value={{$nif}} name="inputNif" id="inputNif">
            <input type="text" class="form-control" value={{$sex}} name="inputSex" id="inputSex">
            <input type="text" class="form-control" value={{$civilState}} name="inputCivilState" id="inputCivilState">
        </div>

        <button class='btn btn-success'>Change information</button>
    </form>
</div>
@endsection