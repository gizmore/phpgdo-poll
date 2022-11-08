<?php
namespace GDO\Poll;

use GDO\Core\GDT_Select;
use GDO\Core\WithGDO;
use GDO\Core\GDO;

final class GDT_PollAnswer extends GDT_Select
{
	
	use WithGDO;
	
	public function defaultLabel(): self
	{
		return $this->label('your_answer');
	}
	
	protected function __construct()
	{
		parent::__construct();
		$this->icon('vote');
		$this->emptyInitial('please_vote');
	}
	
	public function getPoll(): GDO_Poll
	{
		return $this->gdo;
	}
	
	public function getChoices()
	{
		return $this->getPoll()->getChoices();
	}
	
	public function gdo(GDO $gdo=null): self
	{
		$this->gdoVarInitial($gdo, false);
		if (!$gdo)
		{
			return $this;
		}
		$poll = $this->getPoll();
		return $this->multiple($poll->isMultipleChoice());
	}
	
}
