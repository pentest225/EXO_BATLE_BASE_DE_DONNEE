<?php 
	//connexion a la base de donne 
require 'config/DataBase.php'; 

if(isset($_GET['id']))
{
	$id_continent=$_GET['id'];
	$db=DB::connect();

	//selection des continans 
	//selection du HABITANTS D'UNE VILLE
	$selectHabitant=$db->prepare('SELECT h.* , q.nom as nom_quartier FROM habitants as h LEFT JOIN quartiers as q 
		on h.id_quartier = q.id WHERE id_quartier in 
		(SELECT id FROM quartiers WHERE id_commune IN 
			(SELECT id FROM communes WHERE id_ville IN 
				(SELECT id FROM villes WHERE id_pays IN 
					(SELECT id FROM pays WHERE id_continent = ?)))) ORDER BY h.solde ASC') ;
	$selectHabitant->execute([$id_continent]);
	$listeHabitant=$selectHabitant->fetchAll();
	
}
else
{
	header('Location:index.php');
}

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
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<title></title>
	</head>
	<body>
		<!-- section des tablaux-->
		<h1>Table des continents</h1>
		<a href="index.php" class="btn btn-info">Retour au continans</a>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Nom</th>
      <th scope="col">prenoms </th>
      <th scope="col">quartier</th>
      <th scope="col">solde</th>
      <th scope="col">numero</th>
    </tr>
  </thead>
  <tbody>
  	<?php $solde_tatal=0 ;?>
  	<?php foreach ($listeHabitant as $H ) :
  			
			 $nom=$H['nom'];
			 $prenoms=$H['prenom'];
			 $quartier=$H['nom_quartier'];
			 $solde=$H['solde'];
			 $numero=$H['numero'];
			 $id=$H['id'];
			 $solde_tatal+=$solde;
  	 ?>
    <tr>
      <td><?=$nom ?></td>
      <td><?=$prenoms ?></td>
      <td><?=$quartier ?></td>
      <td><?=$solde ?> fr</td>
      <td><?=$numero ?></td>
    </tr>
<?php endforeach ?>
<tr>
	 <td><strong>Total</strong></td>
      <td></td>
      <td></td>
      <td><strong><?=$solde_tatal ?> fr</strong></td>
      <td></td>

</tr>
</tbody>
</table>
</body>
</html>

