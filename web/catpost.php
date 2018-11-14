<?php require('includes/config.php'); 


$stmt = $db->prepare('SELECT catID,catTitle FROM blog_cats WHERE catSlug = :catSlug');
$stmt->execute(array(':catSlug' => $_GET['id']));
$row = $stmt->fetch();

//if post does not exists redirect user.
if($row['catID'] == ''){
    header('Location: ./');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Conference- <?php echo $row['catTitle'];?></title>
    <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="style/main.css">
    <link rel="stylesheet" type="text/css" href="style/m.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"> </script>
</head>
<body>
    <div class="top" style="background-color: grey; color: white">
        <center><h1 style="color: white">Conference</h1></center>
        <center><p style="color: white">Posts in <?php echo $row['catTitle'];?></p></center>
        <hr />
    </div>
    <div id="wrapper">
        
        <p><a href="./">Conference Index</a></p>
        <div class ="row">
        <div class ="col-sm-9">
        <?php    
        try {
            $pages = new Paginator('1','p');
            $stmt = $db->prepare('SELECT blog_posts.postID FROM blog_posts, blog_post_cats WHERE blog_posts.postID = blog_post_cats.postID AND blog_post_cats.catID = :catID');
                $stmt->execute(array(':catID' => $row['catID']));
                //pass number of records to
                $pages->set_total($stmt->rowCount());

            $stmt = $db->prepare('
                SELECT 
                    blog_posts.postID, blog_posts.postTitle, blog_posts.postSlug, blog_posts.postDesc, blog_posts.postTags, blog_posts.postDate 
                FROM 
                    blog_posts,
                    blog_post_cats
                WHERE
                     blog_posts.postID = blog_post_cats.postID
                     AND blog_post_cats.catID = :catID
                ORDER BY 
                    postID DESC
                ');
            $stmt->execute(array(':catID' => $row['catID']));
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
                    echo '<p>'.$row['postDesc'].'</p>';     
                    echo '<p>Tagged as: ';
                    $links = array();
                    $parts = explode(',', $row['postTags']);
                    foreach ($parts as $tag)
                    {
                        $links[] = "<a href='t-".$tag."'>".$tag."</a>";
                    }
                    echo implode(", ", $links);
                    echo '</p>';           
                    echo '<p><a href="'.$row['postSlug'].'">Read More</a></p>';                
                echo '</div>';

            }
            echo $pages->page_links('c-'.$_GET['id'].'&');

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