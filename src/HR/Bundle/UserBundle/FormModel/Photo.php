<?php
namespace HR\Bundle\UserBundle\FormModel;

use HR\Bundle\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Gregwar\Image\Image;

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
        if (null === $this->getFile()) {
            return false;
        }

        $this->path = $this->getUser()->getId() . '.' . $this->getFile()->guessClientExtension();

        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->path
        );

        $this->avatarBigUrl   = $this->makeThumb(128, 128);
        $this->avatarSmallUrl = $this->makeThumb(48, 48, true);

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
        return __DIR__ . '/../../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'uploads/face/' . substr(md5($this->getUser()->getId()), 30);
    }

    protected function makeThumb($width, $height, $force = false)
    {
        if (null === $this->getFile() || null === $this->path) {
            return null;
        }

        $extension = $this->getFile()->guessClientExtension();
        $filename  = sprintf('%d%d.%s', $this->getUser()->getId(), $width, $extension);
        $method    = $force ? 'forceResize' : 'cropResize';

        Image::open($this->getUploadRootDir() . '/' . $this->path)
            ->$method($width, $height)
            ->save($this->getUploadRootDir() . '/' . $filename, $extension, 100);

        return $this->getUploadDir() . '/' . $filename . '?t=' . time();
    }
}