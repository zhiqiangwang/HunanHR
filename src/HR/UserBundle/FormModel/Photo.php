<?php
namespace HR\UserBundle\FormModel;

use HR\UserBundle\Model\UserInterface;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class Photo
{
    private $file;

    private $path;

    private $user;

    private $avatarSmallUrl;

    private $avatarBigUrl;

    /**
     * @param UploadedFile $file
     *
     * @return $this
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param UserInterface $user
     *
     * @return $this
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getAvatarBigUrl()
    {
        return $this->avatarBigUrl;
    }

    /**
     * @return string
     */
    public function getAvatarSmallUrl()
    {
        return $this->avatarSmallUrl;
    }

    public function handleFile()
    {
        if (null === $this->getFile() || null == $this->getUser()) {
            return false;
        }

        $this->path = $this->getUser()->getId() . '.' . $this->getFile()->guessClientExtension();

        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->path
        );

        $this->avatarBigUrl   = $this->makeThumbnail(128, 128);
        $this->avatarSmallUrl = $this->makeThumbnail(48, 48);

        @unlink($this->getAbsolutePath());

        $this->file = null;

        return true;
    }

    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir() . '/' . $this->path;
    }

    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'uploads/face/' . substr(md5($this->getUser()->getId()), 30);
    }

    protected function makeThumbnail($width, $height)
    {
        if (null === $this->getFile() || null === $this->path) {
            return null;
        }

        $thumbnailFilename = sprintf('%d%d.png', $this->getUser()->getId(), $width);
        $imagine           = new Imagine();

        $imagine
            ->open($this->getAbsolutePath())
            ->thumbnail(new Box($width, $height), ImageInterface::THUMBNAIL_OUTBOUND)
            ->save($this->getUploadRootDir() . '/' . $thumbnailFilename);

        return $this->getUploadDir() . '/' . $thumbnailFilename . '?t=' . time();
    }
}