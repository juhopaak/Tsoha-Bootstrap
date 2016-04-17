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


