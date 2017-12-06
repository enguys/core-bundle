<?php

namespace Enguys\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Enguys\CoreBundle\Entity\Traits\TimestampTrait;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity()
 * @Vich\Uploadable()
 */
class Media
{
    use TimestampTrait;

    /**
     * @var string
     *
     * @ORM\Id()
     * @ORM\Column(type="string", length=36)
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var File
     *
     * @Assert\File()
     *
     * @Vich\UploadableField(
     *     fileNameProperty="fileName",
     *     originalName="originalName",
     *     mimeType="mimeType",
     *     size="size",
     *     mapping="enguys_core_media"
     * )
     */
    private $file;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $fileName;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $originalName;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $size;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $mimeType;

    public function __construct()
    {
        $this->id = Uuid::uuid4()->toString();
    }

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\File\File
     */
    public function getFile(): ?File
    {
        return $this->file;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\File $file
     */
    public function setFile(?File $file)
    {
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @return string
     */
    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    /**
     * @param string $originalName
     */
    public function setOriginalName(string $originalName)
    {
        $this->originalName = $originalName;
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    /**
     * @param string $mimeType
     */
    public function setMimeType(string $mimeType)
    {
        $this->mimeType = $mimeType;
    }

    /**
     * @return string
     */
    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * @param string $size
     */
    public function setSize(string $size)
    {
        $this->size = $size;
    }
}
