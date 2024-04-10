<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?=$this->e($page_title)?></title>
    <link rel="stylesheet" href="/css/furtive.min.css">
    <link rel="stylesheet" href="/css/main.css">
</head>
<body class="grd">
    <nav class="bg--off-white grd-row py1">
        <section class="fnt--orange grd-row-col-6 px2">
            <a class="flt--left" href="<?= SITE_URL ?>">Home</a>
            <a class="flt--right" href="<?= SITE_URL ?>login">Login</a>
        </section>
    </nav>
    <?php if(isset($messages) && is_array($messages) && count($messages) > 0): ?>
    <div class="grd-row my2"><div class="grd-row-col-6 txt--center">
        <?php foreach($messages as $m): ?>
            <message class="p1 m1  <?= $m['type'] == 'error' ? 'bg--red': 'bg--blue' ?>">
                <?= $m['value'] ?>
            </message>

        <?php endforeach;?>
    </div></div>

    <?php endif; ?>
    <div class="grd-row my2">
        <?=$this->section('content')?>
    </div>


    <footer class="grd-row txt--center my2">
        <section class="grd-row-col-2-6--md px2"></section>
        <section class="grd-row-col-2-6--md px2">
            <a target="_blank" class="fnt--orange" href="http://citracode.com">Powered by Citracode</a>
        </section>
    </footer>
</body>
</html>