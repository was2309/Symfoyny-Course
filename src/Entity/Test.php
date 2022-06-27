<?php

namespace App\Entity;

use App\Repository\TestRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestRepository::class)]
class Test
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $polje_jedan;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $polje_dva;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPoljeJedan(): ?string
    {
        return $this->polje_jedan;
    }

    public function setPoljeJedan(string $polje_jedan): self
    {
        $this->polje_jedan = $polje_jedan;

        return $this;
    }

    public function getPoljeDva(): ?int
    {
        return $this->polje_dva;
    }

    public function setPoljeDva(?int $polje_dva): self
    {
        $this->polje_dva = $polje_dva;

        return $this;
    }
}
