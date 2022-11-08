<?php
namespace GDO\Poll\tpl;
/** @var $field \GDO\Poll\GDT_PollOutcome **/
/** @var $gdo \GDO\Poll\GDO_PollChoice **/
?>
<div class="poll-option">
  <label><?=$gdo->renderTitle()?></label>
  <table>
    <tr>
      <td><?=$gdo->getAmount()?></td>
      <td>
        <span></span>
        <span style="width: 25%;"></span>
      </td>
      <td>25%</td>
    </tr>
  </table>
</div>
