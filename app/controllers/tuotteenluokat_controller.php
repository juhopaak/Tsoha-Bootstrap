<?php

class TuotteenLuokatController extends BaseController {

	public static function poistaTuotteenLuokka($tuote, $tuoteluokka) {
		self::check_logged_in();
		$tuotteenLuokka = new TuotteenLuokat(array('tuote' => $tuote, 'tuoteluokka' => $tuoteluokka));
		$tuotteenLuokka->destroy();
		Redirect::to('/tuote/'.$tuote, array('viesti' => 'Luokka poistettu tuotteelta.'));
	}

	public static function lisaaTuotteelleLuokka($tunnus) {
		self::check_logged_in();
		$tuote = Tuote::find($tunnus);
		$tuotteenLuokat = Tuote::tuotteenLuokat($tunnus);
		$kaikkiLuokat = Tuoteluokka::all();
		View::make('tuotteen_luokat/uusiTuotteenLuokka.html', array('tuote' => $tuote, 'tuotteenLuokat' => $tuotteenLuokat, 'kaikkiLuokat' => $kaikkiLuokat));
	}

	public static function tallennaTuotteenLuokka() {
		self::check_logged_in();
		$params = $_POST;

		$attributes = array(
			'tuote' => $params['lisattava_tuote'],
			'tuoteluokka' => $params['lisattava_luokka']
		);

		$tuotteenLuokka = new TuotteenLuokat($attributes);

		//Kint::dump($params);

		$tuotteenLuokka->save();
		Redirect::to('/tuote/'.$tuotteenLuokka->tuote, array('viesti' => 'Luokka lisätty tuotteelle!'));
	}
}