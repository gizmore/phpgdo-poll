<?php
namespace GDO\Poll;

use GDO\UI\GDT_Container;
use GDO\Core\WithGDO;
use GDO\UI\GDT_HTML;
use GDO\Core\Application;

final class GDT_PollResults extends GDT_Container
{
	
	use WithGDO;
	
	protected function __construct()
	{
		parent::__construct();
		$this->vertical();
	}
	
	public function getPoll(): GDO_Poll
	{
		return $this->getGDO();
	}
	
	public function renderFields(int $renderMode): string
	{
		$this->removeFields();
		$poll = $this->getPoll();
		$this->addField(
			GDT_HTML::make('poll_descr')->var($poll->renderDescription()));
		foreach ($poll->getChoices() as $choice)
		{
			$this->addField(
				GDT_PollOutcome::make("choice_{$choice->getID()}")->gdo($choice));
		}
		$back = '<section class="gdt-poll-results">';
		$back .= parent::renderFields($renderMode);
		$back .= '</section>';
		return $back;
	}
	
	
}
