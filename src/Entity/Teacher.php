<?php

namespace App\Entity;

use App\Repository\TeacherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeacherRepository::class)]
class Teacher
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 190)]
    private $firstname;

    #[ORM\Column(type: 'string', length: 190)]
    private $lastname;

    #[ORM\ManyToMany(targetEntity: SchoolYear::class, mappedBy: 'teachers')]
    private $schoolYears;

    #[ORM\ManyToMany(targetEntity: Tag::class, mappedBy: 'teachers')]
    private $tags;

    public function __construct()
    {
        $this->schoolYears = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return Collection<int, SchoolYear>
     */
    public function getSchoolYears(): Collection
    {
        return $this->schoolYears;
    }

    public function addSchoolYear(SchoolYear $schoolYear): self
    {
        if (!$this->schoolYears->contains($schoolYear)) {
            $this->schoolYears[] = $schoolYear;
            $schoolYear->addTeacher($this);
        }

        return $this;
    }

    public function removeSchoolYear(SchoolYear $schoolYear): self
    {
        if ($this->schoolYears->removeElement($schoolYear)) {
            $schoolYear->removeTeacher($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->addTeacher($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeTeacher($this);
        }

        return $this;
    }
}
