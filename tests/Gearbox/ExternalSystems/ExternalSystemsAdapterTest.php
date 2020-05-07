<?php

namespace Mtk3d\Gearbox\Gearbox;

use Mtk3d\Gearbox\ExternalSystems\ExternalSystems;
use PHPUnit\Framework\TestCase;

class ExternalSystemsAdapterTest extends TestCase
{
    public function testExternalSystemsAdapter()
    {
        //given
        $externalSystem = $this->createMock(ExternalSystems::class);
        $externalSystem->method('getCurrentRpm')->willReturn((float)1000);
        //when
        $externalSystemAdapter = new ExternalSystemsAdapter($externalSystem);
        //then
        $this->assertEquals(1000, $externalSystemAdapter->getCurrentRpm()->value());
    }
}
