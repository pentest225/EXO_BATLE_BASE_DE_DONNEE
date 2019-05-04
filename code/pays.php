<?php 
//connexion a la base de donne
require 'config/DataBase.php'; 
if(isset($_GET['id']))
{
	$id_continents=$_GET['id'];
	$db= DB::connect();

	//selection des continans 
	$selectPays=$db->prepare('SELECT * FROM pays WHERE id_continent = ?');
	$selectPays->execute(array($id_continents));
	$resultPays=$selectPays->fetchAll();
}
else
{
	header('Location:continents.php');
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
		<?php if(isset($insertionOk)&& $insertionOk):?>
			<div class="alert alert-success">insertion effecuer avec succes :) </div>
		<?php  endif ?>
		<form class="form-inline mt-5" method="post" action="#">
			<a href="index.php" class="btn btn-info">Retour au continans</a>
			<div class="form-group">
				<div class="form-control">
					<input type="text" name="ville1" class="form-control" placeholder="villes">
				</div>
			</div>	
			<div class="form-group">
				<div class="form-control">
					<input type="text" name="ville2" class="form-control" placeholder="villes">
				</div>
			</div>
			<div class="form-group">
				<div class="form-control">
					<input type="text" name="ville3" class="form-control" placeholder="villes">
				</div>
			</div>
			<div class="form-group">
				<div class="form-control">
					<input type="submit" name="valide" class="btn btn-info" value="Ajouter 3 villes" class="form-control" placeholder="villes">
				</div>
			</div>			
		</form>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Nom</th>
      <th scope="col">superficie </th>
      <th scope="col">Nombres de villes</th>
    </tr>
  </thead>
  <tbody>
  	<?php foreach ($resultPays as $pays ) :
  			$id_pays=$pays['id'];
  			//selection du nombre de ville 
  			 $selectNbVille=$db->prepare('SELECT p.nom , p.superficie , COUNT(v.nom) as nb_villes FROM pays as p join villes as v on p.id = v.id_pays WHERE p.id= ?');
  			 $selectNbVille->execute(array($id_pays));
			 $listePays=$selectNbVille->fetchAll();
			 foreach ($listePays as $infos):
			 $nom_pays=$infos['nom'];
			 $superficie=$infos['superficie'];
			 $nombreVille=$infos['nb_villes'];
			 $id_Dernier_pays=$pays['id'];
  	 ?>
    <tr>
      <td><?=$nom_pays ?></td>
      <td><?=$superficie ?></td>
      <td><?=$nombreVille ?></td>
    </tr>
    <?php endforeach ?>
<?php endforeach ?>
</tbody>
</table>
</body>
</html>
<?php 
	$insertionOk=false;
if(isset($_POST['valide']))
	{

		extract($_POST);
		if(!empty($ville1) && !empty($ville2) && !empty($ville3))
		{
			//insertion des trois villes 
			$insertionVille1=$db->prepare('INSERT INTO villes (nom ,id_pays) VALUES (?,?)');
			$insertionVille1->execute(array($ville1,$id_Dernier_pays));

			$insertionVille2=$db->prepare('INSERT INTO villes (nom ,id_pays) VALUES (?,?)');
			$insertionVille2->execute(array($ville2,$id_Dernier_pays));

			$insertionVille3=$db->prepare('INSERT INTO villes (nom ,id_pays) VALUES (?,?)');
			$insertionVille3->execute(array($ville3,$id_Dernier_pays));
			if($insertionVille3)
			{
				$insertionOk=true;
			}
		}

	};

?>
