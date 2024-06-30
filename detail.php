<?php

require_once ('funcs.php');

/**
 * [ここでやりたいこと]
 * 1. クエリパラメータの確認 = GETで取得している内容を確認する
 * 2. select.phpのPHP<?php ?>の中身をコピー、貼り付け
 * 3. SQL部分にwhereを追加
 * 4. データ取得の箇所を修正。
 */

 $id = $_GET['id'];

//  // var_dumpを実行
// var_dump($id);
// // 処理を停止してvar_dumpの結果を確認する場合
// exit;



 require_once ('funcs.php');

 //さくら
 $pdo = db_conn_prod();
 
// // ローカル
// $pdo = db_conn();
 
 
 //２．データ取得SQL作成
 $stmt = $pdo->prepare("SELECT * FROM kadai02_table WHERE id = :id;");
 $stmt -> bindValue(':id',$id, PDO::PARAM_INT);
 $status = $stmt->execute();
 
 //３．データ表示
//３．データ表示
$view = '';
if ($status === false) {
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {

    $result = $stmt->fetch();

}

?>
<!--
２．HTML
以下にindex.phpのHTMLをまるっと貼り付ける！
(入力項目は「登録/更新」はほぼ同じになるから)
※form要素 input type="hidden" name="id" を１項目追加（非表示項目）
※form要素 action="update.php"に変更
※input要素 value="ここに変数埋め込み"
-->

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>鋼材価格見積集積</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>

<body>

    <!-- Main[Start] -->
    <form method="post" action="update.php" id="priceData" onsubmit="return validateForm()">
        <div class="jumbotron">
            <fieldset>
                <legend>鋼材価格見積集積アプリ</legend>
                <label>見積取得日 <input type="date" name="date"value="<?= $result['date'] ?>"></label><br>
                <label>鋼種：
                <input type="radio" name="material" value="st" <?= $result['material'] == 'st' ? 'checked' : '' ?>>鉄
                <input type="radio" name="material" value="sus" <?= $result['material'] == 'sus' ? 'checked' : '' ?>>ステンレス
                <input type="radio" name="material" value="al" <?= $result['material'] == 'al' ? 'checked' : '' ?>>アルミ
                 </label><br>
                <label>材種：
                    <input type="radio" name="form" value="sheetMetal" <?= $result['form'] == 'sheetMetal' ? 'checked' : '' ?>>板
                    <input type="radio" name="form" value="flatBar" <?= $result['form'] == 'flatBar' ? 'checked' : '' ?>>フラットバー
                    <input type="radio" name="form" value="squarePipe" <?= $result['form'] == 'squarePipe' ? 'checked' : '' ?>>角パイプ
                    <input type="radio" name="form" value="roundPipe" <?= $result['form'] == 'roundPipe' ? 'checked' : '' ?>>丸パイプ
                    <input type="radio" name="form" value="others" <?= $result['form'] == 'others' ? 'checked' : '' ?>>その他
                </label><br>

                <label> 板厚：<input type="text" name="thickness" value="<?= $result['thickness'] ?>"> t </label><br>
                <label> サイズ：<input type="text" name="size" value="<?= $result['size'] ?>"></label><br>
                <label> 金額：<input type="text" name="price" value="<?= $result['price'] ?>">円 </label><br>
                <input type="hidden" name="id" value="<?= $result['id'] ?>">
                <input type="submit" value="送信">
            </fieldset>
        </div>
    </form>

    <!-- Main[End] -->

        <!-- Foot[Start] -->
        <footer>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand" href="select.php">集積結果一覧
                </a></div>
            </div>
        </nav>
    </footer>
    <!-- foot[End] -->


    <footer>
            <p>presented by 金子軽窓工業</p>
        </footer>


    <script>
        function validateForm() {
            let priceData = document.getElementById("priceData");
            let date = priceData.elements["date"].value;
            let material = priceData.elements["material"].value;
            let form = priceData.elements["form"].value;
            let thickness = priceData.elements["thickness"].value;
            let size = priceData.elements["size"].value;
            let price = priceData.elements["price"].value;

            if (date == "") {
                alert("見積取得日を入力してください");
                return false;
            }

            if (material == "") {
                alert("鋼種を選択してください");
                return false;
            }

            if (form == "") {
                alert("材種を選択してください");
                return false;
            }

            if (thickness == "") {
                alert("板厚を入力してください");
                return false;
            }

            if (size == "") {
                alert("サイズを入力してください");
                return false;
            }

            if (price == "") {
                alert("金額を入力してください");
                return false;
            }

            return true;
            }
        </script>


</body>

</html>
