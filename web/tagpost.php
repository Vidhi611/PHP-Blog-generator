<?php require('includes/config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Conference - <?php echo htmlspecialchars($_GET['id']);?></title>
    <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="style/main.css">
    <link rel="stylesheet" type="text/css" href="style/m.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"> </script>
</head>
<body>
    <div class="top" style="background-color: grey; color: white">
        <center><h1 style="color: white">Conference</h1></center>
        <center><p style="color: white">Posts matching tag: <?php echo htmlspecialchars($_GET['id']);?></p></center>
        <hr />
    </div>

    <div id="wrapper">   
           
        <p><a href="./">Conference Index</a></p>
        <div class="row">
        <div class="col-sm-9">

   
            <?php   
            try {

                $stmt = $db->prepare('SELECT postID, postTitle, postSlug, postDesc, postDate, postTags FROM blog_posts WHERE postTags like :postTags ORDER BY postID DESC');
                $stmt->execute(array(':postTags' => '%'.$_GET['id'].'%'));
                while($row = $stmt->fetch()){
                   
                    echo '<div>';
                        echo '<h1><a href="'.$row['postSlug'].'">'.$row['postTitle'].'</a></h1>';
                        echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row['postDate'])).' in ';

                            $stmt2 = $db->prepare('SELECT catTitle, catSlug FROM blog_cats, blog_post_cats WHERE blog_cats.catID = blog_post_cats.catID AND blog_post_cats.postID = :postID');
                            $stmt2->execute(array(':postID' => $row['postID']));

                            $catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                            $links = array();
                            foreach ($catRow as $cat)
                            {
                                $links[] = "<a href='c-".$cat['catSlug']."'>".$cat['catTitle']."</a>";
                            }
                            echo implode(", ", $links);

                        echo '</p>';
                    echo '<p>Tagged as: ';
                    $links = array();
                    $parts = explode(',', $row['postTags']);
                    foreach ($parts as $tag)
                    {
                        $links[] = "<a href='t-".$tag."'>".$tag."</a>";
                    }
                    echo implode(", ", $links);
                    echo '</p>';
                        echo '<p>'.$row['postDesc'].'</p>';               
                        echo '<p><a href="'.$row['postSlug'].'">Read More</a></p>';               
                    echo '</div>';

                }

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