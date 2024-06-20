<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'UtilisateurController';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
// routes for vehicule.
$route['manage-vehicule']="VehiculeController/ManageVehicule";
$route['change-status-vehicule/(:any)']="VehiculeController/changeStatusVehicule/$1";
$route['edit-vehicule/(:any)']="VehiculeController/editVehicule/$1";
$route['edit-vehicule-post']="VehiculeController/editVehiculePost";
$route['delete-vehicule/(:any)']="VehiculeController/deleteVehicule/$1";
$route['add-vehicule']="VehiculeController/addVehicule";
$route['add-vehicule-post']="VehiculeController/addVehiculePost";
$route['view-vehicule/(:any)']="VehiculeController/viewVehicule/$1";
// end of vehicule routes

// routes for location.
$route['manage-location']="LocationController/ManageLocation";
$route['change-status-location/(:num)']="LocationController/changeStatusLocation/$1";
$route['edit-location/(:num)']="LocationController/editLocation/$1";
$route['edit-location-post']="LocationController/editLocationPost";
$route['delete-location/(:num)']="LocationController/deleteLocation/$1";
$route['add-location']="LocationController/addLocation";
$route['add-location-post']="LocationController/addLocationPost";
$route['view-location/(:num)']="LocationController/viewLocation/$1";
// end of location routes

// routes for chauffeur.
$route['manage-chauffeur']="ChauffeurController/ManageChauffeur";
$route['manage-chauffeur/(:num)']="ChauffeurController/ManageChauffeur/$1";
$route['change-status-chauffeur/(:num)']="ChauffeurController/changeStatusChauffeur/$1";
$route['edit-chauffeur/(:num)']="ChauffeurController/editChauffeur/$1";
$route['edit-chauffeur-post']="ChauffeurController/editChauffeurPost";
$route['delete-chauffeur/(:num)']="ChauffeurController/deleteChauffeur/$1";
$route['add-chauffeur']="ChauffeurController/addChauffeur";
$route['add-chauffeur-post']="ChauffeurController/addChauffeurPost";
$route['view-chauffeur/(:num)']="ChauffeurController/viewChauffeur/$1";
// end of chauffeur routes

//routes for vehiculepiece
$route['entretien-piece']="VehiculePieceController/entretienpiece";


// routes for visite.
$route['manage-visite']="VisiteController/ManageVisite";
$route['manage-visite/(:num)']="VisiteController/ManageVisite/$1";
$route['change-status-visite/(:num)']="VisiteController/changeStatusVisite/$1";
$route['edit-visite/(:num)']="VisiteController/editVisite/$1";
$route['edit-visite-post']="VisiteController/editVisitePost";
$route['delete-visite/(:num)']="VisiteController/deleteVisite/$1";
$route['add-visite']="VisiteController/addVisite";
$route['add-visite-post']="VisiteController/addVisitePost";
$route['view-visite/(:num)']="VisiteController/viewVisite/$1";
// end of visite routes

// routes for entretien.
$route['manage-entretien']="EntretienController/ManageEntretien";
$route['manage-entretien/(:num)']="EntretienController/ManageEntretien/$1";
$route['change-status-entretien/(:num)']="EntretienController/changeStatusEntretien/$1";
$route['edit-entretien/(:num)']="EntretienController/editEntretien/$1";
$route['edit-entretien-post']="EntretienController/editEntretienPost";
$route['delete-entretien/(:num)']="EntretienController/deleteEntretien/$1";
$route['add-entretien']="EntretienController/addEntretien";
$route['add-entretien-post']="EntretienController/addEntretienPost";
$route['view-entretien/(:num)']="EntretienController/viewEntretien/$1";
// end of entretien routes

// routes for utilisateur
$route['login']="UtilisateurController/Login";
$route['form-login']="UtilisateurController/formLogin";
$route['logout']="UtilisateurController/logout";
$route['manage-utilisateur']="UtilisateurController/ManageUtilisateur";
$route['change-status-utilisateur/(:num)']="UtilisateurController/changeStatusUtilisateur/$1";
$route['edit-utilisateur/(:num)']="UtilisateurController/editUtilisateur/$1";
$route['edit-utilisateur-post']="UtilisateurController/editUtilisateurPost";
$route['delete-utilisateur/(:num)']="UtilisateurController/deleteUtilisateur/$1";
$route['add-utilisateur']="UtilisateurController/addUtilisateur";
$route['add-utilisateur-post']="UtilisateurController/addUtilisateurPost";
$route['view-utilisateur/(:num)']="UtilisateurController/viewUtilisateur/$1";

