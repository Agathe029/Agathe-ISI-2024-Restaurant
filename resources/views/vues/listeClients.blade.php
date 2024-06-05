@extends('layouts.master')

@section('content')
<h1>Liste des Clients</h1>
<!-- <a href="{{ route('ajouterClient') }}" class="btn btn-primary">Ajouter un client</a> -->

@if(session('success'))
    <div class="alert alert-success" role="alert" style="position: absolute; top: 100px; right: 10px;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger" role="alert" style="position: absolute; top: 100px; right: 10px;">

        {{ session('error') }}
    </div>
@endif


<table class="table">
    <thead>
        <tr>
            <!-- <th scope="col">ID</th> -->
            <th scope="col">Nom</th>
            <th scope="col">Prénom</th>
            <th scope="col">Email</th>
            <th scope="col">Adresse</th>
            <th scope="col">Téléphone</th>
            <!-- Ajoutez d'autres colonnes au besoin -->
        </tr>
    </thead>
    <tbody>
        @foreach ($mesClients as $client)
            <tr>
                <!-- <td>{{ $client->id }}</td> -->
                <td>{{ $client->nom }}</td>
                <td>{{ $client->prenom }}</td>
                <td>{{ $client->email }}</td>
                <td>{{ $client->adresse }}</td>
                <td>{{ $client->telephone }}</td>
                <td>
                    <form action="{{ route('supprimerClient', ['id' => $client->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link" style="padding: 0; border: none; background: none;">
                            <img src="{{ asset('assets/images/bin.png') }}" alt="Supprimer"
                                style="width: 20px; height: 20px;">
                        </button>
                    </form>
                </td>
                <!-- Ajoutez d'autres cellules au besoin -->
            </tr>
        @endforeach


        <tr>
            <form method="POST" action="{{ route('ajouterClient.post') }}">
                @csrf
                <td><input type="text" class="form-control" name="nom" placeholder="Nom" required></td>
                <td><input type="text" class="form-control" name="prenom" placeholder="Prénom" required></td>
                <td><input type="email" class="form-control" name="email" placeholder="Email" required></td>
                <td><input type="text" class="form-control" name="adresse" placeholder="Adresse" required></td>
                <td><input type="text" class="form-control" name="telephone" placeholder="Téléphone" required></td>

                <td>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </td>
            </form>
        </tr>

    </tbody>
</table>
@endsection