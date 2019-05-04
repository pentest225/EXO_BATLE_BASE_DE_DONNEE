<?php 
	//connexion a la base de donne 
require 'config/DataBase.php'; 

if(isset($_GET['id']))
{
	$id_continents=$_GET['id'];
	$db=DB::connect();

	//selection des continans 
	//selection du nombre de ville 
	$selectVille=$db->prepare('SELECT v.* , p.nom as nom_pays FROM villes as v JOIN pays as p on ( v.id_pays =p.id && v.id_pays IN (SELECT id FROM pays WHERE id_continent = ?))');
	$selectVille->execute(array($id_continents));
	$resultVille=$selectVille->fetchAll();
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
		
		<form class="form-inline mt-5" method="post" action="#">
			<a href="index.php" class="btn btn-info">Retour au continans</a>
			<div class="form-group">
				<select class="form-control" name="id_villes">
					<option value="">...</option>
						<?php foreach ($resultVille as $villes ) :
								 $id_ville=$villes['id'];
								 $nom_ville=$villes['nom'];
					  	 ?>
					<option value="<?=$id_ville?>"><?=$nom_ville ?> </option>
				<?php endforeach ?>
				</select>
			</div>	
			<div class="form-group">
				<div class="form-control">
					<input type="text" name="superficie" class="form-control" placeholder="Saissir la superficie d'une ville">
				</div>
			</div>	
			<div class="form-group">
				<div class="form-control">
					<input type="submit" name="submit" class=" btn btn-info form-control" value="modifier">
				</div>
			</div>			
		</form>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Nom</th>
      <th scope="col">superficie </th>
      <th scope="col">Pays</th>
    </tr>
  </thead>
  <tbody>
  	<?php foreach ($resultVille as $villes ) :
  			
			 $nom_ville=$villes['nom'];
			 $superficie=$villes['superficie'];
			 $nom_pays=$villes['nom_pays'];
  	 ?>
    <tr>
      <td><?=$nom_ville ?></td>
      <td><?=$superficie ?></td>
      <td><?=$nom_pays ?></td>
    </tr>
<?php endforeach ?>
</tbody>
</table>
</body>
</html>
<?php 
	$insertionOk=false;
if(isset($_POST['submit']))
	{
		
		extract($_POST);
		if(!empty($id_villes) && !empty($superficie) && $superficie > 0)
		{
			$mise_a_jour =$db->prepare('UPDATE villes SET superficie = ? WHERE id = ?');
			$mise_a_jour->execute([$superficie,$id_villes]);
			if($mise_a_jour){
				
			}
		}

	};

?>
