<?php

namespace spec\PSB\Persistence\Doctrine1\Outbox;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use PSB\Core\BusContextInterface;
use PSB\Core\Util\Settings;
use PSB\Persistence\Doctrine1\Doctrine1KnownSettingsEnum;
use PSB\Persistence\Doctrine1\Outbox\EndpointIdLoaderFeatureStartupTask;
use PSB\Persistence\Doctrine1\Outbox\OutboxPersister;

/**
 * @mixin EndpointIdLoaderFeatureStartupTask
 */
class EndpointIdLoaderFeatureStartupTaskSpec extends ObjectBehavior
{
    function it_is_initializable(OutboxPersister $outboxPersister, Settings $settings, $endpointName)
    {
        $this->beConstructedWith($outboxPersister, $settings, $endpointName);
        $this->shouldHaveType('PSB\Persistence\Doctrine1\Outbox\EndpointIdLoaderFeatureStartupTask');
    }

    function it_loads_the_endpoint_id_from_persistence_storage_into_settings(
        OutboxPersister $outboxPersister,
        Settings $settings,
        $endpointName,
        BusContextInterface $busContext
    ) {
        $this->beConstructedWith($outboxPersister, $settings, $endpointName);

        $endpointId = 'irrelevant';
        $outboxPersister->fetchOrGenerateEndpointId($endpointName)->willReturn($endpointId);
        $settings->set(Doctrine1KnownSettingsEnum::OUTBOX_ENDPOINT_ID, $endpointId)->shouldBeCalled();

        $this->start($busContext);
    }
}
