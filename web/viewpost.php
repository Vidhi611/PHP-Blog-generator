<?php require('includes/config.php'); 

$stmt = $db->prepare('SELECT postID, postTitle, postCont, postDate, postTags FROM blog_posts WHERE postID = :postID');
$stmt->execute(array(':postID' => $_GET['id']));
$row = $stmt->fetch();

//if post does not exists redirect user.
if($row['postID'] == ''){
	header('Location: ./');
	exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Conference - <?php echo $row['postTitle'];?></title>
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
			<img src="https://www.europeansociology.org/sites/default/files/public/uv_fin-e1481821997512_5.jpg" style="height:40vh; width:140vh; " >
		</div>

		<div id="row">
		<div class = "col-sm-9">


		<?php	
			echo '<div>';
					echo '<h1>'.$row['postTitle'].'</h1>';
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
					echo '<p>Tagged as: ';
					$links = array();
					$parts = explode(',', $row['postTags']);
					foreach ($parts as $tag)
					{
					    $links[] = "<a href='t-".$tag."'>".$tag."</a>";
					}
					echo implode(", ", $links);
					echo '</p>';	
					echo '</p>';
					echo '<p>'.$row['postCont'].'</p>';				
				echo '</div>';
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