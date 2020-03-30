<!DOCTYPE html>

<html lang="ja">

	<head>
		<meta charset="utf-8">
		<title>通報</title>
		
	</head>

	
	<body>
		<?php
			$key1=$_GET['key1'];/*key1受け取り*/

			if(!isset($_POST['key2'])){ /*key2の生存チェック*/
				echo "エラー keyがありません";
			}else{
				$key2=$_POST['key2'];/*key2受け取り*/
	 
				if(strcmp("$key1","$key2")==0){ /*keyの一致チェック*/
					
					$name=$_POST['name'];/*名前受け取り*/

					$filename=$_POST['file'];/*URL用ファイル名受け取り*/

					/*データベース接続*/
					$db = new mysqli('localhost','sdv2019a','HIbIbymQ2SAH','SDV2019A');
					if($db->connect_error) {
						echo $db->connect_error;
						exit ();
					}

					/*データベースに状態の書き換え*/
					$sql = 'UPDATE NoticeTable SET Status = 8 WHERE Web = "'.$filename.'"';/*ステータス書き換え*/
					$result = mysqli_query($db,$sql);

					/*データベース切断*/
					$db = mysqli_close($db);
					if(!$db){
						exit('データベースとの接続が閉じられませんでした。');
					}
		?>


		<div align="center">
			<p>
			<font size="6" align="left"><?php echo $name.'様' ?></font>
			</p>
				
			<p>
			<font size="6">外出情報を確認しました。</font>
			</p>
				
		</div>
	</body>

	<?php
				}
			}
	?>

</html>