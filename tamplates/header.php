<!DOCTYPE html>
<html>
  	<head>
    	<title><?= $head['title'] ?></title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/main.css">
		<?= implode('', $head['js']); ?>
		<?= implode('', $head['css']); ?>
  	</head>
  	<body>
  		<nav class="navbar navbar-default">
		  	<div class="container-fluid">
		    	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      		<ul class="nav navbar-nav">
				        <li <?= $page == '' ? 'class="active"' : ''?>><a href="index.php">Home</a></li>
				        <li <?= $page == 'addXmlFile' ? 'class="active"' : ''?>><a href="index.php?page=addXmlFile">Add XML to Database</a></li>
				        <li <?= $page == 'searchRecords' ? 'class="active"' : ''?>><a href="index.php?page=searchRecords">Search Records</a></li>
		      		</ul>
		    	</div>
		  	</div>
		</nav>
		<?php foreach($msg as $_type => $_msg): ?>
			<?php if(!empty($_msg)): ?>
		  		<div class="alert alert-<?=$_type?>">
					<strong><?=$_msg?></strong>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>

