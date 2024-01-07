<?php

namespace Domain\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'users')]
final class User
{
    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    public int $id;
    #[Column(type: 'string', unique: false, nullable: false)]
    public string $name;
    #[Column(type: 'string', unique: true, nullable: false)]
    public string $email;
    #[Column(name: 'created_at', type: 'datetimetz_immutable', nullable: false)]
    public \DateTimeImmutable $createdAt;

    public function __construct(string $name, string $email, \DateTimeImmutable $createdAt) {
        $this->name = $name;
        $this->email = $email;
        $this->createdAt = $createdAt;
    }
}