// routes for prestataire.
$route['manage-prestataire']="PrestataireController/ManagePrestataire";
$route['change-status-prestataire/(:num)']="PrestataireController/changeStatusPrestataire/$1";
$route['edit-prestataire/(:num)']="PrestataireController/editPrestataire/$1";
$route['edit-prestataire-post']="PrestataireController/editPrestatairePost";
$route['delete-prestataire/(:num)']="PrestataireController/deletePrestataire/$1";
$route['add-prestataire']="PrestataireController/addPrestataire";
$route['add-prestataire-post']="PrestataireController/addPrestatairePost";
$route['view-prestataire/(:num)']="PrestataireController/viewPrestataire/$1";
$route['add-vehicule-prestataire/(:num)']="PrestataireController/ajoutVehicule/$1";
$route['add-vehicule-prestataire-post']="PrestataireController/addVehiculePrestatairePost";
// end of prestataire routes

// routes for profilentretien.
$route['manage-profilentretien']="ProfilentretienController/ManageProfilentretien";
$route['change-status-profilentretien/(:num)']="ProfilentretienController/changeStatusProfilentretien/$1";
$route['edit-profilentretien/(:num)']="ProfilentretienController/editProfilentretien/$1";
$route['edit-profilentretien-post']="ProfilentretienController/editProfilentretienPost";
$route['delete-profilentretien/(:num)']="ProfilentretienController/deleteProfilentretien/$1";
$route['add-profilentretien']="ProfilentretienController/addProfilentretien";
$route['add-profilentretien-post']="ProfilentretienController/addProfilentretienPost";
$route['view-profilentretien/(:num)']="ProfilentretienController/viewProfilentretien/$1";
$route['add-entretienpiece/(:num)']="ProfilentretienController/addentretienpiece/$1";
$route['add-entretienpiece-post']="ProfilentretienController/addentretienpiecepost";
// end of profilentretien routes

//etat pieces voiture
$route['manage-etatpiecevoiture']="EtatpiecevoitureController/ManageEtatpiecevoiture";
$route['etat-piece/(:any)']="EtatpiecevoitureController/EtatPieceVoiture/$1";

// end etat pieces voiture

// routes for piece.
$route['manage-piece']="PieceController/ManagePiece";
$route['manage-piece/(:num)']="PieceController/ManagePiece/$1";
$route['change-status-piece/(:num)']="PieceController/changeStatusPiece/$1";
$route['edit-piece/(:num)']="PieceController/editPiece/$1";
$route['edit-piece-post']="PieceController/editPiecePost";
$route['delete-piece/(:num)']="PieceController/deletePiece/$1";
$route['add-piece']="PieceController/addPiece";
$route['add-piece-post']="PieceController/addPiecePost";
$route['view-piece/(:num)']="PieceController/viewPiece/$1";
// end of piece routes

//modifier les pièces d'un profil entretien

$route['edit-entretienpiece']="ProfilEntretienController/editentretienpiece";
//end

//ajax liste des pieces d'un profil entretien
$route['ajax-listpiece/(:any)']="ProfilentretienController/listepieceProfil/$1";
$route['ajax-listpiece-entretien/(:any)']="ProfilEntretienController/getPieceByEntretien/$1";
//end ajax

/**
 * ajouter une entretien piece
 * 
 */
$route['piece-vehicule']="VehiculePieceController/entretienpiece";

//end

// routes for vehiculepiece.
$route['manage-vehiculepiece']="VehiculePieceController/manageVehiculepiece";
$route['change-status-vehiculepiece/(:num)']="VehiculePieceController/changeStatusVehiculepiece/$1";
$route['edit-vehiculepiece/(:num)']="VehiculePieceController/editVehiculepiece/$1";
$route['edit-vehiculepiece-post']="VehiculePieceController/editVehiculepiecePost";
$route['delete-vehiculepiece/(:num)']="VehiculePieceController/deleteVehiculepiece/$1";
$route['add-vehiculepiece']="VehiculePieceController/addVehiculepiece";
$route['add-vehiculepiece-post']="VehiculePieceController/addVehiculepiecePost";
$route['view-vehiculepiece/(:num)']="VehiculePieceController/viewVehiculepiece/$1";
$route['list-vehiculepiece/(:any)']="VehiculePieceController/listvehiculepiece/$1";
$route['list-vehiculepiece/(:any)/(:num)']="VehiculePieceController/listvehiculepiece/$1/$2";
// end of vehiculepiece routes

/**
 *  assigner une entretien à une voiture 
 */
