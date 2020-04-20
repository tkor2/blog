<?php
include ('header.php');
include ('post.php');
include ('tag.php');


$posts = new Post($db);
$tags = new Tag($db);
?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
             <?php if (isset($_GET['keyword'])){
                echo '<i>'.$_GET['keyword'].'</i>';
            }?>

            <?php foreach ($posts->getPost() as $post){?>
            <div class="media">
                <div class="media-left media-top">
                    <img src="images/<?php echo $post['image']; ?>" class="media-object" style="width: 200px">
                    <p>
                        <br>
                        Gemaakt:<?php echo date('Y-m-d',strtotime($post['created_at'])); ?>
                    </p>
                </div>
                <div class="media-body">
                    <h4 class="media-heading"><a href="view.php?slug=<?php echo $post['slug']; ?>"><?php echo $post['title']?></a></h4>
                    <?php echo htmlspecialchars_decode($post['description'])?>
                </div>
            </div>
            <?php } ?>

            <?php
	$sql = "SELECT count(id)from posts";
	$result = mysqli_query($db,$sql);
	$row = mysqli_fetch_row($result);
	$totalRecords = $row[0];
	$totalPages = ceil($totalRecords/5);
	$pageLink = "<ul class='pagination'>";

	if(!isset($_GET['tag'])){
		//if there is "tag" we don't show pagination
		if (!isset($_GET['page'])) {
			//is there is no "page" we set $_GET=1
			$_GET['page']=1;
		}

	$page = $_GET['page'];

	if($page>1){

		$pageLink.="<a class='page-link'href='index.php?page=1'>Eerste</a>";

		$pageLink.="<a class='page-link'href='index.php?page=".($page-1)."'><<<</a>";
	}

	for($i=1;$i<=$totalPages;$i++){
		$pageLink.="<a class='page-link'href='index.php?page=".$i."'>".$i."</a>  ";
	}

	if($page<=$totalPages){

		$pageLink.="<a class='page-link'href='index.php?page=".($page+1)."'>>>></a>";

		$pageLink.="<a class='page-link'href='index.php?page=".$totalPages."'>Laatste</a>";
	}


	echo $pageLink."</ul>";

}
?>

        </div>
        <div class="col-md-4">
            <h4>Browse door Tags</h4>
            <p>
                <?php
                foreach($tags->getAllTags() as $tag){?>
                    <a href="index.php?tag=<?php  echo $tag['tag'];?>"><button type="button" class="btn btn-outline-warning btn-sm">
                            <?php  echo $tag['tag'];?>
                        </button></a>

                <?php  } ?>
            </p>
            <p>
            <h4>Zoek berichten</h4>
            <form action="" method="GET">
                <input type="text" name="keyword" class="form-control" placeholder="Zoek...">
            </form>
            </p>

                <h4>Populaire berichten</h4>
            <?php foreach ($posts->getPopularPosts() as $p) { ?>
                <p>
            <a href="view.php?slug=<?php echo $p['slug']?>" style="color: black;border-bottom:1px dashed green;">
                <?php echo $p['title']?></a>
                </p>
            <?php } ?>
            </p>
        </div>
    </div>
</div>

<style>
    img{
        margin-right: 10px;
    }
    body{
        text-align: justify;
    }
    .media{
        margin-top:10px ;
    }
    .btn-group-sm>.btn, .btn-sm {
        padding: .25rem .5rem;
        font-size: .875rem;
        line-height: 1.5;
        border-radius: .2rem;
        margin-top: 12px;
    }
</style>