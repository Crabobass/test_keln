<?php
/** @var $data */
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/style.css">
    <script src="/js/script.js"></script>
    <title>Guests</title>
</head>

<body>
<div class="app">
    <div class="wrapper">
        <form action="/guests/add" method="POST" id="form">
            <input type="text" name="name" placeholder="Имя">
            <input type="text" name="email" placeholder="Email">
            <textarea name="body" placeholder="Собщение"></textarea>
            <input type="submit" value="Отправить">
        </form>

        <div class="guestsList">
            <?php
            if (!empty($data['guests']) && is_array($data['guests'])):
                foreach ($data['guests'] as $ind => $guest):
                    if ($ind > 4) break;
                    ?>
                    <div class="guest">
                        <h1><?= $guest['name'] ?></h1>
                        <strong><?= $guest['email'] ?></strong>
                        <p><?= $guest['body'] ?></p>
                    </div>
                <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
</div>
</body>
</html>


