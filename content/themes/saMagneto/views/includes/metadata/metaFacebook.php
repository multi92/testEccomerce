<meta property="og:url"          content="http://www.gocrvenikrst.rs/news/<?php echo $command[1]; ?>" />
<meta property="og:type"         content="website" />
<?php $title = 'GO Crveni Krst'; if(isset($news['main']->title)) $title = $news['main']->title;   ?>
<meta property="og:title"        content="<?php echo $title; ?>" />
<?php $desc = 'Gradska opština'; if(isset($news['main']->shortnews)) $desc = $news['main']->shortnews;   ?>
<meta property="og:description"  content="<?php echo $desc; ?>" />
<?php $img = 'views/theme/img/logo.png'; if(isset($news['main']->thumb)) $img = $news['main']->thumb;  ?>    
<meta property="og:image" 		 content="http://www.gocrvenikrst.rs/<?php echo $img; ?>" />