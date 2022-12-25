<?php require 'Donnees.inc.php';

  function query($link,$requete)
  { 
    $resultat=mysqli_query($link,$requete) or die("$requete : ".mysqli_error($link));
	return($resultat);
  }


$mysqli=mysqli_connect('projetwebs5', 'root', '') or die("Erreur de connexion");
$base="Cocktails";
$Sql="
		DROP DATABASE IF EXISTS $base;
		CREATE DATABASE $base;
		USE $base;
        CREATE TABLE Cocktail (idCocktail INT PRIMARY KEY, url VARCHAR(255) NOT NULL);
        CREATE TABLE Panier (idPanier INT PRIMARY KEY, idCocktail INT NOT NULL ,FOREIGN KEY (idCocktail) REFERENCES Cocktail(idCocktail));
		CREATE TABLE utilisateur (idUser INT AUTO_INCREMENT PRIMARY KEY UNIQUE, pseudo VARCHAR(255) NOT NULL UNIQUE, password VARCHAR(255) NOT NULL);
		INSERT INTO utilisateur (pseudo, password) VALUES ('admin','password')";

foreach(explode(';',$Sql) as $Requete) query($mysqli,$Requete);


for ($i=0; $i < count($Recettes); $i++) { 
    $definitiveUrl = "../Photos/default_cocktail.png";
    $titreCocktail = $Recettes[$i]['titre'];
    $urlCocktail = $titreCocktail;
    $urlCocktail = str_replace(" ","_",$urlCocktail);
    preg_match("/^[^(]+/", $urlCocktail, $match);
    $urlCocktail = $match[0];
    $urlCocktail = iconv('UTF-8', 'ASCII//TRANSLIT', $urlCocktail);
    $urlCocktail = preg_replace("/[^a-zA-Z0-9-_]/", "", $urlCocktail);
    $urlCocktail = rtrim($urlCocktail, "_");
    $urlCocktail = "../Photos/".$urlCocktail.".jpg";

    if (file_exists($urlCocktail)) $definitiveUrl = $urlCocktail;

    $requete = "INSERT INTO Cocktail VALUES (".$i.",\"".$definitiveUrl."\");";
    query($mysqli,$requete);
}

mysqli_close($mysqli);
?>