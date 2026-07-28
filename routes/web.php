<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PaysController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RitualController;
use App\Http\Controllers\RituelController;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RetraitController;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\DejeunerController;
use App\Http\Controllers\DiviniteController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LogementController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\QuartierController;
use App\Http\Controllers\SousMenuController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ConstanceController;
use App\Http\Controllers\EquipementController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\ContactHoteController;
use App\Http\Controllers\HebergementController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SupabaseAuthController;
use App\Http\Controllers\TypelogementController;
use App\Http\Controllers\FavoriteShareController;
use App\Http\Controllers\LogementPhotoController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\QuartierPointsController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserPreferenceController;
use App\Http\Controllers\LogementRitualsController;
use App\Http\Controllers\LogementRituelsController;
use App\Http\Controllers\LogementDejeunerController;
use App\Http\Controllers\LogementDivinitesController;
use App\Http\Controllers\LogementReglementController;
use App\Http\Controllers\LogementEquipementsController;
use App\Http\Controllers\LogementDisponibiliteController;
use App\Http\Controllers\ReviewController;

// Route::get('/lang/{locale}', [LanguageController::class, 'switch'])
//     ->name('language.switch');




// Page d'accueil du portail
Route::get('/', [PortalController::class, 'index'])->name('portal');
Route::prefix('hoost')->name('hoost.')->group(function () {
// Lien public (pas besoin d’être connecté)
Route::get('/favoris/public/{token}', [FavoriteController::class, 'showPublic'])->name('favorites.share.show');
Route::get('/auth/supabase/redirect/{provider}', [SupabaseAuthController::class, 'redirect'])->name('supabase.redirect');
Route::get('/auth/supabase/callback', [SupabaseAuthController::class, 'callback'])->name('supabase.callback');
Route::post('/auth/supabase/handle', [SupabaseAuthController::class, 'handle'])->name('supabase.handle');
Route::get('/', [AccueilController::class, 'index'])->name('accueil');
Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('language.switch');
//Contact
Route::resource('contacts', ContactController::class)->except(['show']);
Route::get('/contactez-nous', [ContactController::class,'liste'])->name('contacts.liste');
//Hébergements c'est affichage des logements sur la page d'accueil
Route::resource('hebergements', HebergementController::class);
Route::get('/details/hote/{id}', [HebergementController::class, 'detailHote'])->name('details.hote');
// Contact hôte sans logement précis
Route::post('/hote/{host}/contact', [ContactHoteController::class, 'send'])->name('hote.contact');
// Contact hôte à propos d’un logement précis
Route::post('/hote/{host}/logements/{logement}/contact', [ContactHoteController::class, 'send'])->name('logements.contact');
// Newsletter
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/unsubscribe/{token}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');
Route::post('/register', [AuthController::class, 'store'])->name('register');
Route::get('/login', [AuthController::class, 'loginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
/* --- Demande reset password --- */
Route::get('/password/forgot', [AuthController::class,'forgotForm'])->name('password.forgot.form');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.forgot.submit');
Route::get('/reset-password', [AuthController::class, 'showResetForm'])->name('reset.password.form');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
Route::middleware(['auth', 'permission'])->group(function () {
    Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::get('reviews/{reservation}/avis/{user}', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('reviews/{reservation}/avis/{user}', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    // Routes pour les signalements
    Route::resource('reports',ReportController::class);
    // // Routes de réservation
    // Route::get('/logements/{logement}/reserver', [ReservationController::class, 'create'])->name('reservations.create');
    Route::get('/reservations/checkout/{logement}', [ReservationController::class, 'checkout'])->name('reservations.checkout');
    Route::post('/reservations/{logement}/checkout', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/fedapay/callback', [ReservationController::class, 'fedapayCallback'])->name('reservations.fedapay.callback');
    Route::get('/reservations/kkiapay/callback', [ReservationController::class, 'kkiapayCallback'])->name('reservations.kkiapay.callback');
    // Routes protégées par authentification
    Route::get('/recommandations', [RecommendationController::class, 'index'])->name('recommendations');
    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('roles/permissions', RolePermissionController::class);
    Route::resource('pays', PaysController::class)->except(['show']);
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard/stats', [HomeController::class, 'stats'])->name('dashboard.stats');
    //Route Constances
    Route::resource('constances', ConstanceController::class)->except(['show']);
    //Route Modules
    Route::resource('modules', ModuleController::class)->except(['show']);
    //Route Menus
    Route::resource('menus', MenuController::class)->except(['show']);
    //Route SousMenus
    Route::resource('sousmenus', SousMenuController::class)->except(['show']);
    //Route Roles
    Route::resource('roles', RoleController::class)->except(['show']);
    //Route Categories
    Route::resource('categories', CategorieController::class)->except(['show']);
    //Route Projets
    Route::resource('projets', ProjetController::class)->except(['show']);
    //Divinités
    Route::resource('divinites', DiviniteController::class)->except(['show']);
    //TypeLogements
    Route::resource('typelogements', TypelogementController::class)->except(['show']);
    //Equipements
    Route::resource('equipements', EquipementController::class)->except(['show']);
    //Route des transactions
    Route::resource('transactions',TransactionController::class);
    // Logements
    Route::get('/logements/visiteurs', [LogementController::class, 'liste'])->name('logements.visiteurs.index');
    Route::resource('logements', LogementController::class);
    //Route Rituels
    Route::resource('rituels', RituelController::class)->except(['show']);
    //Affectation equipements to logements
    Route::get('logements/{logement}/equipements', [LogementEquipementsController::class, 'edit'])->name('logements.equipements.edit');
    Route::put('logements/{logement}/equipements', [LogementEquipementsController::class, 'update'])->name('logements.equipements.update');
    //Affectation points forts to quartiers
    Route::get('quartiers/{quartier}/pointforts', [QuartierPointsController::class, 'edit'])->name('quartiers.points.edit');
    Route::put('quartiers/{quartier}/pointforts', [QuartierPointsController::class, 'update'])->name('quartiers.points.update');
    //Routes Divinités to Logements
    Route::get('logements/{logement}/divinites', [LogementDivinitesController::class, 'edit'])->name('logements.divinites.edit');
    Route::put('logements/{logement}/divinites', [LogementDivinitesController::class, 'update'])->name('logements.divinites.update');
    //Routes Rituels to Logements
    Route::get('logements/{logement}/rituels', [LogementRituelsController::class, 'edit'])->name('logements.rituels.edit');
    Route::put('logements/{logement}/rituels', [LogementRituelsController::class, 'update'])->name('logements.rituels.update');
    // Routes pour les règles de logement
    Route::get('logements/{logement}/reglements', [LogementReglementController::class, 'index'])->name('logements.reglements.index');
    Route::get('logements/{logement}/reglements/create', [LogementReglementController::class, 'create'])->name('logements.reglements.create');
    Route::post('logements/{logement}/reglements', [LogementReglementController::class, 'store'])->name('logements.reglements.store');
    Route::get('logements/{logement}/reglements/{reglement}/edit', [LogementReglementController::class, 'edit'])->name('logements.reglements.edit');
    Route::put('logements/{logement}/reglements/{reglement}', [LogementReglementController::class, 'update'])->name('logements.reglements.update');
    Route::delete('logements/{logement}/reglements/{reglement}', [LogementReglementController::class, 'destroy'])->name('logements.reglements.destroy');
    //Route Favorites Lists
    Route::get('/favoris', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favoris/liste', [FavoriteController::class, 'storeList'])->name('favorites.lists.store');
    Route::patch('/favoris/liste/{favorite}', [FavoriteController::class, 'renameList'])->name('favorites.lists.rename');
    Route::delete('/favoris/liste/{favorite}', [FavoriteController::class, 'deleteList'])->name('favorites.lists.delete');
    Route::post('/favoris/liste/{favorite}/add', [FavoriteController::class, 'add'])->name('favorites.items.add');
    Route::delete('/favoris/liste/{favorite}/remove/{logement}', [FavoriteController::class, 'removeItem'])->name('favorites.items.remove');
    // Activer / désactiver le partage
    Route::post('/favoris/listes/{favorite}/share-toggle', [FavoriteController::class, 'toggleShare'])->name('favorites.lists.share.toggle');
    //Photo logements
    // Ajouter des photos sur un logement existant
    Route::post('/logements/{logement}/photos', [LogementPhotoController::class, 'store'])->name('logements.photos.store');
    // Supprimer une photo
    Route::delete('/logements/{logement}/photos/{photo}', [LogementPhotoController::class, 'destroy'])->name('logements.photos.destroy');
    //Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    // Mise à jour du profil
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Mise à jour de la photo de profil
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.update-photo');
    Route::get('/parametres', [UserController::class, 'showSettings'])->name('user.settings');
    Route::put('/parametres/security', [UserController::class, 'updateSecurity'])->name('user.security.update');
    // Page Aide (optionnelle)
    Route::get('/profile/aide', [ReportController::class, 'help'])->name('profile.aide');
    Route::get('/profile/notifications', [NotificationController::class, 'edit'])->name('notifications.edit');
    Route::post('/profile/notifications', [NotificationController::class, 'update'])->name('notifications.update');
    // Routes pour les notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.readAll');
    // Gestion des disponibilités des logements
    Route::resource('logements.disponibilites', LogementDisponibiliteController::class);
    //Admin
    Route::get('/chat/admin', [ChatController::class, 'liste'])->name('admin.chats.index');
    Route::get('/chat/{conversation}/admin', [ChatController::class, 'showAdmin'])->name('admin.chats.show');
    Route::get('/chat', [ChatController::class, 'index'])->name('chats.index');
    // Afficher une conversation
    Route::get('/chat/{conversation}', [ChatController::class, 'show'])->name('chats.show');
    // Démarrer une conversation (premier message)
    Route::post('/chat/start', [ChatController::class, 'start'])->name('chats.start');
    // Envoyer un message dans une conversation existante
    Route::post('/chat/{conversation}/send', [ChatController::class, 'send'])->name('chats.send');
    // Routes pour la gestion des messages de chat
    Route::put('/chats/messages/{message}', [ChatController::class, 'update'])->name('chats.update');
    Route::delete('/chats/messages/{message}', [ChatController::class, 'destroy'])->name('chats.delete');
    //Mes séjours
    Route::get('/mes-sejours', [ReservationController::class, 'sejours'])->name('reservations.history');
    Route::get('reservations', [ReservationController::class, 'index'])->name('reservations.index');
    //Commentaires ou avis
    Route::resource('commentaires', CommentaireController::class);
    Route::get('/mes/commentaires',[CommentaireController::class,'avis'])->name('comentaires.visiteurs');
    //Quartier
    Route::resource('quartiers', QuartierController::class);
    //Points forts
    Route::resource('points', PointController::class);
    //Dejeuners
    Route::resource('dejeuners', DejeunerController::class);
    //Routes Dejeuners to Logements
    Route::get('logements/{logement}/dejeuners', [LogementDejeunerController::class, 'edit'])->name('logements.dejeuners.edit');
    Route::put('logements/{logement}/petit-dejeuner', [LogementDejeunerController::class, 'update'])->name('logements.dejeuners.update');
    // Routes pour les revenus et retraits
    Route::resource('/revenus',RevenueController::class);
    // Routes pour les préférences utilisateur
    Route::prefix('preferences')->name('preferences.')->group(function () {
        Route::get('/questionnaire', [UserPreferenceController::class, 'showQuestionnaire'])->name('questionnaire');
        Route::post('/', [UserPreferenceController::class, 'storePreferences'])->name('store');
        Route::get('/edit', [UserPreferenceController::class, 'edit'])->name('edit');
        Route::put('/', [UserPreferenceController::class, 'update'])->name('update');
    });
    // Routes pour les retraits
    Route::resource('retraits',RetraitController::class);
    Route::get('/admin/retraits', [HomeController::class, 'retrait'])->name('admin.retraits.index');
    Route::post('/retraits/{retrait}/statut', [HomeController::class, 'updateStatut'])->name('admin.retraits.updateStatut');


    Route::get('/paypal/callback', [ReservationController::class, 'paypalCallback'])->name('paypal.callback');
    Route::get('/paypal/cancel/{logement}', function ($logement) { return redirect()
            ->route('hoost.logements.show', $logement)
            ->with('error', 'Paiement PayPal annulé.');
    })->name('paypal.cancel');


});
});
