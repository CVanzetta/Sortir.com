<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AvatarService
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function add(UploadedFile $picture, $width = 200, $height = 200): string
    {
        $fichier = md5(uniqid(rand(), true)). '.webp';

        $picture_infos = getimagesize($picture);

        if($picture_infos === false){
            throw new \Exception('Format d\'image incorrect');
        }

        switch($picture_infos['mime']){
            case 'image\png':
                $picture_source = imagecreatefrompng($picture);
                break;
            case 'image\jpeg' or 'image\jpg':
                $picture_source = imagecreatefromjpeg($picture);
                break;
            case 'image\webp':
                $picture_source = imagecreatefromwebp($picture);
                break;
            default:
                throw new \Exception('Format d\'image incorrect');
        }

        $imageWidth = $picture_infos[0];
        $imageHeight = $picture_infos[1];
        //Orientation Image
        switch($imageWidth <=> $imageHeight){
            case -1:
                $squareSize = $imageWidth;
                $src_x = 0;
                $src_y = ($imageHeight - $squareSize) / 2;
                break;
            case 0:
                $squareSize = $imageWidth;
                $src_x = 0;
                $src_y = 0;
                break;
            case 1:
                $squareSize = $imageHeight;
                $src_x = ($imageWidth - $squareSize) / 2;
                $src_y = 0;
                break;
        }
        //Image vierge
        $resized_picture = imagecreatetruecolor($width, $height);

        imagecopyresampled($resized_picture, $picture_source, 0, 0, $src_x, $src_y, $width, $height, $squareSize, $squareSize);

        $path = $this->params->get('images_directory');

        imagewebp($resized_picture, $path . $fichier);

        $picture->move($path, $fichier);

        return $fichier;
    }

    public function delete(string $fichier): bool
    {
        if($fichier !== 'default.webp'){
            $success = false;
            $path = $this->params->get('images_directory');
            $avatar = $path . '/' . $fichier;

            if(file_exists($avatar)){
                unlink($avatar);
                $success = true;
            }
            return $success;
        }
        return false;
    }

}