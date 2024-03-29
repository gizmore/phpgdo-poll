<?php
namespace GDO\Poll;

use GDO\Core\GDO;
use GDO\Core\GDO_DBException;
use GDO\Core\GDT_AutoInc;
use GDO\Core\GDT_Index;
use GDO\Core\GDT_Percent;
use GDO\Core\GDT_UInt;
use GDO\UI\GDT_Title;
use GDO\User\GDO_User;

final class GDO_PollChoice extends GDO
{

	public static function getChoices(GDO_Poll $poll, string $order = 'RAND()'): array
	{
		return GDO_PollChoice::table()->select()
			->where("choice_poll={$poll->getID()}")
			->order($order)
			->exec()
			->fetchAllArray2dObject();
	}

	public function isTestable(): bool
	{
		return false;
	}

	public function gdoColumns(): array
	{
		return [
			GDT_AutoInc::make('choice_id'),
			GDT_Poll::make('choice_poll')->notNull(),
			GDT_UInt::make('choice_amount')->bytes(2)->notNull()->initial('0'),
			GDT_Percent::make('choice_percent'),
			GDT_Title::make('choice_text')->notNull()->min(1),
			GDT_Index::make('choice_poll_index')->indexColumns('choice_poll')->hash(),
		];
	}

	public function renderOption(): string
	{
		return $this->renderTitle();
	}

	public function renderTitle(): string
	{
		return $this->gdoDisplay('choice_text');
	}

	public function getPoll(): GDO_Poll
	{
		return $this->gdoValue('choice_poll');
	}

	public function getAmount(): int
	{
		return $this->gdoVar('choice_amount');
	}

	public function getPercent(): ?float
	{
		return $this->gdoValue('choice_percent');
	}

	public function renderPercent(): string
	{
		return $this->gdoDisplay('choice_percent');
	}

    /**
     * @throws GDO_DBException
     */
    public function recalculate(GDO_Poll $poll, int $usercount): self
	{
		$count = $this->countChosen();
		return $this->saveVars([
			'choice_amount' => (string)$count,
			'choice_percent' => (string)($count * 100.0 / (float)$usercount),
		]);
	}

	public function countChosen(): int
	{
		return GDO_PollAnswer::calculateChoiceCount($this);
	}

	##############
	### Static ###
	##############

	public function hasUserChosen(GDO_User $user): bool
	{
		return GDO_PollAnswer::hasUserChosen($user, $this);
	}

}
