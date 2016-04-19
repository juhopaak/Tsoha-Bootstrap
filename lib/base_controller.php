<?php

  class BaseController{

    public static function get_user_logged_in(){
      if (isset($_SESSION['kayttaja'])) {
        $tunnus = $_SESSION['kayttaja'];

        $kayttaja = Kayttaja::find($tunnus);
        return $kayttaja;
      }
      
      return null;
    }

    public static function check_logged_in(){
      if (!isset($_SESSION['kayttaja'])) {
        Redirect::to('/kirjautuminen', array('viesti' => 'Valitsemasi toiminto vaatii kirjautumisen.'));
      }
    }

  }
