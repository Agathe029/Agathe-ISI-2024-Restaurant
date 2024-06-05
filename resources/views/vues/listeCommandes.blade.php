@extends('layouts.master')

@section('content')
@if(session('success'))
    <div class="alert alert-success" role="alert" style="position: absolute; top: 100px; right: 10px;">
        {{ session('success') }}
    </div>
@endif

<h1>Liste des Commandes</h1>
<table class="table">
    <thead>
        <tr>
            <th>Détails</th>
            <th>Date de commande</th>
            <th>Client</th>
            <th>Total</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($mesCommandes as $commande)
            <tr>
                <td style="width: 150px;">
                    <button class="toggle-plats">▶</button>
                </td>
                <td>{{ \Carbon\Carbon::parse($commande->date_commande)->isoFormat('D MMMM YYYY') }}</td>
                <td>{{ $commande->prenom_client }} {{ $commande->nom_client }}</td>
                <td>{{ $commande->total }}</td>
                <td>
                    <form action="{{ route('supprimerCommande', ['id' => $commande->commande_id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link" style="padding: 0; border: none; background: none;">
                            <img src="{{ asset('assets/images/bin.png') }}" alt="Supprimer"
                                style="width: 20px; height: 20px;">
                        </button>
                    </form>
                </td>
            </tr>
            <tr class="plats-row" style="display: none;">
                <td colspan="4">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Nom du Plat</th>
                                <th>Description</th>
                                <th>Prix</th>
                                <!-- <th></th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($commande->plats as $plat)
                                <tr>
                                    <td>{{ $plat->nom_plat }}</td>
                                    <td>{{ $plat->description }}</td>
                                    <td>{{ $plat->prix }}€</td>
                                    <td>
                                        <form method="POST"
                                            action="{{ route('supprimerPlatCommande', ['id' => $plat->plat_id]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link"
                                                style="padding: 0; border: none; background: none;">
                                                <img src="{{ asset('assets/images/bin.png') }}" alt="Supprimer"
                                                    style="width: 20px; height: 20px;">
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <form method="POST" action="{{ route('ajouterPlatCommande.post') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="commande_id" value="{{ $commande->commande_id }}">
                                    <td colspan="3">
                                        <select name="plat_id" class="form-control" required>
                                            @foreach ($mesPlats as $plat)
                                                <option value="{{ $plat->id }}">{{ $plat->nom_plat }} - {{ $plat->prix }}€
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-primary">Ajouter</button>
                                    </td>
                                </form>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        @endforeach


    </tbody>
</table>
<table>
    <tr>
        <form method="POST" action="{{ route('ajouterCommande.post') }}" enctype="multipart/form-data">
            @csrf
            <td><input type="text" class="form-control" name="date_commande" placeholder="Date Commande" required>
            </td>
            <td>
                <select class="form-control" name="client_id" required>
                    @foreach ($mesClients as $client)
                        <option value="{{ $client->id }}">{{ $client->prenom }} {{ $client->nom }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </td>
        </form>
    </tr>
</table>

<script>
    document.querySelectorAll('.toggle-plats').forEach((button) => {
        button.addEventListener('click', function () {
            const platsRow = this.closest('tr').nextElementSibling;
            if (platsRow.style.display === 'none') {
                platsRow.style.display = 'table-row';
                this.textContent = '▼';
            } else {
                platsRow.style.display = 'none';
                this.textContent = '▶';
            }
        });
    });
</script>
@endsection