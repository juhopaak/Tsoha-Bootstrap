<?php

class Tarjous extends BaseModel {

	public $tunnus, $aika, $maara, $yhteystiedot, $tuote;

	public function __construct($attribuutit) {
		parent::__construct($attribuutit);
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
				'tuote' => $row['tuote']							
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
				'yhteystiedot' => $row['yhteystiedot'],
				'tuote' => $row['tuote']
			));

			return $tarjous;
		}

		return null;
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
				'tuote' => $row['tuote']
			));

			return $tarjous;
		}

		return null;
	}

	public function save() {
		$query = DB::connection()->prepare('INSERT INTO Tarjous (aika, maara, yhteystiedot, tuote) VALUES (:aika, :maara, :yhteystiedot, :tuote) RETURNING tunnus');

		$query->execute(array('aika' => $this->aika,
							  'maara' => $this->maara,
							  'yhteystiedot' => $this->yhteystiedot,
							  'tuote' => $this->tuote));
		$row = $query->fetch();

		//Kint::trace();
  		//Kint::dump($row);

		$this->tunnus = $row['tunnus'];
	}

	public function update() {
		$query = DB::connection()->prepare('UPDATE Tarjous SET aika = :aika, maara = :maara, yhteystiedot = :yhteystiedot, tuote = :tuote WHERE tunnus = :tunnus RETURNING tunnus');

		$query->execute(array('tunnus' => $this->tunnus,
							  'aika' => $this->aika,
							  'maara' => $this->maara,
							  'yhteystiedot' => $this->yhteystiedot,
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

}