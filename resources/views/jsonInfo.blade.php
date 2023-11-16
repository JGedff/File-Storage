@extends('master')

@section('header')
<div class='container mb-4'>
    <h2 class='text-center'>Information saved as JSON</h2>
</div>
@endsection

@section('content')
<div class="container">
    <div class="table-responsive">
        <table class="table table-striped
        table-hover	
        table-bordered
        table-light
        align-middle">
            <thead class="table-light">
                <tr>
                    <th>Complete Name</th>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Nif</th>
                    <th>Sex</th>
                    <th>Civil State</th>
                    <th>See all registers from user</th>
                </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($json as $user)
                    <tr>
                        <td><strong>{{ $user->name }} {{ $user->surname }}</strong></td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->surname }}</td>
                        <td>{{ $user->nif }}</td>
                        <td>{{ $user->sex }}</td>
                        <td>{{ $user->civilState }}</td>
                        <td>
                            <a href="/getJSON/{{ $user->name }}" class="btn btn-info mr-1">JSON</a>
                            <a href="/getXML/{{ $user->name }}" class="btn btn-info">XML</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
        </table>
    </div>
</div>
@endsection

@section('footer')
<div class="container">
    <div class="p-2">
        <a class='btn btn-info' href="/getXML">See all information in XML</a>
    </div>
</div>
@endsection