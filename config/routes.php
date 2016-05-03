<?php

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/', function() {
    TuoteController::etusivu();
  });

  $routes->get('/tuote', function() {
    TuoteController::etusivu();
  });

  $routes->post('/tuote', function() {
    TuoteController::tallennaTuote();
  });

  $routes->get('/lisaa_tuote', function() {
    TuoteController::lisaaTuote();
  });

  $routes->get('/tuote/:tunnus', function($tunnus) {
  	TuoteController::tuote($tunnus);
  });

  $routes->get('/tuote/:tunnus/muokkaa', function($tunnus) {
  	TuoteController::muokkaaTuotetta($tunnus);
  });
  
  $routes->post('/tuote/:tunnus/muokkaa', function($tunnus) {
    TuoteController::paivitaTuote($tunnus);
  });

  $routes->post('/tuote/:tunnus/poista', function($tunnus) {
    TuoteController::poistaTuote($tunnus);
  });

  $routes->get('/kirjautuminen', function() {
    KayttajaController::kirjaudu();
  });

  $routes->post('/kirjautuminen', function() {
    KayttajaController::kasittele_kirjautuminen();
  });

  $routes->get('/kirjaudu_ulos', function() {
    KayttajaController::kirjaudu_ulos();
  });

  $routes->get('/tuoteluokka', function() {
    TuoteluokkaController::lista();
  });

  $routes->post('/tuoteluokka', function() {
    TuoteluokkaController::tallennaLuokka();
  });

  $routes->get('/tuoteluokka/lisaa_luokka', function() {
    TuoteluokkaController::lisaaLuokka();
  });

  $routes->get('/tuoteluokka/:tunnus', function($tunnus) {
    TuoteluokkaController::luokka($tunnus);
  });

  $routes->get('/tuoteluokka/:tunnus/muokkaa', function($tunnus) {
    TuoteluokkaController::muokkaaLuokkaa($tunnus);
  });

  $routes->post('/tuoteluokka/:tunnus/muokkaa', function($tunnus) {
    TuoteluokkaController::paivitaLuokka($tunnus);
  });

  $routes->post('/tuoteluokka/:tunnus/poista', function($tunnus) {
    TuoteluokkaController::poistaLuokka($tunnus);
  });

  $routes->get('/tarjous/:tunnus/muokkaa', function($tunnus) {
    TarjousController::muokkaaTarjousta($tunnus);
  });

  $routes->post('/tuote/:tunnus/lisaa_tuotteelle_luokka', function($tunnus) {
    TuotteenLuokatController::tallennaTuotteenLuokka();
  });

  $routes->get('/tuote/:tunnus/lisaa_tuotteelle_luokka', function($tunnus) {
    TuotteenLuokatController::lisaaTuotteelleLuokka($tunnus);
  });

  $routes->post('/tuote/:tuote/poista/:luokka', function($tuote, $luokka) {
    TuotteenLuokatController::poistaTuotteenLuokka($tuote, $luokka);
  });


