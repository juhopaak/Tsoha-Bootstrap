<?php

class TarjousController extends BaseController {
	
	public static function muokkaaTarjousta($tunnus) {
		$tarjous = Tarjous::find($tunnus);
		View::make('tarjous/muokkaa_tarjousta.html', array('tarjous' => $tarjous));
	}
}