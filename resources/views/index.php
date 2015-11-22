<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Zip Address Util</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/bootstrap-theme.min.css">
</head>
<body>
<div id="result">
    <?php if (isset($results)) {
        foreach ($results as $addr) {
            /** @var App\Models\Address $addr */
            echo '<div><span>' . $addr->getWholeAddress() . '</span></div>';
        }
    } ?>
<div class="container">
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <h1>Zip Address Util</h1>
        </div>
    </div>
    <div class="row">
        <form name="search_form" method="get" action="/address/result" class="col-lg-6 col-lg-offset-3">
            <input type="text" class="input-sm col-lg-6" name="search" title="search" id="search"
                   value=<?php
                   /** @var string $searchWord */
                   if (isset($searchWord)) {
                       echo $searchWord;
                   } ?>
            >
            <button class="btn btn-success col-lg-2 glyphicon-search">検索</button>
        </form>
    </div>
</div>
<script src="/assets/js/jquery.min.js"></script>
</body>
</html>
