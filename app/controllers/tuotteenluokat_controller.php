<?php

class TuotteenLuokatController extends BaseController {

	public static function lisaaTuotteelleLuokka($tunnus) {
		self::check_logged_in();
		$tuote = Tuote::find($tunnus);
		$vapaatLuokat = Tuoteluokka::haeVapaatLuokat($tunnus);
		View::make('tuotteen_luokat/uusiTuotteenLuokka.html', array('tuote' => $tuote, 'vapaatLuokat' => $vapaatLuokat));
	}

	public static function tallennaTuotteenLuokka() {
		self::check_logged_in();
		$params = $_POST;

		$attributes = array(
			'tuote' => $params['lisattava_tuote'],
			'tuoteluokka' => $params['lisattava_luokka']
		);

		$tuotteenLuokka = new TuotteenLuokat($attributes);

		$tuotteenLuokka->save();
		Redirect::to('/tuote/'.$tuotteenLuokka->tuote, array('viesti' => 'Luokka lisätty tuotteelle!'));
	}

	public static function poistaTuotteenLuokka($tuote, $tuoteluokka) {
		self::check_logged_in();
		$tuotteenLuokka = new TuotteenLuokat(array('tuote' => $tuote, 'tuoteluokka' => $tuoteluokka));
		$tuotteenLuokka->destroy();
		Redirect::to('/tuote/'.$tuote, array('viesti' => 'Luokka poistettu tuotteelta.'));
	}

	public static function poistaTuotteenLuokat($tuote) {
		self::check_logged_in();
		$tuotteenLuokat = TuotteenLuokat::haeTuotteenLuokat($tuote);
		foreach ($tuotteenLuokat as $tuotteenLuokka) {
			$tuotteenLuokka->destroy();
		}
	}

	public static function poistaLuokanTuotteet($luokka) {
		self::check_logged_in();
		$luokanTuotteet = TuotteenLuokat::haeLuokanTuotteet($luokka);
		foreach ($luokanTuotteet as $luokanTuote) {
			$luokanTuote->destroy();
		}
	}
}