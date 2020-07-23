<?php

namespace App\Entity;

use App\Repository\MarkRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MarkRepository::class)
 * @ApiResource(
 *  collectionOperations={"GET", "POST"},
 *  itemOperations={"GET"},
 *  subresourceOperations={
 *      "api_students_marks_get_subresource"={
 *          "normalization_context"={"groups"={"marks_subresource"}}
 *      }
 *  },
 *  attributes={
 *      "pagination_enabled"=true, 
 *      "pagination_items_per_page"=10
 *  },
 *  normalizationContext={
 *      "groups"={"marks_read"}
 *  }
 * )
 * 
 */
class Mark
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"marks_read", "students_read", "marks_subresource"})
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @Groups({"marks_read", "students_read", "marks_subresource"})
     * @Assert\NotBlank(message="La note est obligatoire !")
     * @Assert\Range(min=0, max=20, notInRangeMessage="La note doit être comprise entre 0 et 20 !")
     */
    private $value;

    /**
     * @ORM\Column(type="string", length=32)
     * @Groups({"marks_read", "students_read", "marks_subresource"})
     * @Assert\NotBlank(message="La matière est obligatoire !")
     * @Assert\Length(min=5, minMessage="Le matière doit faire au moins cinq caractères !")
     */
    private $subject;

    /**
     * @ORM\ManyToOne(targetEntity=Student::class, inversedBy="marks")
     * @Groups({"marks_read"})
     * @Assert\NotBlank(message="L'élève doit obligatoirement être renseigné !")
     */
    private $student;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }
}
