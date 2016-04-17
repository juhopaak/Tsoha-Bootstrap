<?php

class KayttajaController extends BaseController {

	public static function kirjaudu() {
		View::make('kayttaja/kirjautuminen.html');
	}

	public static function kasittele_kirjautuminen() {
		$params = $_POST;

		$kayttaja = Kayttaja::tunnistaudu($params['kayttajatunnus'], $params['salasana']);

		if (!$kayttaja) {
			View::make('kayttaja/kirjautuminen.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'kaytajatunnus' => $params['kayttajatunnus']));
		} else {
			$_SESSION['kayttaja'] = $kayttaja->tunnus;
			Redirect::to('/', array('viesti' => 'Kirjautunut käyttäjänä '.$kayttaja->kayttajatunnus));
		}
	}

}