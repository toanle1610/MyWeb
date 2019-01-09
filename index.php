<?php 

  session_start();

  // connect to database
  require 'connect.php';

  // query home content
  $query = 'SELECT contentId, content, contenttype, ordernum FROM homecontent ORDER BY ordernum';

  $statement = $db->prepare($query);

  $statement->execute();

  $contents = $statement->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_UNIQUE);

  $ordernum = null;

  $ordernum_changed = false;
  $isprevious_ulist = false;
  $isprevious_olist = false;
?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<title>Kimmy Túi Xuất Xịn</title>
	<script type="text/javascript" src="script.js"></script>
	<link rel="stylesheet" type="text/css" href="house.css">
</head>
<body>
	<header>
		<div class = "header_images">
			<img class="mySlides" src="Image/Wall1.jpg" alt="Wall1.jpg">
			<img class="mySlides" src="Image/Wall2.jpg" alt="Wall1.jpg">
			<img class="mySlides" src="Image/Wall3.jpg" alt="Wall1.jpg">
		</div>
		
	</header>
	
	<nav>
		<div class = profile>
			<img src="Image/Profile.jpg" alt="Profile.jpg">
		</div>
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="products.php">Products</a></li>
			<li><a href="contact.html">Contact</a></li>
		</ul>
	</nav>
	<h1>Order Túi Xách Xuất Khẩu</h1>
	<article id="index_article">
		<?php foreach ($contents as $contentId => $arr): ?>
			<?php 
				if(!isset($ordernum))
				{
					$ordernum = $arr['ordernum'];
				}

				if($ordernum !== $arr['ordernum'])
				{
					$ordernum_changed = true;
					$ordernum = $arr['ordernum'];
					
					if($isprevious_ulist === true)
					{
						$isprevious_ulist = false;
						echo "</ul>";
					}

					if($isprevious_olist === true)
					{
						$isprevious_olist = false;
						echo "</ol>";
					}
				}
			?>
			<?php if (isset($_SESSION['user']) && $_SESSION['user'] == "admin"): ?>
				<p>
					<mark> <?= $ordernum ?> </mark>
				</p>
			<?php endif ?>

			<?php if($arr['contenttype'] == "1"): ?>
				<p>
					<strong><?= $arr['content'] ?></strong>
				</p>
			<?php endif ?>

			<?php if($arr['contenttype'] == "2"): ?>
				<br>
				<p>
					<?= $arr['content'] ?>
				</p>
			<?php endif ?>

			<?php if($arr['contenttype'] == "3"): ?>
				<?php if ($ordernum_changed === true):?>
					<ul>
						<li><?= $arr['content'] ?></li>
					<?php $isprevious_ulist = true; ?>
					<?php $ordernum_changed = false; ?>
				<?php else: ?>
					<li><?= $arr['content'] ?></li>
				<?php endif ?>
			<?php endif ?>

			<?php if($arr['contenttype'] == "4"): ?>
				<?php if ($ordernum_changed === true):?>
					<ol>
						<li><?= $arr['content'] ?></li>
					<?php $isprevious_olist = true; ?>
					<?php $ordernum_changed = false; ?>
				<?php else: ?>
					<li><?= $arr['content'] ?></li>
				<?php endif ?>
			<?php endif ?>	
		<?php endforeach ?>
	</article>
	
	<footer>
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="products.php">Products</a></li>
			<li><a href="contact.html">Contact</a></li>
			<li><a href="homeContentUpdate.php">Content Update</a></li>
		</ul>
		<img src="Image/QRCode.jpg" style="width: 100px; margin: 20px;" alt="QRCode.jpg">
	</footer>
</body>
</html>