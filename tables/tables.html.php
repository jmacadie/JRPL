<h1>Tables</h1>
<div id="messageTables"></div>
<hr>
<h3>Overall</h3>
<?php
  $sID = 'OverallCont';
  if (isset($resultLeague))
    $rLeague = $resultLeague;
  include 'table.html.php';
?>
<hr>
<h3>Game Week</h3>
<form class="form-horizontal">
  <div class="form-group">
    <div class="col-sm-4">
      <select class="form-control" id="gameWeek">
        <option value="1"<?php if($gw==1) echo(" selected");?>>Week 1: 12th Sep - 14th Sep</option>
        <option value="2"<?php if($gw==2) echo(" selected");?>>Week 2: 19th Sep - 21st Sep</option>
        <option value="3"<?php if($gw==3) echo(" selected");?>>Week 3: 26th Sep - 28th Sep</option>
        <option value="4"<?php if($gw==4) echo(" selected");?>>Week 4: 3rd Oct - 3rd Oct</option>
        <option value="5"<?php if($gw==5) echo(" selected");?>>Week 5: 17th Oct - 17th Oct</option>
        <option value="6"<?php if($gw==6) echo(" selected");?>>Week 6: 24th Oct - 24th Oct</option>
        <option value="7"<?php if($gw==7) echo(" selected");?>>Week 7: 31st Oct - 31st Oct</option>
        <option value="8"<?php if($gw==8) echo(" selected");?>>Week 8: 7th Nov - 7th Nov</option>
        <option value="9"<?php if($gw==9) echo(" selected");?>>Week 9: 21st Nov - 21st Nov</option>
        <option value="10"<?php if($gw==10) echo(" selected");?>>Week 10: 28th Nov - 28th Nov</option>
        <option value="11"<?php if($gw==11) echo(" selected");?>>Week 11: 5th Dec - 5th Dec</option>
        <option value="12"<?php if($gw==12) echo(" selected");?>>Week 12: 12th Dec - 13th Dec</option>
        <option value="13"<?php if($gw==13) echo(" selected");?>>Week 13: 15th Dec - 16th Dec</option>
        <option value="14"<?php if($gw==14) echo(" selected");?>>Week 14: 19th Dec - 19th Dec</option>
        <option value="15"<?php if($gw==15) echo(" selected");?>>Week 15: 26th Dec - 26th Dec</option>
        <option value="16"<?php if($gw==16) echo(" selected");?>>Week 16: 28th Dec - 28th Dec</option>
        <option value="17"<?php if($gw==17) echo(" selected");?>>Week 17: 2nd Jan - 2nd Jan</option>
        <option value="18"<?php if($gw==18) echo(" selected");?>>Week 18: 12th Jan - 13th Jan</option>
        <option value="19"<?php if($gw==19) echo(" selected");?>>Week 19: 16th Jan - 16th Jan</option>
        <option value="20"<?php if($gw==20) echo(" selected");?>>Week 20: 26th Jan - 27th Jan</option>
        <option value="21"<?php if($gw==21) echo(" selected");?>>Week 21: 30th Jan - 30th Jan</option>
        <option value="22"<?php if($gw==22) echo(" selected");?>>Week 22: 2nd Feb - 3rd Feb</option>
        <option value="23"<?php if($gw==23) echo(" selected");?>>Week 23: 6th Feb - 6th Feb</option>
        <option value="24"<?php if($gw==24) echo(" selected");?>>Week 24: 13th Feb - 13th Feb</option>
        <option value="25"<?php if($gw==25) echo(" selected");?>>Week 25: 20th Feb - 20th Feb</option>
        <option value="26"<?php if($gw==26) echo(" selected");?>>Week 26: 27th Feb - 27th Feb</option>
        <option value="27"<?php if($gw==27) echo(" selected");?>>Week 27: 6th Mar - 6th Mar</option>
        <option value="28"<?php if($gw==28) echo(" selected");?>>Week 28: 13th Mar - 13th Mar</option>
        <option value="29"<?php if($gw==29) echo(" selected");?>>Week 29: 20th Mar - 20th Mar</option>
        <option value="30"<?php if($gw==30) echo(" selected");?>>Week 30: 3rd Apr - 3rd Apr</option>
        <option value="31"<?php if($gw==31) echo(" selected");?>>Week 31: 10th Apr - 10th Apr</option>
        <option value="32"<?php if($gw==32) echo(" selected");?>>Week 32: 17th Apr - 17th Apr</option>
        <option value="33"<?php if($gw==33) echo(" selected");?>>Week 33: 24th Apr - 24th Apr</option>
        <option value="34"<?php if($gw==34) echo(" selected");?>>Week 34: 1st May - 1st May</option>
        <option value="35"<?php if($gw==35) echo(" selected");?>>Week 35: 8th May - 8th May</option>
        <option value="36"<?php if($gw==36) echo(" selected");?>>Week 36: 11th May - 12th May</option>
        <option value="37"<?php if($gw==37) echo(" selected");?>>Week 37: 15th May - 15th May</option>
        <option value="38"<?php if($gw==38) echo(" selected");?>>Week 38: 23rd May - 23rd May</option>
      </select>
    </div>
  </div>
</form>
<?php
  $sID = 'GWCont';
  if (isset($resultGWLeague))
    $rLeague = $resultGWLeague;
  include 'table.html.php';
?>
