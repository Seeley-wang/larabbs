<?php

namespace App\Handlers;
use Image;

/**
 *
 */
class ImageUploadHandler
{

    protected $allowed_ext = ['png', 'jpg', 'gif', 'jpeg'];

    /**
     * @param $file
     * @param $folder
     * @param $pre_fix
     * @param $max_width
     * @return array|bool
     */
    public function save($file, $folder, $pre_fix, $max_width)
    {

        // 获取文件扩展名
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'jpg';


        // 如果上传的不是图片将终止操作
        if (!in_array($extension, $this->allowed_ext)) {
            return false;
        }

        // 文件目录

        $folder_name = "uploads/images/$folder/" . date('Y/m', time());

        // 上传路径

        $upload_path = public_path() . '/' . $folder_name;


        $filename = $pre_fix . '_' . time() . '_' . str_random(10) . '.' . $extension;

        // 将图片移动到我们的目标存储路径中

        $file->move($upload_path, $filename);

        if ($max_width && $extension != 'gif') {
            $this->reduceSize($upload_path . '/' . $filename, $max_width);
        }
        return [
            'path' => config('app.url') . "/$folder_name/$filename"
        ];

    }   

    /**
     * @param $file_path
     * @param $max_width
     */
    public function reduceSize($file_path, $max_width)
    {
        // 先实例化，传参是文件的磁盘物理路径
        $image = Image::make($file_path);

        // 进行大小调整的操作
        $image->resize($max_width, null, function ($constraint) {

            // 设定宽度是 $max_width，高度等比例双方缩放
            $constraint->aspectRatio();

            // 防止裁图时图片尺寸变大
            $constraint->upsize();
        });

        // 对图片修改后进行保存
        $image->save();
    }
}