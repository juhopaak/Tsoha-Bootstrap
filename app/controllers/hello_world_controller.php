<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  //View::make('home.html');
      echo 'Tämä on etusivu!';
    }

    public static function sandbox(){
      // Testaa koodiasi täällä
      //View::make('helloworld.html');
      $tuote = Tuote::find(1);
      $kaikki = Tuote::all();

      Kint::dump($kaikki);
      Kint::dump($tuote);
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
