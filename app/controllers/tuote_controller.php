<?php

class TuoteController extends BaseController {

	public static function etusivu() {
		$tuotteet = Tuote::all();
		View::make('etusivu.html', array('tuotteet' => $tuotteet));
	}

	public static function tuote($tunnus) {
		$tuote = Tuote::find($tunnus);
		View::make('tuote/tuote.html', array('tuote' => $tuote));
	}

	public static function muokkaaTuotetta($tunnus) {
		$tuote = Tuote::find($tunnus);
		View::make('tuote/muokkaa_tuotetta.html', array('tuote' => $tuote));
	}

	public static function paivitaTuote($tunnus) {
		$params = $_POST;

		$attributes = array(
			'tunnus' => $tunnus,
			'nimi' => $params['nimi'],
			'ika' => $params['ika'],
			'sijainti' => $params['sijainti'],
			'kuvaus' => $params['kuvaus'],
			'tuotekuva' => $params['tuotekuva']
		);

		$tuote = new Tuote($attributes);
		$tuote->update();

		Redirect::to('/tuote/'.$tuote->tunnus, array('viesti' => 'Tuotteen tiedot päivitetty!'))
	}

	public static function poistaTuote($tunnus) {
		$tuote = new Tuote(array('tunnus' => $tunnus));
		$tuote->destroy();
		Redirect::to('/tuote', array('viesti' => 'Tuote poistettu'))
	}

	public static function lisaaTuote() {
		View::make('tuote/uusi.html');
	}

	public static function tallennaTuote() {
		$params = $_POST;

		$tuote = new Tuote(array(
			'nimi' => $params['nimi'],
			'ika' => $params['ika'],
			'sijainti' => $params['sijainti'],
			'kuvaus' => $params['kuvaus'],
			'tuotekuva' => $params['tuotekuva']
		));

		//Kint::dump($params);

		$tuote->save();

		Redirect::to('/tuote/' . $tuote->tunnus, array('viesti' => 'Tuotteen lisäys onnistui!'));
	}
}