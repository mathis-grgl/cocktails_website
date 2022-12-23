<!DOCTYPE html>
<html lang="fr">
<head>
  <title>Cocktails</title>
	<meta charset="utf-8" />
	<meta name="keywords">

  <link href="style.css" rel="stylesheet" type="text/css"/>
</head>

<body>

  <div class="header">
    <div class="logo"><a href=index.php><img src="../Photos/cocktail_logo.png" height="52" width="44"></a></div>
      <input id="recherche" class="recherche" onkeyup="" type="text" name="recherche" placeholder="Rechercher dans le site">
      <a href="panier.html">Panier</a>
      <div class="logo"><a href=account.html><img src="../Photos/account.png" height="44" width="44"></a></div>
    <div class="headerend"></div>
  </div>

  <div class="contenu">
   <?php require 'Donnees.inc.php';
   $cpt = 0;
   for($i=0 ; $i < count($Recettes); $i++){
    $titreCocktail = $Recettes[$i]['titre'];
    $definitiveUrl = "../Photos/default_cocktail.png";

    $urlCocktail = $titreCocktail;
    $urlCocktail = str_replace(" ","_",$urlCocktail);
    preg_match("/^[^(]+/", $urlCocktail, $match);
    $urlCocktail = $match[0];
    $urlCocktail = iconv('UTF-8', 'ASCII//TRANSLIT', $urlCocktail);
    $urlCocktail = preg_replace("/[^a-zA-Z0-9-_]/", "", $urlCocktail);
    $urlCocktail = rtrim($urlCocktail, "_");
    $urlCocktail = "../Photos/".$urlCocktail.".jpg";

    if (file_exists($urlCocktail)) $definitiveUrl = $urlCocktail;

    echo "<a class=\"aBlockCocktail\" href=\"recette.php?indexCocktail=".$i."\">
            <div class=\"blockCocktail\">
                <img class=\"imageCocktail\" src=\"".$definitiveUrl."\">
                <h2>".$titreCocktail."</h2>
            </div>
          </a>";
    }
      ?>
  </div>

  <div class="footer">
    <div class=footerbegin></div>
    <div class="contact">
    Pour nous contacter : <a href="mailto:joseph.schlesinger2@etu.univ-lorraine.fr">joseph.schlesinger2@etu.univ-lorraine.fr</a>, <a href="mailto:mathis.georgel8@etu.univ-lorraine.fr">mathis.georgel8@etu.univ-lorraine.fr</a>
    </div>
    <div class=footerend></div>
  </div>

</body>

</html>
