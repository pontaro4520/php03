<?php

//PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。
//2. $id = $_POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. header関数"Location"を「select.php」に変更

//1. POSTデータ取得
$date = $_POST['date'];
$material = $_POST['material'];
$form = $_POST['form'];
$thickness = $_POST['thickness'];
$size = $_POST['size'];
$price = $_POST['price'];
$id = $_POST['id'];


// // var_dumpを実行
// var_dump($date, $material, $form, $thickness, $size, $price, $id);
// // 処理を停止してvar_dumpの結果を確認する場合
// exit;

 //さくら
 $pdo = db_conn_prod();
 

// // ローカル
// try {
//   $db_name = 'kadai02_db';    //データベース名
//   $db_id   = 'root';      //アカウント名
//   $db_pw   = '';      //パスワード：MAMPは'root'
//   $db_host = 'localhost'; //DBホスト
//   $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
// } catch (PDOException $e) {
//   exit('DB Connection Error:' . $e->getMessage());
// }


//３．データ登録SQL作成
// 1. SQL文を用意
$stmt = $pdo->prepare('UPDATE
kadai02_table
SET date = :date,
    material = :material,
    form = :form,
    thickness = :thickness,
    size = :size,
    price = :price
WHERE id = :id;
');

//  2. バインド変数を用意
// Integer 数値の場合 PDO::PARAM_INT
// String文字列の場合 PDO::PARAM_STR

$stmt->bindValue(':date', $date, PDO::PARAM_STR);
$stmt->bindValue(':material', $material, PDO::PARAM_STR);
$stmt->bindValue(':form', $form, PDO::PARAM_STR);
$stmt->bindValue(':thickness', $thickness, PDO::PARAM_STR);
$stmt->bindValue(':size', $size, PDO::PARAM_STR);
$stmt->bindValue(':price', $price, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

//  3. 実行
$status = $stmt->execute();

//４．データ登録処理後
if ($status === false) {
  //*** function化する！******\
  $error = $stmt->errorInfo();
  exit('SQLError:' . print_r($error, true));
} else {
  //*** function化する！*****************
  header('Location: select.php');
  exit();
}