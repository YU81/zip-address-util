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
        <form name="search_form" method="get" action="/address/result" class="col-lg-6 col-lg-offset-3 form-group">
            <input type="text" class="input-sm col-lg-6" name="search" title="search" id="search"
                   value=<?php
                   /** @var string $searchWord */
                   if (isset($searchWord)) {
                       echo $searchWord;
                   } ?>
            >
            <button class="btn btn-success col-lg-2 glyphicon-search">検索</button>
            <select name="max_count" id="max_count" class="form-control-static">
                <?php
                $maxCountList = [50, 100, 200, 500, 1000];
                foreach ($maxCountList as $val) {
                    /** @var int $maxCount */
                    if (isset($maxCount) && $val === $maxCount) {
                        echo '<option value="' . $val . '" selected>' . $val . '</option>';
                    } else {
                        echo '<option value="' . $val . '">' . $val . '</option>';
                    }
                }
                ?>
            </select>
        </form>
    </div>
    <div id="result" class="row">
        <?php
        /** @var int $count */
        if (@$count === 0) {
            echo 'マッチする検索結果はありませんでした。';
        } elseif (isset($results)) {
            echo '<span>' . $count . '件見つかりました。' . '</span>';
        ?>
        <table class="table table-bordered">
            <tr>
                <th>郵便番号</th>
                <th>都道府県</th>
                <th>市区町村</th>
                <th>住所表記</th>
                <th>住所表記フリガナ</th>
            </tr>
            <?php
            $output = '';
            if (isset($results)) {
                foreach ($results as $addr) {
                    /** @var App\Models\Address $addr */
                    $output .= '<tr>';
                    $output .= '<td>' . $addr->zip . '</td>'
                        . '<td><span>' . $addr->ken_name . '</span></td>'
                        . '<td><span>' . $addr->city_name . '</span></td>'
                        . '<td><span>' . $addr->getWholeAddress() . '</span></td>'
                        . '<td><span>' . $addr->getWholeAddressReading() . '</span></td>';
                    $output .= '</tr>';
                }
            }
            echo $output;
            ?>
        </table>
    </div>
</div>
<script src="/assets/js/jquery.min.js"></script>
</body>

</html>
