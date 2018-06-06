<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class Equipamento
 * @package AppBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="equipamentos")
 * @Vich\Uploadable()
 */
class Equipamento
{

    const STATUS_MANUTENCAO = 'Em manutenção';
    const STATUS_OK = 'Em funcionamento';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=100)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_equipamento", type="string", length=100)
     */
    private $tipoEquipamento;

    /**
     * @var string
     *
     * @ORM\Column(name="marca", type="string", length=100)
     */
    private $marca;

    /**
     * @var string
     *
     * @ORM\Column(name="modelo", type="string", length=100)
     */
    private $modelo;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=200)
     */
    private $descricao;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=50)
     */
    private $status;

    /**
     * @var Setor
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Setor", inversedBy="equipamentos")
     * @ORM\JoinColumn(name="setor_id", referencedColumnName="id")
     */
    private $setor;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Ordem", mappedBy="equipamento")
     */
    private $ordens;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="equip_img", fileNameProperty="image.name", size="image.size")
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
     * Equipamento constructor.
     */
    public function __construct()
    {
        $this->ordens = new ArrayCollection();
        $this->status = self::STATUS_OK;
        $this->image = new EmbeddedFile();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "$this->tipoEquipamento $this->modelo $this->marca";
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
     * @return Equipamento
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @return string
     */
    public function getTipoEquipamento()
    {
        return $this->tipoEquipamento;
    }

    /**
     * @param string $tipoEquipamento
     * @return Equipamento
     */
    public function setTipoEquipamento($tipoEquipamento)
    {
        $this->tipoEquipamento = $tipoEquipamento;
        return $this;
    }

    /**
     * @return string
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * @param string $marca
     * @return Equipamento
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;
        return $this;
    }

    /**
     * @return string
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * @param string $modelo
     * @return Equipamento
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param string $descricao
     * @return Equipamento
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return Equipamento
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return Setor
     */
    public function getSetor()
    {
        return $this->setor;
    }

    /**
     * @param Setor|null $setor
     * @return Equipamento
     */
    public function setSetor(Setor $setor = null)
    {
        $this->setor = $setor;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getOrdens()
    {
        return $this->ordens;
    }

    /**
     * @param Ordem|null $ordem
     * @return Equipamento
     */
    public function addOrdem(Ordem $ordem = null)
    {
        $this->ordens[] = $ordem;
        return $this;
    }

    /**
     * @param Ordem $ordem
     */
    public function removeOrdem(Ordem $ordem)
    {
        $this->ordens->removeElement($ordem);
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
     * @return Equipamento
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
     * @return Equipamento
     */
    public function setImage(EmbeddedFile $image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return Equipamento
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

}