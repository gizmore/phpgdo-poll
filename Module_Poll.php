<?php
namespace GDO\Poll;

use GDO\Core\GDO_Module;
use GDO\Core\GDT_Checkbox;
use GDO\Subscription\GDT_SubscribeType;
use GDO\UI\GDT_Link;
use GDO\UI\GDT_Page;
use GDO\User\GDT_Level;

/**
 * Polls working in CLI and Web.
 * Multiple choice supported.
 * Optional allowed guest votes.
 *
 * @version 7.0.1
 * @author gizmore
 */
final class Module_Poll extends GDO_Module
{

	public int $priority = 40;

    public function getDependencies(): array
    {
        return [
            'Subscription',
        ];
    }

    public function getClasses(): array
	{
		return [
			GDO_Poll::class,
			GDO_PollChoice::class,
			GDO_PollAnswer::class,
		];
	}

	##############
	### Config ###
	##############
	public function getConfig(): array
	{
		return [
			GDT_Checkbox::make('hook_sidebar')->initial('1'),
			GDT_Checkbox::make('guest_votes')->initial('0'),
			GDT_Level::make('level_per_poll')->initial('0'),
		];
	}

    public function getUserSettings(): array
    {
        return [
            GDT_SubscribeType::make('poll_subscription')->maxSelected(10),
        ];
    }

    public function onLoadLanguage(): void
	{
		$this->loadLanguage('lang/poll');
	}

	public function onIncludeScripts(): void
	{
		$this->addCSS('css/gdo7-poll.css');
	}

	public function onInitSidebar(): void
	{
		GDT_Page::instance()->leftBar()->addFields(
			GDT_Link::make('link_polls')->textArgs(GDO_Poll::numActivePolls())
				->href($this->href('Overview'))->icon('vote'),
		);
	}

	############
	### Init ###
	############

	public function cfgSidebar(): bool { return $this->getConfigValue('hook_sidebar'); }

	public function cfgGuestVotes(): bool { return $this->getConfigValue('guest_votes'); }

	public function cfgLevelPerPoll(): int { return $this->getConfigValue('level_per_poll'); }

}
