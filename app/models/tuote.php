<?php

class Tuote extends BaseModel {

	public $tunnus, $nimi, $ika, $sijainti, $kuvaus, $tuotekuva, $kauppa_tunnus;

	public function __construct($attribuutit) {
		parent::__construct($attribuutit);
	}

	public static function all() {
		$query = DB::connection()->prepare('SELECT * FROM Tuote');
		$query->execute();
		$rows = $query->fetchAll();

		$tuotteet = array();

		foreach($rows as $row) {
			$tuotteet[] = new Tuote(array(
				'tunnus' => $row['tunnus'],
				'nimi' => $row['nimi'],
				'ika' => $row['ika'],
				'sijainti' => $row['sijainti'],
				'kuvaus' => $row['kuvaus'],
				'tuotekuva' => $row['tuotekuva'],
				'kauppa_tunnus' => $row['kauppa']
			));
		}

		return $tuotteet;
	}

	public static function find($tunnus) {
		$query = DB::connection()->prepare('SELECT * FROM Tuote WHERE tunnus = :tunnus LIMIT 1');
		$query->execute(array('tunnus' => $tunnus));
		$row = $query->fetch();


		if ($row) {
			$tuote = new Tuote(array(
				'tunnus' => $row['tunnus'],
				'nimi' => $row['nimi'],
				'ika' => $row['ika'],
				'sijainti' => $row['sijainti'],
				'kuvaus' => $row['kuvaus'],
				'tuotekuva' => $row['tuotekuva'],
				'kauppa_tunnus' => $row['kauppa']
			));

			return $tuote;
		}

		return null;
	}

	public function save() {
		$query = DB::connection()->prepare('INSERT INTO Tuote (nimi, ika, sijainti, kuvaus, tuotekuva) VALUES (:nimi, :ika, :sijainti, :kuvaus, :tuotekuva) RETURNING tunnus');

		$query->execute(array('nimi' => $this->nimi,
							  'ika' => $this->ika,
							  'sijainti' => $this->sijainti,
							  'kuvaus' => $this->kuvaus,
							  'tuotekuva' => $this->tuotekuva));

		$row = $query->fetch();
		$this->tunnus = $row['tunnus'];
	}

}