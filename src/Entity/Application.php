<?php

namespace App\Entity;

use App\Repository\ApplicationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
class Application
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 1000)]
    private ?string $motivation = null;

    #[ORM\ManyToOne(inversedBy: 'applications')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Job $job = null;

    #[ORM\ManyToOne(inversedBy: 'applications')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $jobseeker = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cv_path = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMotivation(): ?string
    {
        return $this->motivation;
    }

    public function setMotivation(string $motivation): static
    {
        $this->motivation = $motivation;

        return $this;
    }

    public function getJob(): ?job
    {
        return $this->job;
    }

    public function setJob(?job $job): static
    {
        $this->job = $job;

        return $this;
    }

    public function getJobseeker(): ?user
    {
        return $this->jobseeker;
    }

    public function setJobseeker(?user $jobseeker): static
    {
        $this->jobseeker = $jobseeker;

        return $this;
    }

    public function getCvPath(): ?string
    {
        return $this->cv_path;
    }

    public function setCvPath(?string $cv_path): static
    {
        $this->cv_path = $cv_path;

        return $this;
    }
}
