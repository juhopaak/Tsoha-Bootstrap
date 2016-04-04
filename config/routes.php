<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/huutokauppa', function() {
  	HelloWorldController::huutokauppa();
  });

  $routes->get('/huutokauppa/1', function() {
  	HelloWorldController::tuote();
  });

  $routes->get('/huutokauppa/1/muokkaa', function() {
  	HelloWorldController::muokkaa();
  });

  $routes->get('/huutokauppa/kirjautuminen', function() {
  	HelloWorldController::kirjautuminen();
  });
