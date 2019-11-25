<?php 
//CSVファイルの""を除く
	#csvファイルをオープン


	$fp = fopen($uploadDir.$filename,"r");
	$contents = "";
	#fgetcsv関数がfalseを返却するまで実行
	while($data = fgets($fp)){
	$contents .= str_replace("\"","",$data);
	}
	fclose($fp);
	
		$fp = fopen($uploadDir.$filename,"w");
	
	fwrite($fp, $contents);

fclose($fp);

	// CSVファイルをクライアントに出力 ----------------------------


	Configure::write('debug', 0); 		// debugコードを非表示

	header("Content-disposition: attachment; filename={$filename}");
	header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; name={$filename}");

$result = mb_convert_encoding(file_get_contents($uploadDir.$filename), 'sjis-win','utf-8' );	// ダウンロードするデータの取得
	print( $result ); 						// 出力

