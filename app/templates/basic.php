<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?=$this->e($page_title)?></title>
    <link rel="stylesheet" href="/css/furtive.min.css">
    <link rel="stylesheet" href="/css/main.css">
</head>
<body class="grd fnt--dark-gray">
    <div class="grd-row my2">
        <?=$this->section('content')?>
    </div>


    <footer class="grd-row txt--center my2">
        <section class="grd-row-col-2-6--md px2"></section>
        <section class="grd-row-col-2-6--md px2">
            <a target="_blank" class="fnt--green" href="http://citracode.com">Powered by Citracode</a>
        </section>
    </footer>
</body>
</html>