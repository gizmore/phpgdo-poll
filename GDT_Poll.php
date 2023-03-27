<?php
namespace GDO\Poll;

use GDO\Core\GDT_Object;

final class GDT_Poll extends GDT_Object
{

	public ?bool $open = null;

	##############
	### Expire ###
	##############

	protected function __construct()
	{
		parent::__construct();
		$this->table(GDO_Poll::table());
	}

	public function open(?bool $open = true): self
	{
		$this->open = $open;
		return $this;
	}

	public function validateExpire(GDO_Poll $poll): bool
	{
		if ($this->open === true)
		{
			if ($poll->isExpired())
			{
				return $this->error('err_poll_expired');
			}
		}
		elseif ($this->open === false)
		{
			if (!$poll->isExpired())
			{
				return $this->error('err_poll_only_expired');
			}
		}
		return true;
	}

}
