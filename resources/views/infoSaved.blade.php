@extends('master')

@section('header')
<div class="container">
    <h3 class='text-success'>The information was saved</h3>
</div>
@endsection

@section('content')
<div class="container">
    <p class='mb-4'><strong>Thanks for filling our form</strong></p>
    <div class='container'>
        <p>This is your information:</p>
        <div>
            <div class="flex">
                <div>
                    <p class="mr-5">Name:</p>
                </div>
                <div>
                    <p>{{$name}}</p>
                </div>
            </div>
            <hr />
            <div class="flex">
                <div>
                    <p class="mr-5">Surname;</p>
                </div>
                <div>
                    <p>{{$surname}}</p>
                </div>
            </div>
            <hr />
            <div class="flex">
                <div>
                    <p class="mr-5">Nif:</p>
                </div>
                <div>
                    <p>{{$nif}}</p>
                </div>
            </div>
            <hr />
            <div class="flex">
                <div>
                    <p class="mr-5">Sex:</p>
                </div>
                <div>
                    <p>{{$sex}}</p>
                </div>
            </div>
            <hr />
            <div class="flex">
                <div>
                    <p class="mr-5">Civil state:</p>
                </div>
                <div>
                    <p>{{$civilState}}</p>
                </div>
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

        <button class='btn btn-danger'>Change information</button>
    </form>
    
    <div class="p-2">
        <a class='btn btn-success' href="/">Create another register</a>
    </div>
    <div class="p-2">
        <a class='btn btn-info' href="/getJSON/{{$name}}">See my information saved in local storage</a>
    </div>
    <div class="p-2">
        <a class='btn btn-info' href="/getXML/{{$name}}">See my information saved in public storage</a>
    </div>
</div>
@endsection