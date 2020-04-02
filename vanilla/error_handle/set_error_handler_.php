<?php
if(isset($_FILES['file'])){
    var_export($_FILES['file']);

    // tmp_name	: サーバで保存した画像のフルパス
    # exif_imagetypeファイル形式によって特定の数値を返す.
    # https://www.php.net/manual/en/function.exif-imagetype.php

    $filename = $_FILES['file']['tmp_name'];
    // echo exif_imagetype($filename);
    read_image_metadata($filename);

    // 保存したいときは.
    // move_uploaded_file($_FILES['file']['tmp_name'], './img/test.jpg');
}
function read_image_metadata(string $filename)
    /*
     *
     * */
{
    if(false === $type = exif_imagetype($filename)){
        throw new \RuntimeException(error_get_last()['message']);
    }
    if ($type !== IMAGETYPE_PNG){
        return [];
    }
    # exif_read_data — Reads the EXIF headers from an image file
    if(false === $data = exif_read_data($filename)){
    #    throw new \RuntimeException(error_get_last()['message']);
        echo 'false?';
    }
    //return $data;
}

# CLIで実行した場合に読み込まれるようにする。python の __name__ == __main__ のような物.
#if (!count(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS)))
#{
#    echo 'sayhi';
#}

?>
<form action="set_error_handler_.php" method="post" enctype="multipart/form-data">
    <input type="file" name="file" size="30">
    <input type="submit" value="[Button] upload file.">
</form>
