<?php 

	// Excelファイルをクライアントに出力 ----------------------------
	header("Content-disposition: attachment; filename={$filename}");
	header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; name={$filename}");

	$result = file_get_contents( $path );	// ダウンロードするデータの取得
	unlink($path);
	print( $result ); 						// 出力

