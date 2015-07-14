<?php
require dirname(__DIR__) . '/bootstrap.php';

session_start();

if (!isset($_SESSION['loggedIn'])) {
    header('HTTP/1.1 302 Redirect');
    header('Location: /login.php');
    exit;
}

$manager = new \App\BookmarkManager($pdo);
$bookmarks = $manager->getBookmarks();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>Bookmarks</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <style>
            body{
                padding: 100px;
            }
            h1, h2, h3, p, .bookmark{
                margin: 0 0 20px 0;
            }
            .bookmark-image{
                border: 1px solid #CCC;
                vertical-align: top;
                width: 100%;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1 class="page-header">Bookmarks</h1>

            <?php if ($bookmarks): ?>
                <?php foreach ($bookmarks as $bookmark): ?>
                <div class="row bookmark">
                    <div class="col-md-3">
                        <img class="bookmark-image" src="<?php echo $bookmark['image']; ?>" alt="Thumbnail"/>
                    </div>

                    <div class="col-md-9">
                        <h2><a href="<?php echo $bookmark['url']; ?>"><?php echo $bookmark['title']; ?></a></h2>
                        <p>
                            <?php echo $bookmark['caption']; ?>
                        </p>
                        <p><small>Source: <?php echo $bookmark['url']; ?></small></p>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
            <p>You don't have any bookmarks yet.</p>
            <?php endif; ?>

            <p>
                <a href="/logout.php">Log Out</a>
            </p>
        </div>
    </body>
</html>