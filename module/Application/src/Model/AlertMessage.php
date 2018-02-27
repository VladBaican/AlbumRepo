<?php
namespace Application\Model;

/*
 * Alert Message
 */
class AlertMessage
{
    /**
     * @const TYPE_SUCCESS
     */
    const TYPE_SUCCESS = 'success';

    /**
     * @const TYPE_DANGER
     */
    const TYPE_DANGER = 'danger';

    /**
     * @const TYPE_WARNING
     */
    const TYPE_WARNING = 'warning';

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $message;

    /**
     * Constructor.
     *
     * @param string $type
     * @param string $messages
     */
    public function __construct(string $type, string $message)
    {
        $this->type = $type;
        $this->message = $message;
    }

    /**
     * Get the alert message type.
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the alert message content.
     */
    public function getContent()
    {
        return $this->message;
    }
}
