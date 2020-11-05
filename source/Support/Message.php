<?php

namespace Source\Support;

use Source\Core\Session;

/**
 * JSON-PHP | Class Message
 *
 * @author Euclides Bernardo <euclidesquissembebernado@gmail.com>
 * @package Source\Core
 */
class Message
{
    /** @var string */
    private $text;

    /** @var string */
    private $type;

    /** @var string */
    private $before;

    /** @var string */
    private $after;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->renderText();
    }

    /**
     * @return string
     */
    public function getText(): ?string
    {
        return $this->before . $this->text . $this->after;
    }

    /**
     * @return string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $text
     * @return Message
     */
    public function before(string $text): Message
    {
        $this->before = $text;
        return $this;
    }

    /**
     * @param string $text
     * @return Message
     */
    public function after(string $text): Message
    {
        $this->after = $text;
        return $this;
    }

    /**
     * @param string $message
     * @return Message
     */
    public function info(string $message): Message
    {
        $this->type = "info";
        $this->text = $this->filter($message);
        return $this;
    }

    /**
     * @param string $message
     * @return Message
     */
    public function success(string $message): Message
    {
        $this->type = "success";
        $this->text = $this->filter($message);
        return $this;
    }

    /**
     * @param string $message
     * @return Message
     */
    public function warning(string $message): Message
    {
        $this->type = "warning";
        $this->text = $this->filter($message);
        return $this;
    }

    /**
     * @param string $message
     * @return Message
     */
    public function error(string $message): Message
    {
        $this->type = "error";
        $this->text = $this->filter($message);
        return $this;
    }

    /**
     * @return object
     */
    public function render(): object
    {
        $message = new \stdClass();
        $message->icon = $this->type;
        $message->title = $this->text;
        return $message;
    }

    public function renderText(): string
    {
        return
            "<div class=\"alert alert-{$this->type} alert-dismissible text-center\">" .
            "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>" .
            "{$this->text}" .
            "</div>";
    }

    /**
     * @return string
     */
    public function json(): string
    {
        return $this->getText();
    }

    /**
     * Set flash Session Key
     */
    public function flash(): void
    {
        (new Session())->set("flash", $this);
    }

    /**
     * @param string $message
     * @return string
     */
    private function filter(string $message): string
    {
        return filter_var($message, FILTER_SANITIZE_STRIPPED);
    }
}