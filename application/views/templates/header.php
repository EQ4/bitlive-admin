<html>
    <head>
        <link rel="stylesheet" href="<?php echo base_url('bootstrap/css/bootstrap.min.css');?>">
        <link rel="stylesheet" href="<?php echo css_url('custom.css'); ?>">
        <script src="<?php echo js_url('jquery-1.11.3.min.js'); ?>"></script>
        <script src="<?php echo base_url('bootstrap/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/zeroclipboard/ZeroClipboard.min.js'); ?>"></script>
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="https://www.bitcodin.com/" target="_blank">
                        <img alt="bitcodin" src="<?php echo img_url('bitcodin_small.png'); ?>">
                    </a>
                </div>
                <ul class="nav navbar-nav">
                    <?php foreach($menu_items as $menu_item): ?>
                        <li><a href="<?php echo base_url('index.php/'.strtolower($menu_item)); ?>"><?php echo $menu_item; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </nav>
        <div class="container">