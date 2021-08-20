<?php

namespace Domain\ValueObjects;

abstract class Document
{
    private string $document;

    public function __construct(string $document)
    {
        if (!$this->validate($document))
            throw new \DomainException('Invalid document number');

        $this->document = $document;
    }

    abstract protected function validate(string $document):bool;

    public function __toString(): string
    {
        return $this->document;
    }
}
