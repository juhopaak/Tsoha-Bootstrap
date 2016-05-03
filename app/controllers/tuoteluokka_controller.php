<?php

class TuoteluokkaController extends BaseController {
	
	public static function lista() {
		$luokat = Tuoteluokka::all();
		View::make('tuoteluokka/lista.html', array('luokat' => $luokat));
	}

	public static function luokka($tunnus) {
		$luokka = Tuoteluokka::find($tunnus);
		$tuotteet = Tuoteluokka::luokanTuotteet($tunnus);
		View::make('tuoteluokka/tuoteluokka.html', array('luokka' => $luokka, 'tuotteet' => $tuotteet));
	}

	public static function muokkaaLuokkaa($tunnus) {
		self::check_logged_in();
		$luokka = Tuoteluokka::find($tunnus);
		View::make('tuoteluokka/muokkaa_luokkaa.html', array('luokka' => $luokka));
	}

	public static function paivitaLuokka($tunnus) {
		self::check_logged_in();
		$params = $_POST;

		$attributes = array(
			'tunnus' => $tunnus,
			'nimike' => $params['nimike'],
			'kuvaus' => $params['kuvaus']
		);

		$luokka = new Tuoteluokka($attributes);
		$errors = $luokka->errors();

		if (count($errors) == 0) {
			$luokka->update();
			Redirect::To('/tuoteluokka/'.$luokka->tunnus, array('viesti' => 'Luokan tiedot päivitetty!'));
		} else {
			Redirect::to('/tuoteluokka/'.$luokka->tunnus.'/muokkaa', array('errors' => $errors, 'attributes' => $attributes));
		}
	}

	public static function poistaLuokka($tunnus) {
		self::check_logged_in();
		$luokka = new Tuoteluokka(array('tunnus' => $tunnus));
		TuotteenLuokatController::poistaLuokanTuotteet($tunnus);
		$luokka->destroy();
		Redirect::to('/tuoteluokka', array('viesti' => 'Tuoteluokka poistettu'));
	}

	public static function lisaaLuokka() {
		self::check_logged_in();
		View::make('tuoteluokka/uusiLuokka.html');
	}

	public static function tallennaLuokka() {
		self::check_logged_in();
		$params = $_POST;

		$attributes = array(
			'nimike' => $params['nimike'],
			'kuvaus' => $params['kuvaus']
		);

		$luokka = new Tuoteluokka($attributes);
		$errors = $luokka->errors();

		//Kint::dump($params);

		if (count($errors) == 0) {
			$luokka->save();
			Redirect::to('/tuoteluokka/'.$luokka->tunnus, array('viesti' => 'Tuoteluokka lisätty!'));
		} else {
			View::make('tuoteluokka/uusiLuokka.html', array('errors' => $errors, 'attributes' => $attributes));
		}
	}
}