<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Mark;

/**
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 * @ApiResource(
 *  collectionOperations={"GET", "POST"},
 *  itemOperations={"GET", "DELETE", "PATCH",
 *      "average"={
 *          "method"="get", 
 *          "path"="/students/{id}/average",
 *          "controller"="App\Controller\AverageStudentController"
 *      }
 *  },
 *  normalizationContext={
 *      "groups"={"students_read"}
 *  },
 * denormalizationContext={"disabled_type_enforcement"=true}
 * )
 */
class Student
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"students_read", "marks_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups({"students_read", "marks_read"})
     * @Assert\NotBlank(message="Le prénom de l'élève est obligatoire !")
     * @Assert\Length(min=2, minMessage="Le prénom doit faire au moins deux caractères !")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups({"students_read", "marks_read"})
     * @Assert\NotBlank(message="Le nom de l'élève est obligatoire !")
     * @Assert\Length(min=2, minMessage="Le nom doit faire au moins deux caractères !")
     */
    private $lastName;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"students_read", "marks_read"})
     * @Assert\NotBlank(message="Le date de naissance de l'élève est obligatoire !")
     * @Assert\Type(
     * type = "\DateTime",
     * message = "La date renseignée doit être au format YYYY-MM-DD !"
     * )
     */
    private $birthday;

    /**
     * @ORM\OneToMany(targetEntity=Mark::class, mappedBy="student")
     * @Groups({"students_read"})
     * @ApiSubresource
     */
    private $marks;

    public function __construct()
    {
        $this->marks = new ArrayCollection();
    }

    /**
     * Calculate the average of a student
     *
     * @return float
     * 
     */
    public function getSumMarks(): float
    {
        return array_reduce($this->marks->toArray(), function ($total, $mark) {
            return $total + $mark->getValue();
        }, 0);
    }

    /**
     * @return int
     * 
     */
    public function getNumberMarks(): int{
        return count($this->marks);
    }

    /**
     * @return float
     * @Groups({"students_read"})
     */
    public function getAverageStudent(): float{
        return $this->getSumMarks()/$this->getNumberMarks();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday($birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * @return Collection|Mark[]
     */
    public function getMarks(): Collection
    {
        return $this->marks;
    }

    public function addMark(Mark $mark): self
    {
        if (!$this->marks->contains($mark)) {
            $this->marks[] = $mark;
            $mark->setStudent($this);
        }

        return $this;
    }

    public function removeMark(Mark $mark): self
    {
        if ($this->marks->contains($mark)) {
            $this->marks->removeElement($mark);
            // set the owning side to null (unless already changed)
            if ($mark->getStudent() === $this) {
                $mark->setStudent(null);
            }
        }

        return $this;
    }
}
