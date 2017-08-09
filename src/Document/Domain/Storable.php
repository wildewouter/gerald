<?php

namespace Document\Domain;

interface Storable
{
    public function toArray(): array;
}
