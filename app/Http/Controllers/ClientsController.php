<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Request;
use App\Exceptions\MonException;
use App\dao\ServiceClients;
use Illuminate\Support\Facades\DB;

class ClientsController extends Controller
{
    public function listerClients()
    {
        try {
            $serviceClients = new ServiceClients();
            $mesClients = $serviceClients->getListeClients();
            return view('vues/listeClients', compact('mesClients'));
        } catch (MonException $e) {
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        }
    }




    public function postAjouterClient(Request $request)
    {
        try {
            $nom = Request::input('nom');
            $prenom = Request::input('prenom');
            $email = Request::input('email');
            $telephone = Request::input('telephone');
            $adresse = Request::input('adresse');

            $unServiceClients = new ServiceClients();
            $unServiceClients->ajoutClient($nom, $prenom, $email, $telephone, $adresse);
            return redirect()->route('listeClients')->with('success', 'Client ajouté avec succès');

        } catch (MonException $e) {
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        } catch (Exception $e) {
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        }
    }


    public function supprimerClient($id)
    {
        try {
            $commande = DB::table('Commandes')->where('client_id', $id)->first();
            if ($commande) {
                return redirect()->back()->with('error', 'Impossible de supprimer le client, il est associé à une commande');
            }

            DB::table('Clients')->where('id', $id)->delete();

            return redirect()->route('listeClients')->with('success', 'Client supprimé avec succès');
        } catch (MonException $e) {
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        } catch (Exception $e) {
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        }
    }


}
