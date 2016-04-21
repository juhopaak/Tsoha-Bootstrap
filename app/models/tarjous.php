<?php

class Tarjous extends BaseModel {

	public $tunnus, $aika, $maara, $tuote, $kayttaja;

	public function __construct($attribuutit) {
		parent::__construct($attribuutit);
	}
	
	public static function tuotteenTarjoukset($tuote) {
		$query = DB::connection()->prepare('SELECT * FROM Tarjous WHERE tuote = :tuote');
		$query->execute(array('tuote' => $tuote));
		$rows = $query->fetchAll();

		$tarjoukset = array();

		foreach($rows as $row) {
			$tarjoukset[] = new Tarjous(array(
				'tunnus' => $row['tunnus'],
				'aika' => $row['aika'],
				'maara' => $row['maara'],
				'tuote' => $row['tuote'],
				'kayttaja' => $row['kayttaja']								
			));
		}

		return $tarjoukset;
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
				'tuote' => $row['tuote'],
				'kayttaja' => $row['kayttaja']
			));

			return $tarjous;
		}

		return null;
	}

	public static function korkein($tuote) {
		$query = DB::connection()->prepare('SELECT * FROM Tarjous WHERE tuote = :tuote ORDER BY maara DESC LIMIT 1');
		$query->execute(array('tuote' => $tuote));
		$rows = $query->fetch();

		if ($row) {
			$tarjous = new Tarjous(array(
				'tunnus' => $row['tunnus'],
				'aika' => $row['aika'],
				'maara' => $row['maara'],
				'tuote' => $row['tuote'],
				'kayttaja' => $row['kayttaja']
			));
		}
	}

	public function save() {
		$query = DB::connection()->prepare('INSERT INTO Tarjous (aika, maara, tuote, kayttaja) VALUES (:aika, :maara, :tuote, :kayttaja) RETURNING tunnus');

		$query->execute(array('aika' => $this->aika,
							  'maara' => $this->maara,
							  'tuote' => $this->tuote,
							  'kayttaja' => $this->kayttaja));
		$row = $query->fetch();

		//Kint::trace();
  		//Kint::dump($row);

		$this->tunnus = $row['tunnus'];
	}

	public function update() {
		$query = DB::connection()->prepare('UPDATE Tarjous SET aika = :aika, maara = :maara, tuote = :tuote, kayttaja = :kayttaja WHERE tunnus = :tunnus RETURNING tunnus');

		$query->execute(array('tunnus' => $this->tunnus,
							  'aika' => $this->aika,
							  'maara' => $this->maara,
							  'tuote' => $this->tuote,
							  'kayttaha' => $this->kayttaja));
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

}