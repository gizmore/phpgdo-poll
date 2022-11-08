<?php
namespace GDO\Poll;

use GDO\UI\GDT_Page;

trait MethodPoll
{
	
	public function isTrivial(): bool
	{
		return false;
	}
	
	public function onRenderTabs(): void
	{
		GDT_Page::instance()->topResponse()->addField(
			GDT_PollTabs::make());
	}
	
}
