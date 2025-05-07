<?php

use CodeIgniter\Router\RouteCollection;


/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Anonyme::index');
$routes->get('/anonyme', 'Anonyme::index');
$routes->post('/anonyme/seConnecter', 'Anonyme::seConnecter');
$routes->get('/visiteur', 'Visiteur::index');
$routes->get('/visiteur/mesFiches', 'Visiteur::mesFiches');
$routes->get('/visiteur/voirMaFiche/(:num)', 'Visiteur::voirMaFiche/$1'); 
$routes->get('/visiteur/modMaFiche/(:num)', 'Visiteur::modMaFiche/$1'); 
$routes->get('/visiteur/signeMaFiche/(:num)', 'Visiteur::signeMaFiche/$1'); 
$routes->get('/visiteur/seDeconnecter', 'Visiteur::SeDeconnecter');
$routes->post('/visiteur/updateForfait/(:num)', 'Visiteur::updateForfait/$1');
$routes->post('/visiteur/ajouteUneLigneDeFrais/(:num)', 'Visiteur::ajouteUneLigneDeFrais/$1');
$routes->get('/visiteur/deleteUneLigneDeFrais/(:num)/(:num)', 'Visiteur::deleteUneLigneDeFrais/$1/$2');
$routes->get('/anonyme/login', 'Anonyme::login');




$routes->get('/comptable', 'Comptable::index');
$routes->get('/comptable/voirFichesFrais', 'Comptable::voirFichesFrais');
$routes->get('/comptable/seDeconnecter', 'Comptable::SeDeconnecter');

// 1. Modifier la route pour accepter 2 paramètres
$routes->get('/comptable/validerFiche/(:num)/(:alphanum)', 'Comptable::validerFiche/$1/$2');
$routes->get('/comptable/refuserFiche/(:num)/(:alphanum)/(:alphanum)', 'Comptable::refuserFiche/$1/$2/$3');


