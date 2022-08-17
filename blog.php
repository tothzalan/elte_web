<?php
	$filtered = filter_input(INPUT_GET, 'name', FILTER_DEFAULT) ?? '';
	$post_name = htmlspecialchars($filtered);

	$file = [];
	if($post_name == '') {
		if($handle = opendir('posts/')) {
			while (($file_name = readdir($handle)) !== false) {
				if(strlen($file_name) > 2)
					array_push($file, $file_name);
			}
			closedir($handle);
		}
	} else { 
		if(file_exists("posts/$post_name")) {
			$file_contents = file_get_contents("posts/$post_name");
			$file = explode(PHP_EOL, $file_contents);
		}	
		else
			array_push($file, "Nincs ilyen fájl!");
	}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Tóth Zalán nagyon menő weboldala">
	<title>Tóth Zalán | Blog</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<h1>Blog</h1>
	<?php if($post_name == '') : ?>
	<p>Itt olvashatóak a posztjaim:</p>
	<ul>
		<?php if(count($file) > 0) : ?>
			<?php foreach($file as $post) : ?>
				<li><a href="blog?name=<?= $post ?>"><?= $post ?></a></li>
			<?php endforeach ?>
		<?php else : ?>
			<li>Nagy üresség :(</li>
		<?php endif ?>
	</ul>
	<a href="/">vissza</a>
	<?php else : ?>
		<?php foreach($file as $line) : ?>
			<p><?= $line ?></p>
		<?php endforeach ?>
	<a href="blog">vissza</a>
	<?php endif ?>
</body>
</html>
