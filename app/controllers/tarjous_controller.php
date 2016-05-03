<?php

class TarjousController extends BaseController {

	public static function tarjous($tunnus) {
		self::check_logged_in();
		$tarjous = Tarjous::find($tunnus);
		$tuote = Tuote::find($tarjous->tuote);
		View::make('tarjous/tiedot.html', array('tuote' => $tuote, 'tarjous' => $tarjous));
	}

	public static function lisaaTarjous($tuote) {
		$tuote = Tuote::find($tuote);
		$aika = time();
		$aika = date('Y-m-d h:i:s');
		View::make('tarjous/uusi.html', array('tuote' => $tuote, 'aika' => $aika));
	}

	public static function tallennaTarjous($tuote) {
		$params = $_POST;

		$attributes = array(
			'aika' => $params['aika'],
			'maara' => $params['maara'],
			'yhteystiedot' => $params['yhteystiedot'],
			'kokonimi' => $params['kokonimi'],
			'osoite' => $params['osoite'],
			'postinro' => $params['postinro'],
			'kaupunki' => $params['kaupunki'],
			'sotu' => $params['sotu'],
			'tuote' => $params['tuote']
		);

		$tarjous = new Tarjous($attributes);
		$errors = $tarjous->errors();

		if (count($errors) == 0) {
			$tarjous->save();
			Redirect::to('/tuote/'.$tarjous->tuote, array('viesti' => 'Tarjouksen tekeminen onnistui!'));
		} else {
			Redirect::to('/tuote/'.$tarjous->tuote.'/lisaa_tarjous', array('errors' => $errors, 'attributes' => $attributes));
		}		
		
	}
}