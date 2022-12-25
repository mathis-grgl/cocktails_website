<!DOCTYPE html>
<html lang="fr">
<head>
  <title>Recette</title>
	<meta charset="utf-8" />
	<meta name="keywords">

  <link href="style.css" rel="stylesheet" type="text/css"/>

</head>

<body>

  <script type="text/javascript">
    function ajouterAuPanier(){
      panier['indexCocktail'].push(indexCocktail);
      panier['url'].push(definitiveUrl);
      var panierToCookie = JSON.stringify(panier);
      //console.log(panier);

      var date = new Date();
      date.setTime(date.getTime() + 3600*1000);
      var expires = "; expires=" + date.toUTCString();
      document.cookie = "panier =" + panierToCookie + expires + "; path=/";
      //console.log("panier =" + panierToCookie + expires + "; path=/");

      var toast = document.querySelector(".toastAjouterPanier");
      toast.style.display = "block";
      setTimeout(function() {
      toast.style.display = "none";
      }, 2000);
    }
  </script>

  <div class="header">
    <div class="logo"><a href=index.php><img src="../Photos/cocktail_logo.png" height="52" width="44"></a></div>
      <input id="recherche" class="recherche" onkeyup="" type="text" name="recherche" placeholder="Rechercher dans le site">
      <a href="panier.php">Panier</a>
      <div class="logo"><a href=account.php?page=1><img src="../Photos/account.png" height="44" width="44"></a></div>
    <div class="headerend"></div>
  </div>

  <div class="contenu">
    <?php require 'Donnees.inc.php';
      $cookie = 0;
      $panierJson = "";
      if (isset($_COOKIE['panier'])){ $cookie = 1;}
      else {
        $cookie = 2;
        $panier = array('indexCocktail' => array(), 'url' => array());
        $panierJson = json_encode($panier);
      }

      $indexCocktail = $_GET["indexCocktail"];
      
      $titreCocktail = $Recettes[$indexCocktail]['titre'];
      
      $recetteCocktail = $Recettes[$indexCocktail]['preparation'];

      $ingredientsArray = explode('|', $Recettes[$indexCocktail]['ingredients']);

      $definitiveUrl = "../Photos/default_cocktail.png";

      $urlCocktail = $titreCocktail;
      $urlCocktail = str_replace(" ","_",$urlCocktail);
      preg_match("/^[^(]+/", $urlCocktail, $match);
      $urlCocktail = $match[0];
      $urlCocktail = iconv('UTF-8', 'ASCII//TRANSLIT', $urlCocktail);
      $urlCocktail = preg_replace("/[^a-zA-Z0-9-_]/", "", $urlCocktail);
      $urlCocktail = rtrim($urlCocktail, "_");
      $urlCocktail = "../Photos/".$urlCocktail.".jpg";

      if (file_exists($urlCocktail)) $definitiveUrl = $urlCocktail;?>

      <script type="text/javascript">
        var cookie = JSON.parse('<?php echo $cookie; ?>');
        if(cookie == 1){
          var allCookies = document.cookie.match(new RegExp('(^| )panier=([^;]+)'));
          var panierJson = allCookies[2];
          var panier = JSON.parse(panierJson);
          console.log(panier);
        }

        if(cookie ==2) var panier = JSON.parse('<?php echo $panierJson; ?>');
        var indexCocktail = <?php echo $indexCocktail;?>;
        var definitiveUrl = "<?php echo $definitiveUrl;?>";
      </script>
 <?php
      echo 
    "<div class=\"contenuRecette\">
      <div class=\"imageRecette\">
        <img src=\"".$definitiveUrl."\" alt=\"".$titreCocktail."\">
      </div>
      <div class=\"texteRecette\">
        <h1>".$titreCocktail."</h1>
        <p>".$recetteCocktail."</p><br>";

      foreach($ingredientsArray as $ingredient){
        echo   
        "<p>".$ingredient."</p>";
      }
      ?>

        <button class="boutonAjouterPanier" onclick="ajouterAuPanier()">Ajouter au panier</button>

        <div class="toastAjouterPanier">
          <p>Cocktail ajouté au panier</p>
        </div>
      </div>
    </div>
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
