<?php
namespace GDO\Poll;

use GDO\Core\GDO_Module;
use GDO\Core\GDT_Checkbox;
use GDO\User\GDT_Level;

/**
 * Polls working in CLI and Web.
 * 
 * @author gizmore
 * @version 7.0.1
 */
final class Module_Poll extends GDO_Module
{
	public int $priority = 40;
	
	public function getClasses() : array
	{
		return [
			GDO_Poll::class,
			GDO_Choice::class,
			GDO_Answer::class,
		];
	}
	
	############
	### Init ###
	############
	public function onLoadLanguage(): void
	{
		$this->loadLanguage('lang/poll');
	}
	
	##############
	### Config ###
	##############
	public function getConfig(): array
	{
		return [
			GDT_Checkbox::make('hook_sidebar')->initial('1'),
			GDT_Checkbox::make('guest_votes')->initial('1'),
			GDT_Level::make('level_per_poll')->initial('100'),
		];
	}
	public function cfgSidebar(): bool { return $this->getConfigValue('hook_sidebar'); }
	public function cfgGuestVotes(): bool { return $this->getConfigValue('guest_votes'); }
	public function cfgLevelPerPoll(): int { return $this->getConfigValue('level_per_poll'); }
	
}
