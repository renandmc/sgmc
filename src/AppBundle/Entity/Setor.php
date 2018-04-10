<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class Setor
 * @package AppBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="setores")
 * @Vich\Uploadable()
 */
class Setor
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=255)
     */
    private $nome;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Equipamento", mappedBy="setor")
     */
    private $equipamentos;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="setor_img", fileNameProperty="image.name", size="image.size")
     */
    private $imageFile;

    /**
     * @var EmbeddedFile
     *
     * @ORM\Embedded(class="Vich\UploaderBundle\Entity\File")
     */
    private $image;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * Setor constructor
     */
    public function __construct()
    {
        $this->equipamentos = new ArrayCollection();
        $this->image = new EmbeddedFile();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "$this->nome";
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     * @return Setor
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getEquipamentos()
    {
        return $this->equipamentos;
    }

    /**
     * @param Equipamento $equipamento
     * @return Setor
     */
    public function addEquipamento(Equipamento $equipamento)
    {
        $this->equipamentos[] = $equipamento;
        return $this;
    }

    /**
     * @param Equipamento $equipamento
     */
    public function removeEquipamento(Equipamento $equipamento)
    {
        $this->equipamentos->removeElement($equipamento);
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param File|UploadedFile|null $imageFile
     * @return Setor
     * @throws \Exception
     */
    public function setImageFile(File $imageFile = null)
    {
        $this->imageFile = $imageFile;
        if ($imageFile !== null){
            $this->updatedAt = new \DateTimeImmutable();
        }
        return $this;
    }

    /**
     * @return EmbeddedFile
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param EmbeddedFile $image
     * @return Setor
     */
    public function setImage(EmbeddedFile $image)
    {
        $this->image = $image;
        return $this;
    }
}