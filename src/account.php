<!DOCTYPE html>
<html lang="fr">
<head>
  <title>Compte</title>
	<meta charset="utf-8" />
	<meta name="keywords">

  <link href="style.css" rel="stylesheet" type="text/css"/>

  <?php function inscriptionOrConnexion(){
    $noPage = 1;
    if(isset($_GET["page"])){
        $noPage = $_GET["page"];
    }
    if($noPage==2){
        return "S'inscrire";
    }
    return "Connexion";
  }

  function displayButton(){
    $noPage = 1;
    if(isset($_GET["page"])){
        $noPage = $_GET["page"];
    }
    if($noPage == 2){
        return "style=\"display : none;\"";
    }
    return "";
  }
  ?>
</head>

<body>

    <?php require 'Donnees.inc.php'; 
    $noPage = 1;
    $stylePseudo ="";
    $stylePassword ="";
    $nbPseudo = 0;
    $pseudo = "";
    $nbPassword = 0;
    $password = "";
    $cookie = 0;


    if(isset($_GET["page"])){
        $noPage = $_GET["page"];
    }

    if(isset($_COOKIE['account'])){
        $cookie = 1;
        $identifiantCookie = $_COOKIE['account'];
        $position = strpos($identifiantCookie, ":");
        $pseudo = substr($identifiantCookie, 0, $position);
        //$password = substr($identifiantCookie,$position+1,strlen($identifiantCookie));

    } else {

    if(isset($_POST["submit"])){


      $mysqli = mysqli_connect("projetwebs5","root","" , "Cocktails");
      
      $queryPseudo = "SELECT pseudo FROM utilisateur WHERE pseudo='".$_POST['username']."';";
      $queryPassword = "SELECT password FROM utilisateur WHERE pseudo='".$_POST['username']."' AND password='".$_POST['password']."';";
      //echo $query;
      $resultat = $mysqli->query($queryPseudo);
      while ($row = $resultat->fetch_assoc()){
        $nbPseudo++;
        $pseudo = $row['pseudo'];
      }

      $resultat = $mysqli->query($queryPassword);
      while ($row = $resultat->fetch_assoc()){
        $nbPassword++;
        $password = $row['password'];
      }

      if($noPage ==1) if($nbPseudo ==1){
        $stylePseudo = "value=\"".$pseudo."\"";
        if($nbPassword ==1){
            $identifiant = $pseudo.":".$password;
            setcookie("account",$identifiant,  time() + 3600);
        } else {$stylePassword = "style = \"background-color: RED;\"";
        }
      } else {
        $stylePseudo = "style = \"background-color: RED;\"";
        $stylePassword = "style = \"background-color: RED;\"";
      }

      if($noPage ==2){
        if($nbPseudo ==1) $stylePseudo = "style = \"background-color: RED;\"";
        else{
            $pseudo = $_POST['username'];
            $password = $_POST['password'];
            $queryInsertionUser = "INSERT INTO utilisateur(pseudo,password) VALUES('".$pseudo."','".$password."');";
            $mysqli->query($queryInsertionUser);
            $identifiant = $pseudo.":".$password;
            setcookie("account",$identifiant,  time() + 3600);
            $nbPassword = 2;
        }
      }
      $mysqli->close();
    }
    }
    ?>

    <script type="text/javascript">
        $nbConnecte = <?php echo $nbPseudo;?>;
        $nbPassword = <?php echo $nbPassword;?>;
        $noPage = <?php echo $noPage;?>;
        $cookie = <?php echo $cookie;?>;
        
        if($cookie == 1 && $noPage ==1){
            window.open("?page=0","_self");
        } 

        if($noPage == 3){
            window.open("?page=1","_self");
            document.cookie = "account= ; expires = Thu, 01 Jan 1970 00:00:00 GMT"
        }

        if($noPage ==1){
            if($nbConnecte==1){
                if($nbPassword ==1){
                    window.open("?page=0","_self");
                } 
            }
        }
        if ($noPage == 2 && $nbConnecte ==0 && $nbPassword == 2){
            window.open("?page=0","_self");
        }
    </script>

  <div class="header">
    <div class="logo"><a href=index.php><img src="../Photos/cocktail_logo.png" height="52" width="44"></a></div>
      <input id="recherche" class="recherche" onkeyup="" type="text" name="recherche" placeholder="Rechercher dans le site">
      <a href="panier.html">Panier</a>
      <div class="logo"><a href=account.php?page=1><img src="../Photos/account.png" height="44" width="44"></a></div>
    <div class="headerend"></div>
  </div>

  <div class="contenuCompte">
    <?php if($noPage==0){
        echo "<p> Bienvenue ";echo $pseudo;echo "</p>
        <a class=\"deconnexion\" href=\"panier.php\">Accéder à votre panier</a>
        <a class=\"deconnexion\" href=\"account.php?page=3\">Déconnexion</a>";
    } else if($noPage==1 || $noPage ==2) {
        echo "
      <div class=\"formConnexion\">
        <form action=\"\" method=\"post\">
          <label for=\"username\">Pseudo</label><br>
          <input type=\"text\" id=\"username\" name=\"username\" ";echo $stylePseudo;echo " required><br>
          <label for=\"password\">Mot de passe</label><br>
          <input type=\"password\" id=\"password\" name=\"password\" ";echo $stylePassword;echo " required><br>
          <input type=\"submit\" name =\"submit\" value=\"";echo inscriptionOrConnexion();echo "\">
        </form>
    </div>
    <a class=\"inscription\"";
    echo displayButton(); echo "href=\"account.php?page=2\">S'inscrire</a>";
    }?>
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
