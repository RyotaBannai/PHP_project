<?php
if(isset($_FILES['file'])){
    var_export($_FILES['file']);
    // tmp_name	: サーバで保存した画像のフルパス

    $serser_filename = $_FILES['file']['tmp_name'];
    // echo exif_imagetype($filename);
    $result = read_image_metadata($serser_filename);
    if ($result != false){
        $tmp_file_name = 'test.jpg';
        // echo $_SERVER['DOCUMENT_ROOT'];
        move_uploaded_file($serser_filename, './img/'.$tmp_file_name); // 保存
        //echo '<img src="'.__DIR__.'/img/'.$tmp_file_name.'"　width="100" height="100" />';
        echo '<img src="./img/'.$tmp_file_name.'"　width="50" height="50" />'; // 相対パスじゃないと表示してくれない.
    }

}
function read_image_metadata(string $filename)
    /*
     *
     * */
{
    # exif_imagetype: ファイル形式によって特定の数値を返す.
    # https://www.php.net/manual/en/function.exif-imagetype.php
    if(false === $type = exif_imagetype($filename)){
        throw new \RuntimeException(error_get_last()['message']);
    }
    if ($type !== IMAGETYPE_JPEG){
        return [];
    }
    # exif_read_data — Reads the EXIF headers from an image file
    if(false === $data = exif_read_data($filename)){
        throw new \RuntimeException(error_get_last()['message']);
    }
    return $data;
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
