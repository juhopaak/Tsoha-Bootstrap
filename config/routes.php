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

  $routes->get('/kirjautuminen', function() {
    HelloWorldController::kirjautuminen();
  });


