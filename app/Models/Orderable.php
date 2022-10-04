<?php

namespace App\Models;

interface Orderable {

    public function getPrice():float;

    public function getName(): string;

    public function getId(): int;

    public function getType(): string;
}
