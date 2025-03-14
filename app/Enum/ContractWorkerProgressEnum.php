<?php

namespace App\Enum;

class ContractWorkerProgressEnum
{
    const WAITING = "waiting";
    const PREPARING = "preparing";
    const ON_WAY = "on_way";
    const ARRIVING = "arriving";
    const ARRIVED = "arrived";
    const WORKING = "working";
    const DONE = "done";
    const CANCELLED = "cancelled";
}
