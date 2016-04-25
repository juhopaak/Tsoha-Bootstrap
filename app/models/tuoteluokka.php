<?php

class Tuoteluokka extends BaseModel {
	
	public $tunnus, $nimi, $kuvaus;

	public function __construct($attribuutit) {
		parent::__construct($attribuutit);
	}

	public static function all() {
		$query = DB::connection()->prepare('SELECT * FROM Tuoteluokka');
		$query->execute();
		$rows = $query->fetchAll();

		$luokat = array();
	
		foreach($rows as $row) {
			$luokat[] = new Tuoteluokka(array(
				'tunnus' => $row['tunnus'],
				'nimi' => $row['nimi'],
				'kuvaus' => $row['kuvaus']
			));
		}

		return $luokat;
	}

	public static function find($tunnus) {
		$query = DB::connection()->prepare('SELECT * FROM Tuoteluokka WHERE tunnus = :tunnus LIMIT 1');
		$query->execute(array('tunnus' => $tunnus));
		$row = $query->fetch();

		if ($row) {
			$luokka = new Tuoteluokka(array(
				'tunnus' => $row['tunnus'],
				'nimi' => $row['nimi'],
				'kuvaus' => $row['kuvaus']
			));

			return $luokka;
		}

		return null;
	}

	public function save() {
		$query = DB::connection()->prepare('INSERT INTO Tuoteluokka (nimi, kuvaus) VALUES (:nimi, :kuvaus) RETURNING tunnus');

		$query->execute(array('nimi' => $this->nimi,
							  'kuvaus' => $this->kuvaus));
		$row = $query->fetch();

		//Kint::trace();
  		//Kint::dump($row);

		$this->tunnus = $row['tunnus'];
	}

	public function update() {
		$query = DB::connection()->prepare('UPDATE Tuoteluokka SET nimi = :nimi, kuvaus = :kuvaus WHERE tunnus = :tunnus RETURNING tunnus');

		$query->execute(array('tunnus' => $this->tunnus,
							  'nimi' => $this->nimi,
							  'kuvaus' => $this->kuvaus));
		$row = $query->fetch();

		//Kint::trace();
  		//Kint::dump($row);

		$this->tunnus = $row['tunnus'];
	}

	public function destroy() {
		$query = DB::connection()->prepare('DELETE FROM Tuoteluokka WHERE tunnus = :tunnus');

		$query->execute(array('tunnus' => $this->tunnus));

		$row = $query->fetch();

		//Kint::trace();
		//Kint::dump($row);
	}

	public function luokanTuotteet($tunnus) {
		$query = DB::connection()->prepare('SELECT * FROM Tuote, Tuoteluokka, TuotteenLuokat WHERE Tuote.tunnus = TuotteenLuokat.tuote AND TuotteenLuokat.tuoteluokka = Tuoteluokka.tunnus AND Tuoteluokka.tunnus = :tunnus');
		$query->execute(array('tunnus' => $tunnus));
		$rows = $query->fetchAll();

		$tuotteet = array();

		foreach($rows as $row) {
			$tuotteet[] = new Tuote(array(
				'tunnus' => $row['tunnus'],
				'nimi' => $row['nimi'],
				'ika' => $row['ika'],
				'sijainti' => $row['sijainti'],
				'lahtohinta' => $row['lahtohinta'],
				'sulkeutuminen' => $row['sulkeutuminen'],
				'tila' => $row['tila'],
				'kuvaus' => $row['kuvaus'],
				'tuotekuva' => $row['tuotekuva'],
				'meklari' => $row['meklari']
			));
		}

		return $tuotteet;
	}

}