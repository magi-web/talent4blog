<?php


namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class ContactMessage
{
    /**
     * @var string
     * @Assert\NotBlank
     */
    private $subject;

    /**
     * @var string
     *
     * @Assert\NotBlank
     * @Assert\Email(message="Veuillez entrer une adresse email valide.")
     */
    private $from;

    /**
     * @var string
     *
     * @Assert\NotBlank
     */
    private $message;

    /**
     * @return string
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     * @return ContactMessage
     */
    public function setSubject(string $subject): ContactMessage
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return string
     */
    public function getFrom(): ?string
    {
        return $this->from;
    }

    /**
     * @param string $from
     * @return ContactMessage
     */
    public function setFrom(string $from): ContactMessage
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return ContactMessage
     */
    public function setMessage(string $message): ContactMessage
    {
        $this->message = $message;
        return $this;
    }
}
