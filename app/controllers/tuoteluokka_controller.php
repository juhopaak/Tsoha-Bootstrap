<?php

class TuoteluokkaController extends BaseController {
	
	public static function lista() {
		$luokat = Tuoteluokka::all();
		View::make('tuoteluokka/lista.html', array('luokat' => $luokat));
	}

	public static function luokka($tunnus) {
		$luokka = Tuoteluokka::find($tunnus);
		View::make('tuoteluokka/tuoteluokka.html', array('luokka' => $luokka));
	}

}