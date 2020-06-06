<?php include('session.php'); ?>

<?php include ('header.php');?>
<?php include ('post.php');?>
<?php include ('tag.php');?>

<?php /*include ('functions/functions.php');*/?>


<?php

error_reporting(0);
$post = new Post($db);
$tags = new Tag($db);

if (isset($_POST['btnSubmit'])){

    $date = date('Y-m-d');

    if (!empty($_POST['title'])&&!empty($_POST['description'])){
        $title = strip_tags($_POST['title']);
        $description= $_POST['description'];
        $slug = createSlug($title);
        $checkSlug = mysqli_query($db,"SELECT * FROM posts WHERE slug='$slug'");
        $result = mysqli_num_rows($checkSlug);
        if($result>0){
            foreach($checkSlug as $cslug) {
                $newSlug = $slug . uniqid();
            }
                $record = $post->addPost($title, $description, uploadImage(),$date, $slug);

            }else{
                $record = $post->addPost($title, $description, uploadImage(), $date, $slug);
            }

        if ($record==true){
            echo "<div class='text-center alert alert-success'>Gelukt!</div>";
        } else{
            echo "<div class='text-center alert alert-danger'>Niet gelukt</div>";
        }
    }
}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="add.php" method="post" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">Bericht toevoegen</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Titel</label>
                            <input type="text" name="title" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="title">Beschrijving</label>
                            <textarea cols="10" id="editor" name="description" class="form-control" ></textarea>
                        </div>
                        <div class="form-group">
                            <label for="title">Afbeelding</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="form-group form-check-inline">
                            <label for="image"><b>Choose tags</b>&nbsp;&nbsp;</label>
                            <?php  foreach($tags->getAllTags() as $tag){ ?>
                                <input type="checkbox" name="tags[]" class="form-check-input" value="<?php echo $tag['id']?>"><?php echo $tag['tag'];  ?>&nbsp
                            <?php } ?>
                        </div>
                        <div class="form-group">
                           <button type="submit" name="btnSubmit" class="btn btn-primary">Verzenden</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
<style type="text/css">
    .card{
        margin-top: 10px;
    }
</style>
