<?php
namespace App\Service;

use PDO;

class PdoFouDeSerie {

    private static $monPdo;
    public function __construct($server, $bdd, $user, $mdp) {
        PdoFouDeSerie::$monPdo = new PDO($server.';'.$bdd, $user, $mdp);
    }

    public function getLesSeries() {
        $res = PdoFouDeSerie::$monPdo->prepare('SELECT * FROM serie');
        $res->execute();
        $lesSeries = $res->fetchAll();
        return $lesSeries;
    }
    public function getNbSeries() {
        $res = PdoFouDeSerie::$monPdo->prepare('SELECT count(*) FROM serie');
        $res->execute();
        $nbSeries = $res->fetch();
        return $nbSeries[0];
    }
}
