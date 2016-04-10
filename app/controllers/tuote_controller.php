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

}