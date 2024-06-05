<?php
namespace App\dao;

use Illuminate\Support\Facades\DB;
use App\Exceptions\MonException;
use Illuminate\Database\QueryException;

class ServiceCommandes
{
    public function getListeCommandes()
    {
        try {
            $mesCommandes = DB::table('Commandes')
                ->select(
                    'Commandes.id AS commande_id',
                    'Commandes.date_commande',
                    'Commandes.total',
                    'Clients.nom AS nom_client',
                    'Clients.prenom AS prenom_client'
                )
                ->join('Clients', 'Commandes.client_id', '=', 'Clients.id')
                ->get();

            foreach ($mesCommandes as $commande) {
                $commande->plats = DB::table('Commande_Plat')
                    ->select(
                        'Menu.id AS plat_id',
                        'Menu.nom_plat',
                        'Menu.description',
                        'Menu.prix'
                    )
                    ->join('Menu', 'Commande_Plat.plat_id', '=', 'Menu.id')
                    ->where('Commande_Plat.commande_id', '=', $commande->commande_id)
                    ->get();

                // Calculer le total en fonction des plats associés
                $total = 0;
                foreach ($commande->plats as $plat) {
                    $total += $plat->prix;
                }

                // Mettre à jour le total de la commande
                DB::table('Commandes')
                    ->where('id', $commande->commande_id)
                    ->update(['total' => $total]);
            }

            $mesPlats = DB::table('Menu')->select('id', 'nom_plat', 'prix')->get();

            return ['mesCommandes' => $mesCommandes, 'mesPlats' => $mesPlats];

        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }

    public function ajoutCommande($date_commande, $client_id)
    {
        try {
            $date_commande = \Carbon\Carbon::createFromFormat('d/m/Y', $date_commande)->format('Y-m-d');

            DB::table('Commandes')->insert(
                [
                    'date_commande' => $date_commande,
                    'client_id' => $client_id
                ]
            );
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }
}
