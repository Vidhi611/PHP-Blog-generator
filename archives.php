<?php require('includes/config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Conference - <?php echo $row['catTitle'];?></title>
    <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="style/main.css">
    <link rel="stylesheet" type="text/css" href="style/m.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"> </script>
</head>
<body>
	<div class="top" style="background-color: grey; color: white">
        <center><h1 style="color: white">Conference</h1></center>
        <hr />
    </div>

	<div id="wrapper">

		<p><a href="./">Conference Index</a></p>
		<div class="row">
		<div class="col-sm-9">

			<?php
				try {
					//collect month and year data
					$month = $_GET['month'];
					$year = $_GET['year'];
					//set from and to dates
					$from = date('Y-m-01 00:00:00', strtotime("$year-$month"));
					$to = date('Y-m-31 23:59:59', strtotime("$year-$month"));
					$pages = new Paginator('1','p');
					$stmt = $db->prepare('SELECT postID FROM blog_posts WHERE postDate >= :from AND postDate <= :to');
					$stmt->execute(array(
						':from' => $from,
						':to' => $to
				 	));
					//pass number of records to
					$pages->set_total($stmt->rowCount());
					$stmt = $db->prepare('SELECT postID, postTitle, postSlug, postDesc, postDate FROM blog_posts WHERE postDate >= :from AND postDate <= :to ORDER BY postID DESC '.$pages->get_limit());
					$stmt->execute(array(
						':from' => $from,
						':to' => $to
				 	));
					while($row = $stmt->fetch()){
							echo '<h1><a href="'.$row['postSlug'].'">'.$row['postTitle'].'</a></h1>';
							echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row['postDate'])).' in ';
								$stmt2 = $db->prepare('SELECT catTitle, catSlug	FROM blog_cats, blog_post_cats WHERE blog_cats.catID = blog_post_cats.catID AND blog_post_cats.postID = :postID');
								$stmt2->execute(array(':postID' => $row['postID']));
								$catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);
								$links = array();
								foreach ($catRow as $cat)
								{
								    $links[] = "<a href='c-".$cat['catSlug']."'>".$cat['catTitle']."</a>";
								}
								echo implode(", ", $links);
							echo '</p>';
							echo '<p>'.$row['postDesc'].'</p>';				
							echo '<p><a href="'.$row['postSlug'].'">Read More</a></p>';
					}
					echo $pages->page_links("a-$month-$year&");
				} catch(PDOException $e) {
				    echo $e->getMessage();
				}
			?>

		</div>

		<div class="col-sm-3">
			<?php require('sidebar.php'); ?>
		</div>

		<div id='clear'></div>
	</div>
	</div>


</body>
</html>