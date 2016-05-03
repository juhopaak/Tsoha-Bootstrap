<?php

class Tarjous extends BaseModel {

	public $tunnus, $aika, $maara, $yhteystiedot, $kokonimi, $osoite, $postinro, $kaupunki, $sotu, $tuote, $validators;

	public function __construct($attribuutit) {
		parent::__construct($attribuutit);
		$this->validators = array('validoi_maara', 'validoi_yhteystiedot', 'validoi_nimi', 'validoi_osoite', 'validoi_postinumero', 'validoi_kaupunki', 'validoi_sotu');
	}

	public static function find($tunnus) {
		$query = DB::connection()->prepare('SELECT * FROM Tarjous WHERE tunnus = :tunnus LIMIT 1');
		$query->execute(array('tunnus' => $tunnus));
		$row = $query->fetch();

		if ($row) {
			$tarjous = new Tarjous(array(
				'tunnus' => $row['tunnus'],
				'aika' => $row['aika'],
				'maara' => $row['maara'],
				'yhteystiedot' => $row['yhteystiedot'],
				'kokonimi' => $row['kokonimi'],
				'osoite' => $row['osoite'],
				'postinro' => $row['postinro'],
				'kaupunki' => $row['kaupunki'],
				'sotu' => $row['sotu'],
				'tuote' => $row['tuote']
			));

			return $tarjous;
		}

		return null;
	}
	
	public static function tuotteenTarjoukset($tuote) {
		$query = DB::connection()->prepare('SELECT * FROM Tarjous WHERE tuote = :tuote ORDER BY aika DESC');
		$query->execute(array('tuote' => $tuote));
		$rows = $query->fetchAll();

		$tarjoukset = array();

		foreach($rows as $row) {
			$tarjoukset[] = new Tarjous(array(
				'tunnus' => $row['tunnus'],
				'aika' => $row['aika'],
				'maara' => $row['maara'],
				'yhteystiedot' => $row['yhteystiedot'],
				'kokonimi' => $row['kokonimi'],
				'osoite' => $row['osoite'],
				'postinro' => $row['postinro'],
				'kaupunki' => $row['kaupunki'],
				'sotu' => $row['sotu'],
				'tuote' => $row['tuote']							
			));
		}

		return $tarjoukset;
	}

	public static function korkein($tuote) {
		$query = DB::connection()->prepare('SELECT * FROM Tarjous WHERE tuote = :tuote ORDER BY maara DESC LIMIT 1');
		$query->execute(array('tuote' => $tuote));
		$row = $query->fetch();

		if ($row) {
			$tarjous = new Tarjous(array(
				'tunnus' => $row['tunnus'],
				'aika' => $row['aika'],
				'maara' => $row['maara'],
				'yhteystiedot' => $row['yhteystiedot'],
				'kokonimi' => $row['kokonimi'],
				'osoite' => $row['osoite'],
				'postinro' => $row['postinro'],
				'kaupunki' => $row['kaupunki'],
				'sotu' => $row['sotu'],
				'tuote' => $row['tuote']
			));

			return $tarjous;
		}

		return null;
	}

	public function save() {
		$query = DB::connection()->prepare('INSERT INTO Tarjous (aika, maara, yhteystiedot, kokonimi, osoite, postinro, kaupunki, sotu, tuote) VALUES (:aika, :maara, :yhteystiedot, :kokonimi, :osoite, :postinro, :kaupunki, :sotu, :tuote) RETURNING tunnus');

		$query->execute(array('aika' => $this->aika,
							  'maara' => $this->maara,
							  'yhteystiedot' => $this->yhteystiedot,
							  'kokonimi' => $this->kokonimi,
							  'osoite' => $this->osoite,
							  'postinro' => $this->postinro,
							  'kaupunki' => $this->kaupunki,
							  'sotu' => $this->sotu,
							  'tuote' => $this->tuote));
		$row = $query->fetch();

		//Kint::trace();
  		//Kint::dump($row);

		$this->tunnus = $row['tunnus'];
	}

	public function update() {
		$query = DB::connection()->prepare('UPDATE Tarjous SET aika = :aika, maara = :maara, yhteystiedot = :yhteystiedot, kokonimi = :kokonimi, osoite = :osoite, postinro = :postinro, kaupunki = :kaupunki, sotu = :sotu, tuote = :tuote WHERE tunnus = :tunnus RETURNING tunnus');

		$query->execute(array('tunnus' => $this->tunnus,
							  'aika' => $this->aika,
							  'maara' => $this->maara,
							  'yhteystiedot' => $this->yhteystiedot,
							  'kokonimi' => $this->kokonimi,
							  'osoite' => $this->osoite,
							  'postinro' => $this->postinro,
							  'kaupunki' => $this->kaupunki,
							  'sotu' => $this->sotu,
							  'tuote' => $this->tuote));
		$row = $query->fetch();

		//Kint::trace();
  		//Kint::dump($row);

		$this->tunnus = $row['tunnus'];
	}

	public function destroy() {
		$query = DB::connection()->prepare('DELETE FROM Tarjous WHERE tunnus = :tunnus');

		$query->execute(array('tunnus' => $this->tunnus));

		$row = $query->fetch();

		//Kint::trace();
		//Kint::dump($row);
	}

	public function validoi_maara() {
		$errors = array();
		$korkeinTarjous = Tarjous::korkein($this->tuote);
		$tuote = Tuote::find($this->tuote);

		if ($this->maara == null) {
			$errors[] = 'Tarjouksen määrä on pakollinen tieto.';
		}
		if ($this->maara < 0) {
			$errors[] = 'Tarjous ei voi olla negatiivinen.';
		}
		if ($this->maara <= $korkeinTarjous->maara) {
			$errors[] = 'Uuden tarjouksen on oltava korkeampi kuin edelliset tarjoukset (yli '.$korkeinTarjous->maara.'€).';
		}
		if ($this->maara <= $tuote->lahtohinta) {
			$errors[] = 'Tarjouksen on ylitettävä tuotteen lähtöhinta ('.$tuote->lahtohinta.'€).';
		}
		return $errors;
	}

	public function validoi_yhteystiedot() {
		$errors = array();

		if ($this->yhteystiedot == null) {
			$errors[] = 'Sähköpostiosoite on pakollinen tieto.';
		}

		return $errors;
	}

	public function validoi_nimi() {
		$errors = array();

		if ($this->kokonimi == '') {
			$errors[] = 'Nimi on pakollinen tieto.';
		}

		return $errors;
	}

	public function validoi_osoite() {
		$errors = array();

		if ($this->osoite == '') {
			$errors[] = 'Osoite on pakollinen tieto';
		}

		return $errors;
	}

	public function validoi_postinumero() {
		$errors = array();

		if ($this->postinro == null || $this->postinro <= 0) {
			$errors[] = 'Postinumero on pakollinen tieto.';
		}

		return $errors;
	}

	public function validoi_kaupunki() {
		$errors = array();

		if ($this->kaupunki == '') {
			$errors[] = 'Kaupunki on pakollinen tieto.';
		}

		return $errors;
	}

	public function validoi_sotu() {
		$errors = array();

		if ($this->sotu == null || $this->sotu <= 0) {
			$errors[] = 'Sosiaaliturvatunnus on pakollinen tieto';
		}

		return $errors;
	}

}