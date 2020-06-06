<?php
include ('db.php');
include ('functions/functions.php');
class Post{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function addPost($title, $description, $image, $date, $slug){
        $sql = "insert into posts (title, description, image, created_at, slug) values  ('$title', '$description','$image','$date','$slug')";
        $result = mysqli_query($this->db, $sql);

        if($result){
            if($_POST['tags']){
                $tags = $_POST['tags'];
                $lastInsertedId = mysqli_insert_id($this->db);
                foreach($tags as $tag){
                    $sql="INSERT INTO post_tags(post_id,tag_id)VALUES('$lastInsertedId', $tag)";
                    $result = mysqli_query($this->db,$sql);
                }
            }
        }
        return $result;
    }
    public function getPost(){

        if (isset($_GET['keyword'])){
            $keyword = $_GET['keyword'];
            return $this->search($keyword);
        }

        if(isset($_GET['tag'])){
            $tag = $_GET['tag'];
            $sql = "SELECT *
					FROM posts
					INNER JOIN post_tags ON posts.id = post_tags.post_id
					INNER JOIN tags ON tags.id = post_tags.tag_id
					WHERE tags.tag='$tag'";
            $result = mysqli_query($this->db,$sql);
            return $result;
        }

        $limit = 5;
        if(isset($_GET["page"])){
            $page = $_GET["page"];
        }else{
            $page =1;

        }
        $start = ($page-1)*$limit ;



        $sql = "select * from posts LIMIT $start, $limit ";
        $result = mysqli_query($this->db, $sql);
        return $result;
    }

    public function getSinglePost($slug){
        $sql = "SELECT * FROM posts WHERE slug= '$slug'";
        $result = mysqli_query($this->db,$sql);
        return $result;
    }

    public function updatePost($title,$description,$slug){
        $newImage = $_FILES['image']['name'];
        if(!empty($newImage)){
            $image = uploadImage();
            $sql = "UPDATE posts SET title ='$title',description='$description',image = '$image' WHERE slug = '$slug'";
            $result = mysqli_query($this->db,$sql);
            return $result;

        }else{
            $sql = "UPDATE posts SET title ='$title',description='$description' WHERE slug = '$slug'";
            $result = mysqli_query($this->db,$sql);
            return $result;
        }
    }

    public function search($keyword){
        $sql = "select * from posts where title like '%{$keyword}%' or description like '%{$keyword}%'";
        $result = mysqli_query($this->db,$sql);
        return $result;
    }

    public function deletePostBySlug($slug){
        $sql = "DELETE FROM posts WHERE slug='$slug'";
        $result = mysqli_query($this->db,$sql);
        return $result;
    }

    public function getPopularPosts(){
        $sql = "SELECT * from posts left join comments on posts.slug= 
            comments.slug group by 
            comments.slug order by count(comments.slug) desc limit 5";
        $result = mysqli_query($this->db, $sql);
        return $result;
    }
}