<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  //View::make('home.html');
      echo 'Tämä on etusivu!';
    }

    public static function sandbox(){
      // Testaa koodiasi täällä
      View::make('helloworld.html');
    }

    public static function huutokauppa(){
      View::make('suunnitelmat/etusivu.html');
    }

    public static function tuote(){
      View::make('suunnitelmat/tuote.html');
    }

    public static function muokkaa(){
      View::make('suunnitelmat/muokkaa_tuotetta.html');
    }

    public static function kirjautuminen(){
      View::make('suunnitelmat/kirjautuminen.html');
    }

  }
