<?php

class Tuote extends BaseModel {

	public $tunnus, $nimi, $ika, $sijainti, $lahtohinta, $sulkeutuminen, $tila, $kuvaus, $tuotekuva, $meklari, $validators;

	public function __construct($attribuutit) {
		parent::__construct($attribuutit);
		$this->validators = array('validoi_nimi', 'validoi_ika', 'validoi_sijainti', 'validoi_kuvaus', 'validoi_hinta', 'validoi_sulkeutuminen', 'validoi_meklari');
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
				'lahtohinta' => $row['lahtohinta'],
				'sulkeutuminen' => $row['sulkeutuminen'],
				'tila' => $row['tila'],
				'kuvaus' => $row['kuvaus'],
				'tuotekuva' => $row['tuotekuva'],
				'meklari' => $row['meklari']
			));

			return $tuote;
		}

		return null;
	}

	public function save() {
		$query = DB::connection()->prepare('INSERT INTO Tuote (nimi, ika, sijainti, lahtohinta, sulkeutuminen, tila, kuvaus, tuotekuva, meklari) VALUES (:nimi, :ika, :sijainti, :lahtohinta, :sulkeutuminen, :tila, :kuvaus, :tuotekuva, :meklari) RETURNING tunnus');

		$query->execute(array('nimi' => $this->nimi,
							  'ika' => $this->ika,
							  'sijainti' => $this->sijainti,
							  'lahtohinta' => $this->lahtohinta,
							  'sulkeutuminen' => $this->sulkeutuminen,
							  'tila' => $this->tila,
							  'kuvaus' => $this->kuvaus,
							  'tuotekuva' => $this->tuotekuva,
							  'meklari' => $this->meklari));
		$row = $query->fetch();

		//Kint::trace();
  		//Kint::dump($row);

		$this->tunnus = $row['tunnus'];
	}

	public function update() {
		$query = DB::connection()->prepare('UPDATE Tuote SET nimi = :nimi, ika = :ika, sijainti = :sijainti, lahtohinta = :lahtohinta, sulkeutuminen = :sulkeutuminen, tila = :tila, kuvaus = :kuvaus, tuotekuva = :tuotekuva, meklari = :meklari WHERE tunnus = :tunnus RETURNING tunnus');

		$query->execute(array('tunnus' => $this->tunnus,
							  'nimi' => $this->nimi,
							  'ika' => $this->ika,
							  'sijainti' => $this->sijainti,
							  'lahtohinta' => $this->lahtohinta,
							  'sulkeutuminen' => $this->sulkeutuminen,
							  'tila' => $this->tila,
							  'kuvaus' => $this->kuvaus,
							  'tuotekuva' => $this->tuotekuva,
							  'meklari' => $this->meklari));
		$row = $query->fetch();

		//Kint::trace();
  		//Kint::dump($row);

		$this->tunnus = $row['tunnus'];
	}

	public function destroy() {
		$query = DB::connection()->prepare('DELETE FROM Tuote WHERE tunnus = :tunnus');

		$query->execute(array('tunnus' => $this->tunnus));

		$row = $query->fetch();

		//Kint::trace();
		//Kint::dump($row);
	}

	public function tuotteenLuokat($tunnus) {
		$query = DB::connection()->prepare('SELECT Tuoteluokka.tunnus, Tuoteluokka.nimike FROM Tuoteluokka, Tuote, TuotteenLuokat WHERE Tuoteluokka.tunnus = TuotteenLuokat.tuoteluokka AND TuotteenLuokat.tuote = Tuote.tunnus AND Tuote.tunnus = :tunnus');
		$query->execute(array('tunnus' => $tunnus));
		$rows = $query->fetchAll();

		$luokat = array();

		foreach($rows as $row) {
			$luokat[] = new Tuoteluokka(array(
				'tunnus' => $row['tunnus'],
				'nimike' => $row['nimike']
			));
		}

		return $luokat;
	}

	public function validoi_nimi() {
		$errors = array();
		
		if (!$this->tarkista_merkkijono($this->nimi)) {
			$errors[] = 'Tuotenimike on pakollinen tieto.';
		}
		return $errors;
	}

	public function validoi_ika() {
		$errors = array();

		if ($this->ika == null) {
			$errors[] = 'Tuotteen ikä on pakollinen tieto.';
		}
		if ($this->ika < 0) {
			$errors[] = 'Tuotteen ikä ei voi olla pienempi kuin 0.';
		}

		return $errors;
	}

	public function validoi_sijainti() {
		$errors = array();

		if (!$this->tarkista_merkkijono($this->sijainti)) {
			$errors[] = 'Tuotteella on oltava sijainti.';
		}
		if (!$this->tarkista_merkkijono_pituus($this->sijainti, 2)) {
			$errors[] = 'Tuotteen sijainti on liian lyhyt.';
		}
		return $errors;
	}

	public function validoi_kuvaus() {
		$errors = array();

		if (!$this->tarkista_merkkijono($this->kuvaus)) {
			$errors[] = 'Tuotteella on oltava kuvaus';
		}
		if (strlen($this->kuvaus) > 250) {
			$errors[] = 'Tuotteen kuvaus ei voi olla yli 250 merkkiä pitkä.';
		}
		return $errors;
	}

	public function validoi_hinta() {
		$errors = array();

		if ($this->lahtohinta == null) {
			$errors[] = 'Tuotteella on oltava lähtöhinta.';
		}
		if ($this->lahtohinta < 0) {
			$errors[] = 'Tuotteen lähtöhinnan on oltava vähintään 0.';
		}

		return $errors;
	}

	public function validoi_sulkeutuminen() {
		$errors = array();

		if ($this->sulkeutuminen == null) {
			$errors[] = 'Tuotteella on oltava sulkeutumispäivä.';
		}

		return $errors;
	}

	public function validoi_meklari() {
		$errors = array();

		if ($this->meklari != 1) {
			$errors[] = 'Tässä vaiheessa tuotteen meklariksi on asetettava arvo 1. Myöhemmin meklarin voi valita listalta.';
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
		if (strlen($jono) < $pituus) {
			return false;
		}
		return true;
	}

}