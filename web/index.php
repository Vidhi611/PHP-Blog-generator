<?php require('includes/config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Conferences across the world</title>
    <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="style/main.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"> </script>
</head>
<body>

	<div id="wrapper">

		<center><h1><b>Conferences across the world</b></h1></center>
		<div class="row">
			<img src="http://www.oursideofsuicide.com/wp-content/uploads/2016/05/writing-.jpg" style="height:40vh; width:140vh; " >
		</div>
		<hr />
		<div id="main">
		<?php
			try {
				$pages = new Paginator('1','p');
				$stmt = $db->query('SELECT postID FROM blog_posts');
				$pages->set_total($stmt->rowCount());

				$stmt = $db->query('SELECT postID, postTitle, postSlug, postDesc, postDate, postTags FROM blog_posts ORDER BY postID DESC');
				
				while($row = $stmt->fetch()){
					
						echo '<h1><a href="'.$row['postSlug'].'">'.$row['postTitle'].'</a></h1>';
						echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row['postDate'])).' in ';

							$stmt2 = $db->prepare('SELECT catTitle, catSlug    FROM blog_cats, blog_post_cats WHERE blog_cats.catID = blog_post_cats.catID AND blog_post_cats.postID = :postID');
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
						echo '<p><a href="viewpost.php?id='.$row['postID'].'">Read More</a></p>';	
						echo '<p>Tagged as: ';
						    $links = array();
						    $parts = explode(',', $row['postTags']);
						    foreach ($parts as $tag)
						    {
						        $links[] = "<a href='t-".$tag."'>".$tag."</a>";
						    }
						    echo implode(", ", $links);
						echo '</p>';			

				}
				echo $pages->page_links();

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}
		?>
		</div>
	</div>
	<div id='sidebar'>
			<?php require('sidebar.php'); ?>
		</div>

		<div id='clear'></div>

</div>


</body>
</html>