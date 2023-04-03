<?php
namespace App\Service;

use PDO;

class PdoFouDeSeries {

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
    public function setLaSerie($laserie)
    {
        $req = "INSERT INTO serie (titre, resume, duree, premiereDiffusion, image) VALUES (:titre, :resume, :duree, :premiereDiffusion, :image)";
        $res = PdoFouDeSerie::$monPdo->prepare($req);
        $res->bindValue(':titre', $laserie['titre'], PDO::PARAM_STR);
        $res->bindValue(':resume', $laserie['resume'], PDO::PARAM_STR);
        $res->bindValue(':duree', $laserie['duree'], PDO::PARAM_INT);
        $res->bindValue(':premiereDiffusion', $laserie['premiereDiffusion'], PDO::PARAM_STR);
        $res->bindValue(':image', $laserie['image'], PDO::PARAM_STR);
        $res->execute();

        $req1 = "SELECT * FROM serie WHERE id=LAST_INSERT_ID()";
        $res1 = PdoFouDeSerie::$monPdo->prepare($req1);
        $res1->execute();
        $laLigne = $res1->fetch();
        return $laLigne;
    }
    public function deleteSerie($id)
    {
        $req = "DELETE FROM serie WHERE id = :id";
        $res = PdoFouDeSerie::$monPdo->prepare($req);
        $res->bindValue(':id', $id, PDO::PARAM_INT);
        $res->execute();
    }
    public function updateSerieComplete($id, $laserie)
    {
        $req = "UPDATE serie SET titre = :titre, resume = :resume, duree = :duree, premiereDiffusion = :premiereDiffusion, image = :image WHERE id = :id";
        $res = PdoFouDeSerie::$monPdo->prepare($req);
        $res->bindParam(':id', $id, PDO::PARAM_INT);
        $res->bindParam(':titre', $laserie['titre'], PDO::PARAM_STR);
        $res->bindParam(':resume', $laserie['resume'], PDO::PARAM_STR);
        $res->bindParam(':duree', $laserie['duree'], PDO::PARAM_INT);
        $res->bindParam(':premiereDiffusion', $laserie['premiereDiffusion'], PDO::PARAM_STR);
        $res->bindParam(':image', $laserie['image'], PDO::PARAM_STR);
        $res->execute();
        $req1 = "SELECT * FROM serie WHERE id=:id";
        $res1 = PdoFouDeSerie::$monPdo->prepare($req1);
        $res1->bindParam(':id', $id, PDO::PARAM_INT);
        $res1->execute();
        $laLigne = $res1->fetch();
        return $laLigne;
    }
}
