<?php

class Kayttaja extends BaseModel {

	public $tunnus, $kayttajatunnus, $salasana, $yhteystiedot, $tyyppi;

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
				'salasana' => $row['salasana'],
				'yhteystiedot' => $row['yhteystiedot'],
				'tyyppi' => $row['tyyppi']
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
				'yhteystiedot' => $row['yhteystiedot'],
				'tyyppi' => $row['tyyppi']
			));
			return $kayttaja;
		}
		return null;
	}

	public static function haeMeklarit() {
		$query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE tyyppi = 2');
		$query->execute();
		$rows = $query->fetchAll();

		$meklarit = array();

		foreach($rows as $row) {
			$meklarit[] = new Kayttaja(array(
				'tunnus' => $row['tunnus'],
				'kayttajatunnus' => $row['kayttajatunnus'],
				'salasana' => $row['salasana'],
				'yhteystiedot' => $row['yhteystiedot'],
				'tyyppi' => $row['tyyppi']
			));
		}
		return $meklarit;
	}

}