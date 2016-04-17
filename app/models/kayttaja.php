<?php

class Kayttaja extends BaseModel {

	public $tunnus, $kayttajatunnus, $salasana;

	public function __construct($attribuutit) {
		parent::__construct($attribuutit);
	}

	public static function tunnistaudu($kayttajatunnus, $salasana) {
		$query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE kayttajatunnus = :kayttajatunnus AND salasana = :salasana LIMIT 1');
		$query->execute(array('kayttajatunnus' => $kayttajatunnus, 'salasana' => $salasana));
		$row = $query->fetch();
		
		if ($row) {
			$kayttaja = new Kayttaja(array(
				'tunnus' => $row['tunnus'],
				'kayttajatunnus' => $row['kayttajatunnus'],
				'salasana' => $row['salasana']
			));
			return $kayttaja;
		} else {
			return null;
		}
	}

	public static function find($tunnus) {
		$query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE tunnus = :tunnus LIMIT 1');
		$query->execute(array('tunnus' => $tunnus));
		$row = $query->fetch();

		if ($row) {
			$kayttaja = new Kayttaja(array(
				'tunnus' => $row['tunnus'],
				'kayttajatunnus' => $row['kayttajatunnus'],
				'salasana' => $row['salasana'],
			));
			return $kayttaja;
		}
		return null;
	}

}