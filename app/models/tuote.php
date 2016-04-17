<?php

class Tuote extends BaseModel {

	public $tunnus, $nimi, $ika, $sijainti, $kuvaus, $tuotekuva, $kauppa_tunnus, $validators;

	public function __construct($attribuutit) {
		parent::__construct($attribuutit);
		$this->validators = array('validoi_nimi', 'validoi_ika', 'validoi_sijainti', 'validoi_kuvaus');
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

		//Kint::trace();
  		//Kint::dump($row);

		$this->tunnus = $row['tunnus'];
	}

	public function update() {
		$query = DB::connection()->prepare('UPDATE Tuote SET nimi = :nimi, ika = :ika, sijainti = :sijainti, kuvaus = :kuvaus, tuotekuva = :tuotekuva WHERE tunnus = :tunnus RETURNING tunnus');

		$query->execute(array('tunnus' => $this->tunnus,
							  'nimi' => $this->nimi,
							  'ika' => $this->ika,
							  'sijainti' => $this->sijainti,
							  'kuvaus' => $this->kuvaus,
							  'tuotekuva' => $this->tuotekuva));
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
			$errors[] = 'Tuotteen ikä ei voi olla pienempi kuin 0';
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
			$errors[] = 'Tuotteen kuvaus ei voi olla yli 250 merkkiä pitkä';
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