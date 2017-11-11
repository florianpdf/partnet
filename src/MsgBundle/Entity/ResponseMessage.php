<?php

namespace MsgBundle\Entity;

/**
 * ResponseMessage
 */
class ResponseMessage
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $idMessage;

    /**
     * @var string
     */
    private $sender;

    /**
     * @var string
     */
    private $message;

    /**
     * @var \DateTime
     */
    private $date;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idMessage
     *
     * @param integer $idMessage
     *
     * @return ResponseMessage
     */
    public function setIdMessage($idMessage)
    {
        $this->idMessage = $idMessage;

        return $this;
    }

    /**
     * Get idMessage
     *
     * @return integer
     */
    public function getIdMessage()
    {
        return $this->idMessage;
    }

    /**
     * Set sender
     *
     * @param string $sender
     *
     * @return ResponseMessage
     */
    public function setSender($sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Get sender
     *
     * @return string
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return ResponseMessage
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return ResponseMessage
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
    /**
     * @var string
     */
    private $sender_name;


    /**
     * Set senderName
     *
     * @param string $senderName
     *
     * @return ResponseMessage
     */
    public function setSenderName($senderName)
    {
        $this->sender_name = $senderName;

        return $this;
    }

    /**
     * Get senderName
     *
     * @return string
     */
    public function getSenderName()
    {
        return $this->sender_name;
    }
    /**
     * @var string
     */
    private $subject;


    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return ResponseMessage
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }
}
