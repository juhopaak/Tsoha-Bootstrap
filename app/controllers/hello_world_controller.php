<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  //View::make('home.html');
      echo 'Tämä on etusivu!';
    }

    public static function sandbox(){
      
      $tuote = new Tuote(array(
        'nimi' => 'a',
        'ika' => 5,
        'sijainti' => 'Helsinki'
      ));

      $errors = $tuote->errors();
      Kint::dump($errors);
    }

    public static function huutokauppa(){
      View::make('etusivu.html');
    }

    public static function tuote(){
      View::make('tuote.html');
    }

    public static function muokkaa(){
      View::make('muokkaa_tuotetta.html');
    }

    public static function kirjautuminen(){
      View::make('kirjautuminen.html');
    }

  }
