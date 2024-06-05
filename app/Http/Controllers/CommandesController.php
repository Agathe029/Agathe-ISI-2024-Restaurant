<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Request;
use App\Exceptions\MonException;
use Illuminate\Support\Facades\DB;


use App\dao\ServiceCommandes;

class CommandesController extends Controller
{
    public function listerCommandes()
    {
        try {
            $serviceCommandes = new ServiceCommandes();
            $data = $serviceCommandes->getListeCommandes();
            $mesCommandes = $data['mesCommandes'];
            $mesPlats = $data['mesPlats'];

            $mesClients = DB::table('Clients')->select('id', 'nom', 'prenom')->get();

            return view('vues/listeCommandes', compact('mesCommandes', 'mesPlats', 'mesClients'));
        } catch (MonException $e) {
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        }
    }



    public function postAjouterCommande(Request $request)
    {
        try {
            $date_commande = Request::input('date_commande');
            $client_id = Request::input('client_id');

            $unServiceCommandes = new ServiceCommandes();
            $unServiceCommandes->ajoutCommande($date_commande, $client_id);

            return redirect()->route('listeCommandes')->with('success', 'Commande ajoutée avec succès');
        } catch (MonException $e) {
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        } catch (Exception $e) {
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        }
    }


    public function supprimerCommande($id)
    {
        try {

            DB::table('Commandes')->where('id', $id)->delete();

            return redirect()->route('listeCommandes')->with('success', 'Commande supprimée avec succès');
        } catch (MonException $e) {
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        } catch (Exception $e) {
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        }
    }

    public function postAjouterPlatCommande(Request $request)
    {
        try {
            $commande_id = Request::input('commande_id');
            $plat_id = Request::input('plat_id');

            DB::table('Commande_Plat')->insert([
                'commande_id' => $commande_id,
                'plat_id' => $plat_id,
            ]);

            return redirect()->route('listeCommandes')->with('success', 'Plat ajouté à la commande avec succès');
        } catch (MonException $e) {
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        } catch (Exception $e) {
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        }
    }


    public function supprimerPlatCommande($id)
    {
        try {
            DB::table('Commande_Plat')->where('plat_id', $id)->delete();

            return redirect()->route('listeCommandes')->with('success', 'Plat supprimé de la commande avec succès');
        } catch (MonException $e) {
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        } catch (Exception $e) {
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        }
    }



}
