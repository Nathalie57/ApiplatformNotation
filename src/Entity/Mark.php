<?php

namespace App\Entity;

use App\Repository\MarkRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

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
     */
    private $value;

    /**
     * @ORM\Column(type="string", length=32)
     * @Groups({"marks_read", "students_read", "marks_subresource"})
     */
    private $subject;

    /**
     * @ORM\ManyToOne(targetEntity=Student::class, inversedBy="marks")
     * @Groups({"marks_read"})
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
