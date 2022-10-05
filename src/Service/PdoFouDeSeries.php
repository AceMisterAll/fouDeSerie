<?php
namespace App\Service;

use PDO;

class PdoFouDeSerie {

    private static $monPdo;
    public function __construct($server, $bdd, $user, $mdp) {
        PdoFouDeSerie::$monPdo = new PDO($server.';'.$bdd, $user, $mdp, array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
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
    public function getUneSerie($id)
    {
        $res = PdoFouDeSerie::$monPdo->prepare('SELECT * FROM serie WHERE id = :id');
        $res->execute(['id' => $id]);
        $uneSerie = $res->fetch();
        return $uneSerie;
    }
    public function createUneSerie($id, $title)
    {
        $res = PdoFouDeSerie::$monPdo->prepare('INSERT INTO serie (id, titre) VALUES (:id, :titre)');
        $res->execute(['id' => $id, 'titre' => $title]);
        $uneSerie = $res->fetch();
        return $uneSerie;
    }
}
