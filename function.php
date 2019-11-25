<!--テンプレート出力関数-->
<?php
	/*テンプレート表示関数*/
	function desplay_template($tplfile,$param){
		/*テンプレートファイルの読み込み*/
		$html = file_get_contents($tplfile);
		
		$pattern = array('/_%string1%_/','/_%string2%_/','/_%string3%_/');
		
		
		$replacement = array($param['string1'],$param['string2'],$param['string3']);
		
		
		$html = preg_replace($pattern,$replacement,$html);
		
		return $html;
	}
?>
