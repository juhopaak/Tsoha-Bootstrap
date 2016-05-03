<?php

class TuotteenLuokat extends BaseModel {

	public $tuote, $tuoteluokka;

	public function __construct($attribuutit) {
		parent::__construct($attribuutit);
	}

	public function save() {
		$query = DB::connection()->prepare('INSERT INTO TuotteenLuokat (tuote, tuoteluokka) VALUES (:tuote, :tuoteluokka)');

		$query->execute(array('tuote' => $this->tuote,
							  'tuoteluokka' => $this->tuoteluokka));
		$row = $query->fetch();

		//Kint::trace();
  		//Kint::dump($row);
	}

	public function destroy() {
		$query = DB::connection()->prepare('DELETE FROM TuotteenLuokat WHERE tuote = :tuote AND tuoteluokka = :tuoteluokka');

		$query->execute(array('tuote' => $this->tuote,
							  'tuoteluokka' => $this->tuoteluokka));

		$row = $query->fetch();

		//Kint::trace();
		//Kint::dump($row);
	}

	public function haeTuotteenLuokat($tunnus) {
		$query = DB::connection()->prepare('SELECT * FROM TuotteenLuokat WHERE tuote = :tunnus');
		$query->execute(array('tunnus' => $tunnus));
		$rows = $query->fetchAll();
		
		$tuotteenLuokat = array();

		foreach($rows as $row) {
			$tuotteenLuokat[] = new TuotteenLuokat(array(
				'tuote' => $row['tuote'],
				'tuoteluokka' => $row['tuoteluokka']
			));
		}

		return $tuotteenLuokat;
	}

	public function haeLuokanTuotteet($tunnus) {
		$query = DB::connection()->prepare('SELECT * FROM TuotteenLuokat WHERE tuoteluokka = :tunnus');
		$query->execute(array('tunnus' => $tunnus));
		$rows = $query->fetchAll();
		
		$luokanTuotteet = array();

		foreach($rows as $row) {
			$luokanTuotteet[] = new TuotteenLuokat(array(
				'tuote' => $row['tuote'],
				'tuoteluokka' => $row['tuoteluokka']
			));
		}

		return $luokanTuotteet;
	}

}