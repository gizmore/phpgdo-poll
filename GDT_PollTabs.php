<?php
namespace GDO\Poll;

use GDO\UI\GDT_Bar;
use GDO\UI\GDT_Link;

final class GDT_PollTabs extends GDT_Bar
{

	protected function __construct()
	{
		parent::__construct();
		$this->horizontal();
		$this->addFields(
			GDT_Link::make('link_polls')->text('link_polls', [GDO_Poll::numActivePolls()])->href(href('Poll', 'Overview'))->icon('vote'),
			GDT_Link::make('create_poll')->href(href('Poll', 'Create'))->icon('create'),
		);
	}

}
