<?php

namespace App\dao;

use Illuminate\Support\Facades\DB;
use App\Exceptions\MonException;
use Illuminate\Database\QueryException;

class ServiceMenu
{
    public function getListeMenu()
    {
        try {
            $mesMenus = DB::table('Menu')
                ->select(
                    'Menu.id AS menu_id',
                    'Menu.nom_plat',
                    'Menu.description',
                    'Menu.prix',
                    'Menu.image_url',
                )
                ->get();

            return $mesMenus;
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }

    public function ajoutPlat($nom_plat, $description, $prix, $image_url)
    {
        try {
            DB::table('Menu')->insert(
                [
                    'nom_plat' => $nom_plat,
                    'description' => $description,
                    'prix' => $prix,
                    'image_url' => $image_url
                ]
            );
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }

}
