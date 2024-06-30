<?php

require_once ('funcs.php');

$material = isset($_GET['material']) ? $_GET['material'] : '';
$form = isset($_GET['form']) ? $_GET['form'] : '';

// var_dump($material);
// exit;

 //さくら
 $pdo = db_conn_prod();
 
// // ローカル
// $pdo = db_conn();

//２．データ取得SQL作成
$sql = "SELECT * FROM kadai02_table WHERE 1=1";
$params = array();

if ($material !== '') {
    $sql .= " AND material = :material";
    $params[':material'] = $material;
}

if ($form !== '') {
    $sql .= " AND form = :form";
    $params[':form'] = $form;
}

$sql .= " ORDER BY date ASC, id ASC";

$stmt = $pdo->prepare($sql);
foreach ($params as $key => $val) {
    $stmt->bindValue($key, $val, PDO::PARAM_STR);
}

// SQLの実行
$status = $stmt->execute();


//３．データ表示
$view = "";
if ($status == false) {
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit("ErrorQuery:".$error[2]);

} else {
    //Selectデータの数だけ自動でループしてくれる
    //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $view .= '<p>';
        $view .= '<a href="detail.php?id='.$result["id"].'">';
        $view .= h($result['date']. 
        '/' . $result['material'] . 
        '/' . $result['form'] .
        '/' . $result['thickness'] .
        '/' . $result['size'] .
        '/' . $result['price']);
        $view .= '</a>';

        $view .= '<a href="delete.php?id=' . $result['id'] . '">';
        $view .= '[ 削除 ]';
        $view .= '</a>';

        $view .= '</p>';
    }
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>見積集積結果一覧</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">


<!-- Main[Start] -->
<legend>見積もり結果表示</legend>
<div>
    <div class="container jumbotron"><?= $view ?></div>
</div>
<!-- Main[End] -->

<!-- foot[Start] -->
 
<footer>    
  <div class="container-fluid">
    <div class="row mb-3">
      <div class="col-12">
        <nav class="nav nav-pills nav-justified">

          <a class="btn btn-primary <?= $material === 'st' ? 'active' : '' ?>" href="select.php?material=st">鉄</a>
          <a class="btn btn-primary <?= $material === 'sus' ? 'active' : '' ?>" href="select.php?material=sus">ステンレス</a>
          <a class="btn btn-primary <?= $material === 'al' ? 'active' : '' ?>" href="select.php?material=al">アルミ</a>
          <a class="btn btn-primary <?= $material === '' ? 'active' : '' ?>" href="select.php">すべて</a>
        </nav>
      </div>
    </div>
    <div class="row mb-3">
      <div class="col-12">
        <nav class="nav nav-pills nav-justified">
         
          <a class="btn btn-secondary <?= $form === 'sheetMetal' ? 'active' : '' ?>" href="select.php?form=sheetMetal<?= $material ? "&material=$material" : '' ?>">板</a>
          <a class="btn btn-secondary <?= $form === 'flatBar' ? 'active' : '' ?>" href="select.php?form=flatBar<?= $material ? "&material=$material" : '' ?>">フラットバー</a>
          <a class="btn btn-secondary <?= $form === 'squarePipe' ? 'active' : '' ?>" href="select.php?form=squarePipe<?= $material ? "&material=$material" : '' ?>">角パイプ</a>
          <a class="btn btn-secondary <?= $form === 'roundPipe' ? 'active' : '' ?>" href="select.php?form=roundPipe<?= $material ? "&material=$material" : '' ?>">丸パイプ</a>
          <a class="btn btn-secondary <?= $form === 'others' ? 'active' : '' ?>" href="select.php?form=others<?= $material ? "&material=$material" : '' ?>">その他</a>          
          <a class="btn btn-secondary <?= $form === '' ? 'active' : '' ?>" href="select.php<?= $material ? "?material=$material" : '' ?>">すべて</a>
        </nav>
      </div>
    </div>
    <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">データ登録に戻る</a>
      </div>
    </div>
  </nav>
</footer>
<!-- foot[End] -->

</body>
</html>
