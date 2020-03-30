<!--アクセスページ-->
<!--このページをトリガー後にランダムな名前で生成  例 : ngV5LMVF9Mf4.php -->
<?php 
	$filename=basename(__FILE__,".php");/*ファイル名読み込み*/

	if(isset($_GET['key'])){ /*keyの生存チェック 介護士、家族からのアクセスかどうか判断*/
		$key=$_GET['key'];
	}else{
		$key=0;
	}

	/*データベース接続*/
	$db = new mysqli('localhost','sdv2019a','HIbIbymQ2SAH','SDV2019A');
	if($db->connect_error) {
		echo $db->connect_error;
		exit ();
	}
	/*レコード読み込み*/
	$sql = 'SELECT TakeTime, Name, TakePhoto,Photo, Status,Often FROM NoticeTable AS N ,HumanTable AS H WHERE N.ReceiverId = H.Id AND Web = "'.$filename.'"';
	$result = mysqli_query($db,$sql);
	while ($data = $result->fetch_assoc()){
	

	$uuid=md5(uniqid(rand(),1)); /*通報時のkey用ランダム文字列*/
	$status=$data['Status'];/*データベースからページの状態読込*/

	/*置き換え用関数ファイル読み込み*/
	require 'function.php';
	
	$param['string1'] = $data['Name']; /*データべースから名前を取り出し*/
	$param['string2'] = $data['TakeTime'];/*データベースから写真が撮られた時間を取り出し*/
	$param['string3'] = $data['TakePhoto']; /*画像名の保存場所を取り出し*/
	$param['string4'] = $uuid; /*通報時のkey用ランダム文字列*/
	$param['string5'] = $filename;/*市役所の方へのメール送信に使うURL用ファイル名*/
	$param['string6'] = $data['Often']; /*候補地*/
	$param['string7'] = $data['Photo']; /*顔写真*/
	}

	/*データベース切断*/
	$db = mysqli_close($db);
	if(!$db){
		exit('データベースとの接続が閉じられませんでした。');
	}

	/*介護士用ページ表示か市役所の方用ページ表示かの判断*/
	if($status==1&&$key==1){
		/*テンプレートエンジン実行＆テンプレートの表示*/
		echo desplay_template('template.html',$param); /*介護士用ページ*/
	}
	else if($status==2&&$key==1){
		echo desplay_template('template5.html',$param);/*通報後の介護士用ページ*/
	}
	else if($status==2&&$key==0){
		echo desplay_template('template2.html',$param);/*市役所の方用ページ*/
	}
	else if(($status==3&&$key==0)||($status==3&&$key==1)){
		echo desplay_template('template4.html',$param);/*情報開示用ページ*/
	}
	else if($status==8&&$key==0){
		echo desplay_template('template3.html',$param);/*確認済みページ*/
	}
	else if($status==8&&$key==1){
		echo desplay_template('template6.html',$param);/*介護者用確認済みページ*/
	}
?>