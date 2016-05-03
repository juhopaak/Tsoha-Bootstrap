<?php

class Tuoteluokka extends BaseModel {
	
	public $tunnus, $nimike, $kuvaus, $validators;

	public function __construct($attribuutit) {
		parent::__construct($attribuutit);
		$this->validators = array('validoi_nimike', 'validoi_kuvaus');
	}

	public static function all() {
		$query = DB::connection()->prepare('SELECT * FROM Tuoteluokka');
		$query->execute();
		$rows = $query->fetchAll();

		$luokat = array();
	
		foreach($rows as $row) {
			$luokat[] = new Tuoteluokka(array(
				'tunnus' => $row['tunnus'],
				'nimike' => $row['nimike'],
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
				'nimike' => $row['nimike'],
				'kuvaus' => $row['kuvaus']
			));

			return $luokka;
		}

		return null;
	}

	public function save() {
		$query = DB::connection()->prepare('INSERT INTO Tuoteluokka (nimike, kuvaus) VALUES (:nimike, :kuvaus) RETURNING tunnus');

		$query->execute(array('nimike' => $this->nimike,
							  'kuvaus' => $this->kuvaus));
		$row = $query->fetch();

		//Kint::trace();
  		//Kint::dump($row);

		$this->tunnus = $row['tunnus'];
	}

	public function update() {
		$query = DB::connection()->prepare('UPDATE Tuoteluokka SET nimike = :nimike, kuvaus = :kuvaus WHERE tunnus = :tunnus RETURNING tunnus');

		$query->execute(array('tunnus' => $this->tunnus,
							  'nimike' => $this->nimike,
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
		$query = DB::connection()->prepare('SELECT Tuote.tunnus, Tuote.nimi, Tuote.ika, Tuote.sijainti, Tuote.lahtohinta, Tuote.sulkeutuminen, Tuote.tila, Tuote.kuvaus, Tuote.tuotekuva, Tuote.meklari FROM Tuote, Tuoteluokka, TuotteenLuokat WHERE Tuote.tunnus = TuotteenLuokat.tuote AND TuotteenLuokat.tuoteluokka = Tuoteluokka.tunnus AND Tuoteluokka.tunnus = :tunnus');
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

	public function haeVapaatLuokat($tuote) {
		$query = DB::connection()->prepare('SELECT * FROM Tuoteluokka WHERE Tuoteluokka.tunnus NOT IN (SELECT tuoteluokka FROM TuotteenLuokat WHERE tuote = :tuote)');
		$query->execute(array('tuote' => $tuote));
		$rows = $query->fetchAll();

		$luokat = array();

		foreach($rows as $row) {
			$luokat[] = new Tuoteluokka(array(
				'tunnus' => $row['tunnus'],
				'nimike' => $row['nimike'],
				'kuvaus' => $row['kuvaus']
			));
		}

		return $luokat;

	}

	public function validoi_nimike() {
		$errors = array();
		
		if (!$this->tarkista_merkkijono($this->nimike)) {
			$errors[] = 'Luokan nimike on pakollinen tieto.';
		}
		if (!$this->tarkista_merkkijono_pituus($this->nimike, 120)) {
			$errors[] = 'Luokan nimike ei saa olla yli 120 merkkiä pitkä.';
		}
		return $errors;
	}

	public function validoi_kuvaus() {
		$errors = array();
		
		if (!$this->tarkista_merkkijono($this->kuvaus)) {
			$errors[] = 'Luokan kuvaus on pakollinen tieto.';
		}
		if (!$this->tarkista_merkkijono_pituus($this->kuvaus, 350)){
			$errors[] = 'Kuvaus ei saa olla yli 350 merkkiä pitkä.';
		}
		return $errors;
	}

	private function tarkista_merkkijono($jono) {
		if ($jono == '' || $jono = null) {
			return false;
		}
		return true;
	}

	private function tarkista_merkkijono_pituus($jono, $pituus) {
		if (strlen($jono) > $pituus) {
			return false;
		}
		return true;
	}

}