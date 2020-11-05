<?php

namespace Source\Support;

use CoffeeCode\Uploader\File;
use CoffeeCode\Uploader\Image;
use CoffeeCode\Uploader\Media;

/**
 * JSON-PHP | Class Upload
 *
 * @author Euclides Bernardo <euclidesquissembebernado@gmail.com>
 * @package Source\Support
 */
class Upload
{
    /** @var Message */
    private $message;

    /**
     * Upload constructor.
     */
    public function __construct()
    {
        $this->message = new Message();
    }

    /**
     * @return Message
     */
    public function message(): Message
    {
        return $this->message;
    }

    /**
     * @param array $image
     * @param string $name
     * @param string $pathToUpload
     * @param int $width
     * @return null|string
     * @throws \Exception
     */
    public function image(array $image, string $name, string $pathToUpload, int $width = CONF_IMAGE_SIZE): ?string
    {
        $upload = new Image(
            CONF_UPLOAD_DIR,
            CONF_UPLOAD_IMAGE_DIR . "/" . ($pathToUpload[0] === '/' ? substr($pathToUpload, 1) : $pathToUpload)
        );
        if (empty($image['type']) || !in_array($image['type'], $upload::isAllowed())) {
            $this->message->error("Você não selecionou uma imagem válida");
            return null;
        }

        return str_replace(CONF_UPLOAD_DIR . "/", "", $upload->upload($image, $name, $width, CONF_IMAGE_QUALITY));
    }

    /**
     * @param array $file
     * @param string $name
     * @return null|string
     * @throws \Exception
     */
    public function file(array $file, string $name): ?string
    {
        $upload = new File(CONF_UPLOAD_DIR, CONF_UPLOAD_FILE_DIR);
        if (empty($file['type']) || !in_array($file['type'], $upload::isAllowed())) {
            $this->message->error("Você não selecionou um arquivo válido");
            return null;
        }

        return str_replace(CONF_UPLOAD_DIR . "/", "", $upload->upload($file, $name));
    }

    /**
     * @param array $media
     * @param string $name
     * @return null|string
     * @throws \Exception
     */
    public function media(array $media, string $name): ?string
    {
        $upload = new Media(CONF_UPLOAD_DIR, CONF_UPLOAD_MEDIA_DIR);
        if (empty($media['type']) || !in_array($media['type'], $upload::isAllowed())) {
            $this->message->error("Você não selecionou uma mídia válida");
            return null;
        }

        return str_replace(CONF_UPLOAD_DIR . "/", "", $upload->upload($media, $name));
    }

    /**
     * @param string $filePath
     */
    public function remove(string $filePath): void
    {
        if (file_exists($filePath) && is_file($filePath)) {
            unlink($filePath);
        }
    }
}
