<!--アクセスページ-->
<!--このページをトリガー後にランダムな名前で生成したい  例 : ngV5LMVF9Mf4.php -->
<?php 
	$db = new mysqli('localhost','root','','sal');
	if($db->connect_error) {
		echo $db->connect_error;
		exit ();
	}
	
	$sql = 'SELECT * FROM table_sal';
	$result = mysqli_query($db,$sql);
	while ($data = $result->fetch_assoc()){
		/*echo '<p>'.$data['time'].':'.$data['name'].':'.$data['image']."</p>\n";*/
		
	
?>

<?php
/*置き換え用関数読み込み*/
require 'function.php';


/*$a = strval($result)*/
$param['string1'] = $data['name']; /*データべースから名前を取り出したい*/
$param['string2'] = $data['time'];/*データベースから写真が撮られた時間を取り出したい*/
$param['string3'] = $data['image']; /*このファイル名に使われたランダム文字列を画像名にし、それを読み込む　例　: ngV5LMVF9Mf4.png*/
	}
/*テンプレートエンジン実行＆テンプレートの表示*/
echo desplay_template('template.html',$param);

$db = mysqli_close($db);
	if(!$db){
		exit('データベースとの接続が閉じられませんでした。');
	}
?>
