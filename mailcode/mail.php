<!--メール送信-->
<!--メールアドレス読み込みのデータベース追加-->
<?php

	$filename=$argv[1];/*URL用のファイル名受け取り*/

	/*データベース接続*/
	$db = new mysqli('localhost','sdv2019a','HIbIbymQ2SAH','SDV2019A');
	if($db->connect_error) {
		echo $db->connect_error;
		exit ();
	}

	/*レコード読み込み*/
	$sql = 'SELECT Mail FROM NoticeTable AS N,HumanTable AS H, RWTable AS R WHERE N.ReceiverId = R.ReceiverId AND R.WatcherId = H.Id AND N.Web = "'.$filename.'" AND Mail != ""'; /*対象の介護士のメールアドレス読み込み*/
	$result = mysqli_query($db,$sql);
	$i=1;/*何通遅れたかの確認用*/
	while ($data = $result->fetch_assoc()){
	
		
		/*アドレス読み込み*/
		$to=array_shift($data);/*取得したメールアドレス*/
		$subject = "外出通知"; /*件名*/
		$message = "外出がありました。以下のURLから情報を確認してください.\n http://www.ngw.net.it-chiba.ac.jp:19180/2019a/php/$filename.php?key=1"; /*内容*/
		$headers = "From: testsal"; /*差出人*/
	
		if (mb_send_mail($to,$subject,$message,$headers)){
			echo $i.'送信成功\n';
		} else {
    		echo $i.'送信失敗\n';
		}
		$i=$i+1;
	}
	/*データベース切断*/
	$db = mysqli_close($db);
	if(!$db){
		exit('データベースとの接続が閉じられませんでした。');
	}

?>