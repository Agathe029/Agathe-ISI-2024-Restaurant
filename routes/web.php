<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\CommandesController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('home');
});

Route::get('/listePlats', [MenuController::class, 'listerPlats'])->name('listePlats');

Route::get('/listeClients', [ClientsController::class, 'listerClients'])->name('listeClients');

Route::get('/listeCommandes', [CommandesController::class, 'listerCommandes'])->name('listeCommandes');

Route::get('/ajouterPlat', [MenuController::class, 'ajouterPlat'])->name('ajouterPlat');
Route::post('/ajouterPlat', [MenuController::class, 'postAjouterPlat'])->name('ajouterPlat.post');
Route::put('/modifierPlat/{id}', [MenuController::class, 'modifierPlat'])->name('modifierPlat');
Route::delete('/supprimerPlat/{id}', [MenuController::class, 'supprimerPlat'])->name('supprimerPlat');
// routes/web.php

Route::get('/ajouterClient', [ClientsController::class, 'ajouterClient'])->name('ajouterClient');
Route::post('/ajouterClient', [ClientsController::class, 'postAjouterClient'])->name('ajouterClient.post');
Route::delete('/supprimerClient/{id}', [ClientsController::class, 'supprimerClient'])->name('supprimerClient');

Route::post('/ajouterCommande', [CommandesController::class, 'postAjouterCommande'])->name('ajouterCommande.post');
Route::delete('/supprimerCommande/{id}', [CommandesController::class, 'supprimerCommande'])->name('supprimerCommande');


Route::post('/ajouter-plat-commande', [CommandesController::class, 'postAjouterPlatCommande'])->name('ajouterPlatCommande.post');
Route::delete('/commandes/plats/{id}', [CommandesController::class, 'supprimerPlatCommande'])->name('supprimerPlatCommande');
