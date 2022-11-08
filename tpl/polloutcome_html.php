<?php
namespace GDO\Poll\tpl;
/** @var $field \GDO\Poll\GDT_PollOutcome **/
/** @var $gdo \GDO\Poll\GDO_PollChoice **/
?>
<div class="gdt-poll-outcome">
  <label><?=$field->renderOwnVoteIcon()?><?=$gdo->renderTitle()?></label>
  <table>
    <tr>
      <td><?=$gdo->getAmount()?></td>
      <td>
        <em></em>
        <em style="width: <?=$gdo->getPercent()?>%;"></em>
      </td>
      <td><?=$gdo->renderPercent()?></td>
    </tr>
  </table>
</div>
