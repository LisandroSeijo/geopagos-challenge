<?php

namespace ATP\Payloads;

use ATP\Entities\Tournament;

interface CreatePhasePayload {
    /**
     * @return int[]
     */
    public function players(): array;

    public function tournament(): Tournament;

    public function phase(): int;
}