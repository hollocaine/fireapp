<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CheckRepository")
 */
class Check
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $check_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $question_id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $risk_level;

    /**
     * @ORM\Column(type="text")
     */
    private $report;

    /**
     * @ORM\Column(type="datetime")
     */
    private $checked;

    /**
     * @ORM\Column(type="datetime")
     */
    private $actioned;

    /**
     * @ORM\Column(type="integer")
     */
    private $user_id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $completed;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCheckId(): ?int
    {
        return $this->check_id;
    }

    public function setCheckId(int $check_id): self
    {
        $this->check_id = $check_id;

        return $this;
    }

    public function getQuestionId(): ?int
    {
        return $this->question_id;
    }

    public function setQuestionId(int $question_id): self
    {
        $this->question_id = $question_id;

        return $this;
    }

    public function getRiskLevel(): ?int
    {
        return $this->risk_level;
    }

    public function setRiskLevel(int $risk_level): self
    {
        $this->risk_level = $risk_level;

        return $this;
    }

    public function getReport(): ?string
    {
        return $this->report;
    }

    public function setReport(string $report): self
    {
        $this->report = $report;

        return $this;
    }

    public function getChecked(): ?\DateTimeInterface
    {
        return $this->checked;
    }

    public function setChecked(\DateTimeInterface $checked): self
    {
        $this->checked = $checked;

        return $this;
    }

    public function getActioned(): ?\DateTimeInterface
    {
        return $this->actioned;
    }

    public function setActioned(\DateTimeInterface $actioned): self
    {
        $this->actioned = $actioned;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getCompleted(): ?\DateTimeInterface
    {
        return $this->completed;
    }

    public function setCompleted(?\DateTimeInterface $completed): self
    {
        $this->completed = $completed;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
