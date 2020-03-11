<?php
include ('header.php');
include ('post.php');
include ('comment.php');


$posts = new Post($db);
$comment = new Comment($db);



?>

<div class="container">
    <div class="row">
        <?php foreach($posts->getSinglePost($_GET['slug']) as $post){ ?>
            <div class="card">
                <img  class="card-img-top" src="images/<?php echo $post['image']; ?>" >
            </div>
            <div class="card-body">
                <h4 class="card-title"><?php echo $post['title']; ?></h4>
                <p class="card-text"><?php echo $post['description']; ?></p>
            </div>
        <?php } ?>
    </div>
    <br>
    <h4>Commentaar(<?php echo $comment->countComments($_GET['slug']); ?>)</h4>
    <?php
    if(isset($_POST['btnComment'])){
        $date = date('Y-m-d');
        $status = 0;
        if(!empty($_POST['name'])&&!empty($_POST['email'])&&!empty($_POST['description'])){
            $result = $comment->comment(strip_tags($_POST['name']),strip_tags($_POST['email']),strip_tags($_POST['subject']),
                strip_tags($_POST['description']),$_GET['slug'],$date , $status);
            if($result==true){
                echo"Commentaar toegevoegd!";
            }

        }else{
            echo"Naam, Email en omschrijving zijn verplicht";
        }
    }
    ?>
    <?php foreach($comment->getCommentsBySlug($_GET['slug']) as $comment) { ?>

        <div class="media">
            <div class="media-left media-top">
                <img class="my-1 myx-2" src="images/avatar.png" style="width: 100px;">

            </div>
            <div class="media-body">
                <strong><?php echo $comment['name']; ?></strong>
                <p><?php echo $comment['description']; ?></p>
            </div>

        </div>

    <?php }?>
    <br>
    <h4>Nieuw commentaar toevoegen</h4>

    <form action="" method="POST">
        <div class="col-md-4">
            <div class="form-group">
                <label for="name">Naam</label>
                <input type="text" name="name" class="form-control">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control">
            </div>
            <div class="form-group">
                <label for="subject">Onderwerp</label>
                <input type="text" name="subject" class="form-control">
            </div>
            <div class="form-group">
                <label for="description">Omschrijving</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" name="btnComment" class="btn btn-outline-success">Verstuur</button>
            </div>
        </div>

    </form>



</div>