$route['assign-entretien/(:any)']="VehiculeController/formentretienpiece/$1";
$route['assign-vehicule-entretien']="VehiculeController/ajoutentretienvoiture";

// routes for circuit.
$route['manage-circuit']="CircuitController/ManageCircuit";
$route['manage-circuit/(:num)']="CircuitController/ManageCircuit";
$route['change-status-circuit/(:num)']="CircuitController/changeStatusCircuit/$1";
$route['edit-circuit/(:num)']="CircuitController/editCircuit/$1";
$route['edit-circuit-post']="CircuitController/editCircuitPost";
$route['delete-circuit/(:num)']="CircuitController/deleteCircuit/$1";
$route['add-circuit']="CircuitController/addCircuit";
$route['add-circuit-post']="CircuitController/addCircuitPost";
$route['view-circuit/(:num)']="CircuitController/viewCircuit/$1";
$route['modify-circuit/(:num)']="CircuitController/modifycircuit/$1";
$route['find-circuit']="CircuitController/formFind";
$route['find-circuit-post']="CircuitController/findpost";
// end of circuit routes

//routes asssignement voiture
$route['assignement-voiture/(:num)']="CircuitController/assignvoiture/$1";
$route['assign-vehicule-post']="CircuitController/assignvoiturepost";
$route['rentrer-post']="CircuitController/rentrerpost";
$route['enlever-post']="CircuitController/enleverpost";

//routes assignement chauffeur
$route['assignchauffeur-post']="CircuitController/assignchauffeur";


// routes for lieu.
$route['manage-lieu']="LieuController/ManageLieu";
$route['manage-lieu/(:num)']="LieuController/ManageLieu/$1";
$route['change-status-lieu/(:num)']="LieuController/changeStatusLieu/$1";
$route['edit-lieu/(:num)']="LieuController/editLieu/$1";
$route['edit-lieu-post']="LieuController/editLieuPost";
$route['delete-lieu/(:num)']="LieuController/deleteLieu/$1";
$route['add-lieu']="LieuController/addLieu";
$route['add-lieu-post']="LieuController/addLieuPost";
$route['view-lieu/(:num)']="LieuController/viewLieu/$1";
// end of lieu routes

//planning voiture
$route['planning-voiture']="CircuitController/planningvoiture";
$route['planning-voiture/(:num)']="CircuitController/planningvoiture/$1";
$route['planning-parvoiture/(:any)']="CircuitController/planningparvoiture/$1";
$route['planning-parvoiture/(:any)/(:num)']="CircuitController/planningparvoiture/$1/$2";
$route['planning-chauffeur']="CircuitController/planningchauffeur";
$route['planning-chauffeur/(:num)']="CircuitController/planningchauffeur/$1";
$route['planning-parchauffeur/(:num)']="CircuitController/planningparchauffeur/$1";
$route['planning-parchauffeur/(:num)/(:num)']="CircuitController/planningparchauffeur/$1/$2";

//routes for calendar
$route['planning-calendar']="CalendarController/showCalendar";
$route['ajax-listcircuit/(:any)']="CalendarController/listcircuit/$1";

//routes for list-attente
$route['list-attente']="CircuitController/enAttente";

//choix trajets pour une assignement multiple
$route['choix-trajet/(:any)']="CircuitController/choixTrajet/$1";
$route['voiture-dispo-trajets/']="CircuitController/VoitureDispoMultiple";

//routes for edit trajet
$route['edit-trajet/(:num)']="CircuitController/modifyTrajet/$1";
$route['edit-trajet-post']="CircuitController/modiftrajetpost";

// routes for kilometragevoiture.
$route['manage-kilometragevoiture']="KilometrageVoitureController/manageKilometragevoiture";
$route['manage-kilometragevoiture/(:num)']="KilometrageVoitureController/manageKilometragevoiture";
$route['change-status-kilometragevoiture/(:num)']="KilometrageVoitureController/changeStatusKilometragevoiture/$1";
$route['edit-kilometragevoiture/(:num)']="KilometrageVoitureController/editKilometragevoiture/$1";
$route['edit-kilometragevoiture-post']="KilometrageVoitureController/editKilometragevoiturePost";
$route['delete-kilometragevoiture/(:num)']="KilometrageVoitureController/deleteKilometragevoiture/$1";
$route['add-kilometragevoiture']="KilometrageVoitureController/addKilometragevoiture";
$route['add-kilometragevoiture-post']="KilometrageVoitureController/addKilometragevoiturePost";
$route['view-kilometragevoiture/(:num)']="KilometrageVoitureController/viewKilometragevoiture/$1";
// end of kilometragevoiture routes


