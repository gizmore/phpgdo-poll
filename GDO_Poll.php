<?php
namespace GDO\Poll;

use GDO\Core\GDO;
use GDO\Core\GDO_DBException;
use GDO\Core\GDT_AutoInc;
use GDO\Core\GDT_Checkbox;
use GDO\Core\GDT_CreatedAt;
use GDO\Core\GDT_CreatedBy;
use GDO\Core\GDT_DeletedAt;
use GDO\Core\GDT_DeletedBy;
use GDO\Core\GDT_Template;
use GDO\Core\GDT_UInt;
use GDO\Date\GDT_Date;
use GDO\Date\Time;
use GDO\Language\GDT_Language;
use GDO\UI\GDT_Card;
use GDO\UI\GDT_Message;
use GDO\UI\GDT_Title;
use GDO\User\GDO_User;
use GDO\User\GDT_Level;

final class GDO_Poll extends GDO
{

    /**
     * @throws GDO_DBException
     */
    public static function numActivePolls(): int
	{
		$now = Time::getDateWithoutTime();
		$conditions = "poll_deleted IS NULL AND (poll_expires > '{$now}' OR poll_expires IS NULL)";
		return self::table()->countWhere($conditions);
	}

	public function isTestable(): bool
	{
		return false;
	}

	##############
	### Getter ###
	##############

	public function gdoColumns(): array
	{
		return [
			GDT_AutoInc::make('poll_id'),

			GDT_Title::make('poll_question')->notNull()->label('question'),
			GDT_Message::make('poll_description')->label('description'),
			GDT_Language::make('poll_language')->notNull()->initialCurrent(),

			GDT_UInt::make('poll_max_answers')->bytes(1)->notNull()->min(1)->tooltip('choose_multiple_choice')->initial('1')->label('multiple_choice'),

			GDT_Date::make('poll_expires')->label('expires'),

			GDT_Checkbox::make('poll_guests')->notNull()->initial('0'),
			GDT_Level::make('poll_level')->label('poll_level')->writeable(true),

			GDT_UInt::make('poll_usercount')->notNull()->initial('0'),

			GDT_CreatedBy::make('poll_creator'),
			GDT_CreatedAt::make('poll_created'),

			GDT_DeletedBy::make('poll_deletor'),
			GDT_DeletedAt::make('poll_deleted'),
		];
	}

	public function renderList(): string
	{
		return GDT_Template::php('Poll', 'poll_list.php', ['gdo' => $this]);
	}

	public function isExpired(): bool
	{
		return Time::getAge($this->gdoVar('poll_expires')) > 0;
	}

    public function renderCard(): string
    {
        return GDT_Card::make()->render();
    }

    public function isMultipleChoice(): bool
	{
		return $this->getMaxAnswers() > 1;
	}

	public function getMaxAnswers(): int
	{
		return $this->gdoVar('poll_max_answers');
	}

	############
	### HREF ###
	############

	public function getCreator(): GDO_User
	{
		return $this->gdoValue('poll_creator');
	}

	public function hrefView(): string
	{
		return href('Poll', 'View', "&id={$this->getID()}");
	}

	##############
	### Render ###
	##############

	public function hrefAnswer(): string
	{
		return href('Poll', 'Answer', "&poll={$this->getID()}");
	}

	public function renderTitle(): string
	{
		return $this->gdoDisplay('poll_question');
	}

	public function renderDescription(): string
	{
		return $this->descrColumn()->getVarOutput();
	}

	##################
	### Permission ###
	##################

	private function descrColumn(): GDT_Message
	{
		return $this->gdoColumn('poll_description');
	}

	###############
	### Answers ###
	###############

	public function getAnsweredText(GDO_User $user): string
	{
		if ($this->hasAnswered($user))
		{
			return t('poll_you_answered');
		}
		else
		{
			return t('poll_you_questioned');
		}
	}

	public function hasAnswered(GDO_User $user): bool
	{
		return GDO_PollAnswer::hasAnswered($user, $this);
	}

	#################
	### Calculate ###
	#################

	public function recalculate(): void
	{
		$usercount = $this->calculateUserCount();
		$this->saveVar('poll_usercount', $usercount);
		foreach ($this->getChoices() as $choice)
		{
			$choice->recalculate($this, $usercount);
		}
	}

	public function calculateUserCount(): int
	{
		return GDO_PollAnswer::calculateUserCount($this);
	}

	##############
	### Static ###
	##############

	/**
	 * Get all choices for this poll.
	 *
	 * @return GDO_PollChoice[]
	 */
	public function getChoices(string $order = 'RAND()'): array
	{
		return GDO_PollChoice::getChoices($this, $order);
	}

    /**
     * Get all choices for this poll, sorted like added.
     *
     * @return GDO_PollChoice[]
     */
    public function getChoicesSorted(): array
    {
        return GDO_PollChoice::getChoices($this, 'choice_id');
    }

}
