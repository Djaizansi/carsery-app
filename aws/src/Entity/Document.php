<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\DownloadController;
use App\Controller\UploadController;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class Document
 *
 * @ORM\Table(name="document")
 * @ORM\Entity()
 * @Vich\Uploadable()
 */
#[ApiResource(
    collectionOperations: [
        'upload' => [
            'method' => 'POST',
            'path' => '/upload',
            'controller' => UploadController::class,
            'deserialize' => false,
        ],
        'getOneElement' => [
            'method' => 'GET',
            'path' => '/download/get/{id}',
            'controller' => DownloadController::class,
            'write' => false,
            'read' => false,
        ],
        'getList' => [
            'method' => 'POST',
            'path' => '/download/list',
            'controller' => DownloadController::class,
            'write' => false,
            'read' => false,
            'denormalization_context' => ['groups' => ['aws_search_list:post']]
        ],
    ],
    itemOperations: []
)]

class Document
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer", name="id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[Groups(['aws_search_list:post'])]
    private $filePath;

    /**
     * @var File
     * @Vich\UploadableField(mapping="assets", fileNameProperty="filePath")
     */
    private $file;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }

    /**
     * @param string $filePath
     */
    public function setFilePath(string $filePath): void
    {
        $this->filePath = $filePath;
    }

    /**
     * @return File
     */
    public function getFile(): File
    {
        return $this->file;
    }

    /**
     * @param File $file
     */
    public function setFile(File $file): File
    {
        return $this->file = $file;
    }
}

