<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Ordem
 * @package AppBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="ordens")
 */
class Ordem
{

    const STATUS_FECHADO = 'Fechado';
    const STATUS_MANUTENCAO = 'Em manutenção';
    const STATUS_PARECER = 'Parecer técnico';

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Equipamento
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Equipamento", inversedBy="ordens")
     * @ORM\JoinColumn(name="equipamento_id", referencedColumnName="id")
     */
    private $equipamento;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao_defeito", type="string", length=200)
     */
    private $descricaoDefeito;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="data_aberto", type="datetime")
     */
    private $dataAberto;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="data_fechado", type="datetime")
     */
    private $dataFechado;

    /**
     * @var string
     *
     * @ORM\Column(name="parecer_tecnico", type="string", length=200)
     */
    private $parecerTecnico;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=30)
     */
    private $status;

    /**
     * @var Usuario
     *
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="criado_por", referencedColumnName="id")
     */
    private $criadoPor;

    /**
     * @var Usuario
     *
     * @Gedmo\Blameable(on="change", field={"status"})
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="fechado_por", referencedColumnName="id")
     */
    private $fechadoPor;

    /**
     * Ordem constructor.
     */
    public function __construct()
    {
        $this->dataAberto = new DateTime('now');
        $this->equipamento->setStatus(Equipamento::STATUS_MANUTENCAO);
        $this->status = self::STATUS_MANUTENCAO;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->descricaoDefeito;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Equipamento
     */
    public function getEquipamento()
    {
        return $this->equipamento;
    }

    /**
     * @param Equipamento|null $equipamento
     * @return Ordem
     */
    public function setEquipamento(Equipamento $equipamento = null)
    {
        $this->equipamento = $equipamento;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescricaoDefeito()
    {
        return $this->descricaoDefeito;
    }

    /**
     * @param string $descricaoDefeito
     * @return Ordem
     */
    public function setDescricaoDefeito($descricaoDefeito)
    {
        $this->descricaoDefeito = $descricaoDefeito;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDataAberto()
    {
        return $this->dataAberto;
    }

    /**
     * @param DateTime $dataAberto
     * @return Ordem
     */
    public function setDataAberto(DateTime $dataAberto)
    {
        $this->dataAberto = $dataAberto;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDataFechado()
    {
        return $this->dataFechado;
    }

    /**
     * @param DateTime $dataFechado
     * @return Ordem
     */
    public function setDataFechado(DateTime $dataFechado)
    {
        $this->dataFechado = $dataFechado;
        return $this;
    }

    /**
     * @return string
     */
    public function getParecerTecnico()
    {
        return $this->parecerTecnico;
    }

    /**
     * @param string $parecerTecnico
     * @return Ordem
     */
    public function setParecerTecnico($parecerTecnico)
    {
        $this->parecerTecnico = $parecerTecnico;
        $this->setStatus(self::STATUS_PARECER);
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
     * @return Ordem
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return Usuario
     */
    public function getCriadoPor()
    {
        return $this->criadoPor;
    }

    /**
     * @return Usuario
     */
    public function getFechadoPor()
    {
        return $this->fechadoPor;
    }

    /**
     * @return Ordem
     */
    public function fechaOrdem()
    {
        $this->status = self::STATUS_FECHADO;
        $this->equipamento->setStatus(Equipamento::STATUS_OK);
        $this->dataFechado = new DateTime('now');
        return $this;
    }
}