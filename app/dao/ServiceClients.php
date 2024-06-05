<?php

namespace App\dao;

use Illuminate\Support\Facades\DB;
use App\Exceptions\MonException;
use Illuminate\Database\QueryException;

class ServiceClients
{
    public function getListeClients()
    {
        try {
            $mesClients = DB::table('Clients')->get();
            return $mesClients;
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }



    public function ajoutClient($nom, $prenom, $email, $telephone, $adresse)
    {
        try {
            DB::table('Clients')->insert([
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'telephone' => $telephone,
                'adresse' => $adresse
            ]);
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }
}
