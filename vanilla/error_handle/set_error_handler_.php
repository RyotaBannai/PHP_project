<?php
// もしファイルがpostされていれば...
if(isset($_FILES['file'])){
    var_export($_FILES['file']);
    // tmp_name	: サーバで保存した画像のフルパス
    $serser_filename = $_FILES['file']['tmp_name'];
    $exif = read_image_metadata($serser_filename);

    // もしアップされたファイルがjpegであれば...
    if ($exif != false) {
        $tmp_file_name = 'test.jpg';
        move_uploaded_file($serser_filename, './img/' . $tmp_file_name); // 保存
        // echo $_SERVER['DOCUMENT_ROOT'];
        //echo '<img src="'.__DIR__.'/img/'.$tmp_file_name.'"　width="100" height="100" />';
        echo '<img src="./img/' . $tmp_file_name . '"　width="50" height="50" />'; // 相対パスじゃないと表示してくれない.

        //ネットで拾ったjpgに大した情報入って無い.
        // https://www.macs.hw.ac.uk/~hwloidl/docs/PHP/function.exif-read-data.html
        // https://hp.vector.co.jp/authors/VA032610/JPEGFormat/AboutExif.htm
        foreach ($exif as $k => $section) {
            var_dump($k);
            var_dump($section);
        }
    }
}
function read_image_metadata(string $filename)
    /*
     *
     * */
{
    # exif_imagetype: ファイル形式によって特定の数値を返す.
    # https://www.php.net/manual/en/function.exif-imagetype.php

    // exif_imagetype で画像以外のファイルを渡したり、
    // exif_read_data でjpegじゃないファイルを渡すとエラーになったり...
    function on_error($severity, $message) {
        throw new \RuntimeException($message);
        // throw new \RuntimeException(error_get_last()['message']);
    };
    set_error_handler('on_error');

    try{
        $type = exif_imagetype($filename);
        if ($type !== IMAGETYPE_JPEG){
            return [];
        }
        # exif_read_data — Reads the EXIF headers from an image file
        return exif_read_data($filename);
    } finally{
        restore_error_handler();
        // set_error_handlerはスタッカブルであるため，
        // リストアするとちゃんと直前に設定されていたエラーハンドラに戻してくれる
    }

}

# CLIで実行した場合に読み込まれるようにする。python の __name__ == __main__ のような物.
#if (!count(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS)))
#{
#    echo 'sayhi';
#}

?>
<form action="set_error_handler_.php" method="post" enctype="multipart/form-data" style="border: 2px black;
    border-style: ridge;display: block;">
    <input type="file" name="file" size="30">
    <input type="submit" value="[Button] upload file.">
</form>
