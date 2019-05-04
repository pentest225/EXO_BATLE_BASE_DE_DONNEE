<?php 
	//connexion a la base de donne 
require 'config/DataBase.php'; 

	$db= DB::connect();

	//selection des continans 
	$selectCtinant=$db->prepare('SELECT * FROM `continents` WHERE 1');
	$selectCtinant->execute(array());
	$listeContinant=$selectCtinant->fetchAll();

?>
<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<title></title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		<!-- section des tablaux-->
		<h1>Table des continents</h1>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Nom</th>
      <th scope="col">superficie </th>
      <th scope="col">action</th>
    </tr>
  </thead>
  <tbody>
  	<?php foreach ($listeContinant as $continent ) :
  			$Nom_continans=$continent['nom'];
  			$superficie_continans=$continent['superficie'];
  			$id=$continent['id'];
  	 ?>
    <tr>
      <td><?=$Nom_continans ?></td>
      <td><?=$superficie_continans ?></td>
      <td><a href="pays.php?id=<?=$id?>" class="btn btn-info">Voir pays</a><a href="villes.php?id=<?=$id?>" class="btn btn-success">Voir villes</a><a href="habitant.php?id=<?=$id?>" class="btn btn-danger">Voir Habitants</a></td>
    </tr>
<?php endforeach ?>
  </tbody>
</table>
	</body>
	</html>

