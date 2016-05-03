<?php

class TuoteController extends BaseController {

	public static function etusivu() {
		$tuotteet = Tuote::all();
		View::make('etusivu.html', array('tuotteet' => $tuotteet));
	}

	public static function tuote($tunnus) {
		$tuote = Tuote::find($tunnus);
		$luokat = Tuote::tuotteenLuokat($tunnus);
		$tarjoukset = Tarjous::tuotteenTarjoukset($tunnus);
		View::make('tuote/tuote.html', array('tuote' => $tuote, 'luokat' => $luokat, 'tarjoukset' => $tarjoukset));
	}

	public static function muokkaaTuotetta($tunnus) {
		self::check_logged_in();
		$tuote = Tuote::find($tunnus);
		$pvm = date("Y-m-d");
		View::make('tuote/muokkaa_tuotetta.html', array('tuote' => $tuote, 'paivamaara' => $pvm));
	}

	public static function paivitaTuote($tunnus) {
		self::check_logged_in();
		$params = $_POST;

		$attributes = array(
			'tunnus' => $tunnus,
			'nimi' => $params['nimi'],
			'ika' => $params['ika'],
			'sijainti' => $params['sijainti'],
			'lahtohinta' => $params['lahtohinta'],
			'sulkeutuminen' => $params['sulkeutuminen'],
			'tila' => 'true',
			'kuvaus' => $params['kuvaus'],
			'tuotekuva' => $params['tuotekuva'],
			'meklari' => $params['meklari']
		);

		$tuote = new Tuote($attributes);
		$errors = $tuote->errors();

		if (count($errors) == 0) {
			$tuote->update();
			Redirect::to('/tuote/'.$tuote->tunnus, array('viesti' => 'Tuotteen tiedot päivitetty!'));
		} else {
			Redirect::to('/tuote/'.$tuote->tunnus.'/muokkaa', array('errors' => $errors, 'attributes' => $attributes));
		}
		
	}

	public static function poistaTuote($tunnus) {
		self::check_logged_in();
		$tuote = new Tuote(array('tunnus' => $tunnus));
		TuotteenLuokatController::poistaTuotteenLuokat($tunnus);
		$tuote->destroy();
		Redirect::to('/tuote', array('viesti' => 'Tuote poistettu'));
	}

	public static function lisaaTuote() {
		self::check_logged_in();
		$pvm = date("Y-m-d");
		View::make('tuote/uusi.html', array('paivamaara' => $pvm));
	}

	public static function tallennaTuote() {
		self::check_logged_in();
		$params = $_POST;


		$attributes = array(
			'nimi' => $params['nimi'],
			'ika' => $params['ika'],
			'sijainti' => $params['sijainti'],
			'lahtohinta' => $params['lahtohinta'],
			'sulkeutuminen' => $params['sulkeutuminen'],
			'tila' => 'true',
			'kuvaus' => $params['kuvaus'],
			'tuotekuva' => $params['tuotekuva'],
			'meklari' => $params['meklari']
		);

		$tuote = new Tuote($attributes);
		$errors = $tuote->errors();

		//Kint::dump($params);

		if (count($errors) == 0) {
			$tuote->save();
			Redirect::to('/tuote/' . $tuote->tunnus, array('viesti' => 'Tuotteen lisäys onnistui!'));
		} else {
			View::make('tuote/uusi.html', array('errors' => $errors, 'attributes' => $attributes));
		}
		
	}
}