<?php
require dirname(__DIR__) . '/bootstrap.php';

// Start session
session_start();

// Process POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch submitted username and password
    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');

    // If username and password provided
    if ($username && $password) {
        // Find user record from database
        $stmt = $pdo->prepare('SELECT id, username, password FROM users WHERE username = :username');
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        $hit = $stmt->fetch(\PDO::FETCH_ASSOC);

        // If found and password hash is verified
        if ($hit && password_verify($password, $hit['password'])) {
            // Check if password needs re-hashed (e.g. if cost factor has changed)
            $needsRehash = password_needs_rehash(
                $hit['password'],
                PASSWORD_DEFAULT,
                ['cost' => $settings['costFactor']]
            );

            // Rehash password if necessary and update database record
            if ($needsRehash) {
                $newPasswordHash = password_hash(
                    $password,
                    PASSWORD_DEFAULT,
                    ['cost' => $settings['costFactor']]
                );
                $stmt = $pdo->prepare('UPDATE users SET password = :password WHERE id = :id');
                $stmt->bindValue(':password', $newPasswordHash);
                $stmt->bindValue(':id', $hit['id'], \PDO::PARAM_INT);
                $stmt->execute();
            }

            // Log in and redirect
            // NOTE: Do not store the user's primary key in the session
            // to reduce chance for sensitive data exposure. You should still
            // store something unique to the user... just not the primary key.
            $_SESSION['loggedIn'] = $hit['username'];
            header('HTTP/1.1 302 Redirect');
            header('Location: /index.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>User Login</title>
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
            <h1 class="page-header">User Login</h1>

            <form action="/login.php" method="post">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" name="username" value="" required/>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" value="" required/>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-lg btn-primary" value="Sign In"/>
                </div>
            </form>
        </div>
    </body>
</html>