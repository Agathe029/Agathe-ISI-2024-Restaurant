<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Input;
use Request;
use App\Exceptions\MonException;
use App\Exceptions\Exception;
use App\dao\ServiceMenu;
use Illuminate\Support\Facades\DB;


class MenuController extends Controller
{

    public function listerPlats()
    {
        try {
            $unServiceMenu = new ServiceMenu();
            $mesMenus = $unServiceMenu->getListeMenu();


            return view('vues/listePlats', compact('mesMenus'));
        } catch (MonException $e) {
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        } catch (Exception $e) {
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        }
    }




    public function postAjouterPlat(Request $request)
    {
        try {
            $nom_plat = Request::input('nom_plat');
            $description = Request::input('description');
            $prix = Request::input('prix');
            $image_url = Request::input('image_url');

            $unServiceMenu = new ServiceMenu();
            $unServiceMenu->ajoutPlat($nom_plat, $description, $prix, $image_url);
            return redirect()->route('listePlats')->with('success', 'Plat ajouté avec succès');

        } catch (MonException $e) {
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        } catch (Exception $e) {
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        }
    }
    public function modifierPlat(Request $request)
    {
        try {
            $plat_id = Request::input('menu_id');
            $nom_plat = Request::input('nom_plat');
            $description = Request::input('description');
            $prix = Request::input('prix');

            // Mettre à jour le plat dans la base de données
            DB::table('Menu')
                ->where('id', $plat_id)
                ->update([
                    'nom_plat' => $nom_plat,
                    'description' => $description,
                    'prix' => $prix
                ]);

            // Rediriger avec un message de succès
            return redirect()->route('listePlats')->with('success', 'Plat modifié avec succès');
        } catch (MonException $e) {
            $monErreur = $e->getMessage();
            return response()->json(['success' => false, 'message' => $monErreur]);
        } catch (Exception $e) {
            $monErreur = $e->getMessage();
            return response()->json(['success' => false, 'message' => $monErreur]);
        }
    }


    public function supprimerPlat($id)
    {
        try {
            $commande = DB::table('Commande_Plat')->where('plat_id', $id)->first();
            if ($commande) {
                return redirect()->back()->with('error', 'Impossible de supprimer le plat, il est associé à une commande');
            }

            DB::table('Menu')->where('id', $id)->delete();

            return redirect()->route('listePlats')->with('success', 'Plat supprimé avec succès');
        } catch (MonException $e) {
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        } catch (Exception $e) {
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        }
    }


}
