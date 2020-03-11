<?php include('session.php'); ?>

<?php include('header.php'); ?>
<?php include('post.php'); ?>
<?php
$post = new Post($db);

?>

<div class="container">
	<h2>Alle berichten</h2>
	<a href="view_comment.php" style="float:right;">Commentaar</a>
	
	<?php
		if(!empty($_SESSION['username'])){
			echo "Hallo, {$_SESSION['username']}";
		}else{
			echo"You're not logged in!";
		}
	?>

	</h2>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Titel</th>
				<th>Omschrijving</th>
				<th>Gemaakt</th>
				<th>Actie</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($post->getPost() as $post){ ?>
			<tr>
				<td><?php echo $post['title']; ?></td>
				<td><?php echo substr($post['description'],0,20); ?></td>
				<td><?php echo date('Y-m-d',strtotime($post['created_at'])); ?></td>
				<td>
					<a href="view.php?slug=<?php echo $post['slug'];?>"><button type="submit" class="btn btn-outline-success btn-sm">View</button></a>
					<a href="edit.php?slug=<?php echo $post['slug'];?>"><button type="submit" class="btn btn-outline-primary btn-sm">Edit</button></a>
					<a href="delete.php?slug=<?php echo $post['slug'];?>"><button type="submit" class="btn btn-outline-danger btn-sm">Delete</button></a>
				</td>
			<?php }?>
			</tr>
		</tbody>
	</table>
</div>