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

		$query->execute(array('tuote' => $this->tunnus,
							  'tuoteluokka' => $this->tuoteluokka));

		$row = $query->fetch();

		//Kint::trace();
		//Kint::dump($row);
	}

}