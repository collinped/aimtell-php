<?php

namespace Collinped\Aimtell\Tests;

class DefaultParamsTest extends TestCase
{
    /** @test */
    public function it_can_assign_api_key()
    {
        $this->aimtell->setApiKey('test_key');

        $this->assertEquals('test_key', $this->aimtell->getApiKey());
    }

    /** @test */
    public function it_can_assign_default_site()
    {
        $this->aimtell->setDefaultSiteId('site_id');

        $this->assertEquals('site_id', $this->aimtell->getDefaultSiteId());
    }

    /** @test */
    public function it_can_assign_white_label_id()
    {
        $this->aimtell->setWhiteLabelId('white_label_id');

        $this->assertEquals('white_label_id', $this->aimtell->getWhiteLabelId());
    }
}
