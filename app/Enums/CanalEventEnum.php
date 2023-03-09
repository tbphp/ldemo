<?php

namespace App\Enums;

use Com\Alibaba\Otter\Canal\Protocol\EventType;

class CanalEventEnum extends BaseEnum
{
    const INSERT = EventType::INSERT;

    const UPDATE = EventType::UPDATE;

    const DELETE = EventType::DELETE;
}
