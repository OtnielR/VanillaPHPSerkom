<?php

class FileUtils
{
    private function __construct()
    {
        throw new \Exception('Not implemented');
    }

    public static function storeImage(string $file): array
    {
        if (isset($_FILES[$file]) && $_FILES[$file]["error"] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES[$file]["tmp_name"];
            $fileName = $_FILES[$file]["name"];
            $fileSize = $_FILES[$file]["size"];
            $fileType = $_FILES[$file]["type"];

            $fileExtension = strtolower(explode(".", $fileName)[1]);
            $allowedExtensions = ["jpeg", "jpg", "png", "webp"];

            if (!in_array($fileExtension, $allowedExtensions)) {
                $error = "Only JPG, JPEG, PNG, and WEBP are allowed";
                return ["status" => false, "message" => $error];
            }
            if ($fileSize > 2 * 1024 * 1024) {
                $error = "File size exceeds the 2MB limit.";
                return ["status" => false, "message" => $error];
            }

            $newFileName = uniqid("img_", true) . "." . $fileExtension;

            $uploadDirectory = __BASEPATH__ . "/public/uploads/";
            $fileRelativePath = "/public/uploads/" . $newFileName;

            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }

            $destination = $uploadDirectory . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destination)) {

                $relativePath = "uploads/" . $newFileName;
            }


            return ["status" => true, "message" => "File uploaded successfully", "path" => $fileRelativePath];
        }

        return ["status" => false, "message" => "File Null"];
    }
}
