<?php
namespace GDO\Poll;

use GDO\Core\GDO;
use GDO\Core\GDT;
use GDO\Core\GDT_Select;
use GDO\Core\WithGDO;

final class GDT_PollAnswer extends GDT_Select
{

	use WithGDO;

	protected function __construct()
	{
		parent::__construct();
		$this->icon('vote');
		$this->emptyInitial('please_vote');
	}

	public function defaultLabel(): self
	{
		return $this->label('your_answer');
	}

	protected function getChoices(): array
	{
		return $this->getPoll()->getChoices();
	}

	public function getPoll(): GDO_Poll
	{
		return $this->gdo;
	}

	public function gdo(?GDO $gdo): static
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
