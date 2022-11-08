<?php
namespace GDO\Poll;

use GDO\Core\GDO;
use GDO\Core\GDT_AutoInc;
use GDO\Core\GDT_CreatedBy;
use GDO\Core\GDT_CreatedAt;
use GDO\UI\GDT_Title;
use GDO\Language\GDT_Language;
use GDO\Core\GDT_Checkbox;
use GDO\Date\GDT_Date;
use GDO\Date\Time;
use GDO\Core\GDT_DeletedBy;
use GDO\Core\GDT_DeletedAt;
use GDO\UI\GDT_Message;
use GDO\User\GDO_User;
use GDO\User\GDT_Level;
use GDO\Core\GDT_Template;
use GDO\Core\GDT_UInt;

final class GDO_Poll extends GDO
{
	
	public function isTestable(): bool
	{
		return false;
	}
	
	public function gdoColumns() : array
	{
		return [
			GDT_AutoInc::make('poll_id'),
			
			GDT_Title::make('poll_question')->notNull()->label('question'),
			GDT_Message::make('poll_description')->label('description'),
			GDT_Language::make('poll_language')->notNull()->initialCurrent(),
			
			GDT_Checkbox::make('poll_multiple_choice')->notNull()->emptyLabel('choose_multiple_choice')->label('multiple_choice'),
			
			GDT_Date::make('poll_expires')->notNull()->label('expires'),
			
			GDT_Checkbox::make('poll_guests')->initial('0'),
			GDT_Level::make('poll_level')->label('poll_level')->writeable(true),
			
			GDT_UInt::make('poll_usercount')->notNull()->initial('0'),
			
			GDT_CreatedBy::make('poll_creator'),
			GDT_CreatedAt::make('poll_created'),
		
			GDT_DeletedBy::make('poll_deletor'),
			GDT_DeletedAt::make('poll_deleted'),
		];
	}
	
	##############
	### Getter ###
	##############
	public function isExpired(): bool
	{
		return Time::getAge($this->gdoVar('poll_expires')) > 0;
	}
	
	public function isMultipleChoice(): bool
	{
		return $this->gdoValue('poll_multiple_choice');
	}
	
	private function descrColumn(): GDT_Message
	{
		return $this->gdoColumn('poll_description');
	}
	
	public function getCreator(): GDO_User
	{
		return $this->gdoValue('poll_creator');
	}
	
	############
	### HREF ###
	############
	public function hrefView(): string
	{
		return href('Poll', 'View', "&id={$this->getID()}");
	}
	
	public function hrefAnswer(): string
	{
		return href('Poll', 'Answer', "&poll={$this->getID()}");
	}
	
	##############
	### Render ###
	##############
	public function renderTitle(): string
	{
		return $this->gdoDisplay('poll_question');
	}
	
	public function renderDescription(): string
	{
		return $this->descrColumn()->getVarOutput();
	}
	
	public function renderList(): string
	{
		return GDT_Template::php('Poll', 'poll_list.php', ['gdo' => $this]);
	}
	
	##################
	### Permission ###
	##################
	public function hasAnswered(GDO_User $user): bool
	{
		return GDO_PollAnswer::hasAnswered($user, $this);
	}
	
	###############
	### Answers ###
	###############
	/**
	 * Get all choices for this poll.
	 * @return GDO_PollChoice[]
	 */
	public function getChoices(string $order='RAND()'): array
	{
		return GDO_PollChoice::getChoices($this, $order);
	}
	
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
	
	##############
	### Static ###
	##############
	public static function numActivePolls(): int
	{
		$now = Time::getDateWithoutTime();
		$conditions = "poll_deleted IS NULL AND poll_expires > '{$now}'";
		return self::table()->countWhere($conditions);
	}
	
}
