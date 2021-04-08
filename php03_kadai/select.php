<?php

require_once('funcs.php');


//1.  DB接続します
$pdo = db_conn();

//２．データ取得SQL作成
$stmt = $pdo->prepare("SELECT*FROM gs_bm_table");
$status = $stmt->execute();

//３．データ表示
$view = "";
if ($status == false) {
    //execute（SQL実行時にエラーがある場合）
    sql_error($stmt);
    // $error = $stmt->errorInfo();
    // exit('ErrorQuery:' . print_r($error, true));
}else{
    //Selectデータの数だけ自動でループしてくれる
    //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
    while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $link = '<a href='.$result['url'].'>amazonリンク</a>';
        $cover = '<img src="https://iss.ndl.go.jp/thumbnail/'.$result['isbn'].'" alt="表紙画像ナシ"/>';
        $update = '<a href=bm_update_view.php?id='.$result['id'].'>更新修正</a>';
        $delete = '<a href=bm_delete.php?id='. $result['id'].'>削除</a>';

        $view .='<p>'.
                h($result['indate']) .'<br>'.
                h($result['title']).'  '.$link.'<br>'.
                $cover.'<br>'.
                h($result['comment']).'<br>'.
                $update.'　　　'.
                $delete.'<br>'.
                '</p>';
    }//おまじない .=は追加ってこと　＋＝と同じやね


}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>フリーアンケート表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
    <nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
        <a class="navbar-brand" href="index.php">データ登録</a>
        </div>
    </div>
    </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div class="container jumbotron"><?= $view ?></div>
</div>

<a href="index.php">登録画面へ</a>
<!-- Main[End] -->

</body>


<style>
img{
    height:100px;
}


</style>
</html>
