<?php

namespace App\Entity;

use App\Repository\SchoolYearRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SchoolYearRepository::class)]
class SchoolYear
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 190)]
    private $name;

    #[ORM\Column(type: 'datetime_immutable')]
    private $startdate_at;

    #[ORM\Column(type: 'datetime_immutable')]
    private $enddate_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStartdateAt(): ?\DateTimeImmutable
    {
        return $this->startdate_at;
    }

    public function setStartdateAt(\DateTimeImmutable $startdate_at): self
    {
        $this->startdate_at = $startdate_at;

        return $this;
    }

    public function getEnddateAt(): ?\DateTimeImmutable
    {
        return $this->enddate_at;
    }

    public function setEnddateAt(\DateTimeImmutable $enddate_at): self
    {
        $this->enddate_at = $enddate_at;

        return $this;
    }
}
