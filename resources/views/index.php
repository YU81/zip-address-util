<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Zip Address Util</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/bootstrap-theme.min.css">
</head>
<body>
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
    <div id="result" class="row">
        <?php
        /** @var int $count */
        if ($count === 0) {
            echo 'マッチする検索結果はありませんでした。';
        } elseif (isset($results)) {
            echo '<span>' . $count . '件見つかりました。' . '</span>';
            echo '<table class="table table-bordered">';
            echo '<th>郵便番号</th><th>住所表記</th>';
            foreach ($results as $addr) {
                /** @var App\Models\Address $addr */
                echo '<tr>';
                echo '<td>' . $addr->zip . '</td>' . '<td><span>' . $addr->getWholeAddress() . '</span></td>';
                echo '</tr>';
            }
            echo '</table>';
        } ?>
    </div>
</div>
<script src="/assets/js/jquery.min.js"></script>
</body>

</html>
