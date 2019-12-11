<?php 
	// CSVファイルをクライアントに出力 ----------------------------
	header('Content-Type: text/csv');
	header("Content-Disposition: attachment; filename={$filename}");

	$result = file_get_contents( $path );	// ダウンロードするデータの取得
	unlink($path);
	print( $result ); 						// 出力

