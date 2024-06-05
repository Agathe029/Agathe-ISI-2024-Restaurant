@extends('layouts.master')

@section('content')
@if(session('success'))
    <div class="alert alert-success" role="alert" style="position: absolute; top: 80px; right: 10px;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger" role="alert" style="position: absolute; top: 80px; right: 10px;">
        {{ session('error') }}
    </div>
@endif

<meta name="csrf-token" content="{{ csrf_token() }}">

<h1>Carte</h1>
<table class="table">
    <thead>
        <tr>
            <th>Nom du Plat</th>
            <th>Description</th>
            <th>Prix</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($mesMenus as $menu)
            <tr>
                <td>{{ $menu->nom_plat }}</td>
                <td>{{ $menu->description }}</td>
                <td>{{ $menu->prix }}€</td>
                <td>
                    <button type="button" class="btn btn-link edit-btn" data-menu-id="{{ $menu->menu_id }}">Edit</button>
                </td>
                <td>
                    <form action="{{ route('supprimerPlat', ['id' => $menu->menu_id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link" style="padding: 0; border: none; background: none;">
                            <img src="{{ asset('assets/images/bin.png') }}" alt="Supprimer"
                                style="width: 20px; height: 20px;">
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        <tr>
            <form method="POST" action="{{ route('ajouterPlat.post') }}" enctype="multipart/form-data">
                @csrf
                <td><input type="text" class="form-control" name="nom_plat" placeholder="Nom du Plat" required></td>
                <td><input type="text" class="form-control" name="description" placeholder="Description" required></td>
                <td><input type="number" class="form-control" name="prix" placeholder="Prix" min="0" step="0.01"
                        required></td>
                <td>
                    <input type="file" class="form-control-file" name="image_url" accept="image/*">
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </td>
            </form>
        </tr>
    </tbody>
</table>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.edit-btn');
        editButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const menuId = this.getAttribute('data-menu-id');
                const menuRow = this.closest('tr');
                const isEditing = menuRow.classList.contains('editing');

                if (!isEditing) {
                    menuRow.classList.add('editing');

                    const cells = menuRow.querySelectorAll('td');
                    cells.forEach(function (cell, index) {
                        if (index !== cells.length - 2 && index !== cells.length - 1) { // Skip last cell with delete button
                            const text = cell.innerText;
                            cell.innerHTML = `<input type="text" class="form-control" name="menu_${menuId}[${index}]" value="${text}">`;
                        }
                    });

                    button.innerText = 'OK';
                    button.classList.remove('edit-btn');
                    button.classList.add('ok-btn');

                    const form = menuRow.querySelector('form');

                    // Update action attribute of form
                    form.setAttribute('action', `/modifierPlat/${menuId}`);

                    const okButton = menuRow.querySelector('.ok-btn');
                    okButton.addEventListener('click', function () {
                        const formData = new FormData(form);
                        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                        formData.append('menu_id', menuId);

                        const url = `/modifierPlat/${menuId}`;

                        fetch(url, {
                            method: 'POST',
                            body: formData,
                        })
                            .then(response => response.json())
                            .then(data => {
                                menuRow.classList.remove('editing');
                                cells.forEach(function (cell, index) {
                                    if (index !== cells.length - 2 && index !== cells.length - 1) {
                                        cell.innerText = form.elements[`menu_${menuId}[${index}]`].value;
                                    }
                                });
                                button.innerText = 'Edit';
                                button.classList.remove('ok-btn');
                                button.classList.add('edit-btn');
                            })
                            .catch(error => {
                                console.error(error);
                            });
                    });
                }
            });
        });
    });

</script>


@endsection