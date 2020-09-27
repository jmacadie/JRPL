<h1>Fixtures</h1>
<div class="panel-group" id="accordionFilters">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordionFilters" href="#collapseFilters">
          Filters
        </a>
      </h4>
    </div>
    <div id="collapseFilters" class="panel-collapse collapse">
      <div class="panel-body">
        <div class="checkbox">
          <label>
          <input type="checkbox" id="ckbPlayedMatches" value=""<?php if($excPlayed) htmlout(" checked");?>>
          Exclude played matches
          </label>
        </div>
        <div class="checkbox">
          <label>
          <input type="checkbox" id="ckbPredictedMatches" value=""<?php if($excPredicted) htmlout(" checked");?>>
          Exclude predicted matches
          </label>
        </div>
        <hr>
        <h3>Pick Teams</h3>
        <div class="panel-group" id="accordionTeam">
          <div class="panel panel-default">
            <div class="panel-heading">
              <a data-toggle="collapse" data-parent="#accordionTeam" href="#collapseTeam">
                Hide / unhide
              </a>
            </div>
            <div id="collapseTeam" class="panel-collapse collapse">
              <div class="panel-body">
                <button class="btn btn-sm btn-primary" type="submit" id="btnSelectTeam" data-mode="unselect">Unselect all</button>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbT1" value=""<?php if($t1) htmlout(" checked");?>>
                  <strong>Arsenal</strong><br />
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbT2" value=""<?php if($t2) htmlout(" checked");?>>
                  <strong>Aston Villa</strong><br />
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbT3" value=""<?php if($t3) htmlout(" checked");?>>
                  <strong>Brighton &amp; Hove Albion</strong><br />
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbT4" value=""<?php if($t4) htmlout(" checked");?>>
                  <strong>Burnley</strong><br />
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbT5" value=""<?php if($t5) htmlout(" checked");?>>
                  <strong>Chelsea</strong><br />
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbT6" value=""<?php if($t6) htmlout(" checked");?>>
                  <strong>Crystal Palace</strong><br />
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbT7" value=""<?php if($t7) htmlout(" checked");?>>
                  <strong>Everton</strong><br />
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbT8" value=""<?php if($t8) htmlout(" checked");?>>
                  <strong>Fulham</strong><br />
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbT9" value=""<?php if($t9) htmlout(" checked");?>>
                  <strong>Leeds United</strong><br />
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbT10" value=""<?php if($t10) htmlout(" checked");?>>
                  <strong>Leicester City</strong><br />
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbT11" value=""<?php if($t11) htmlout(" checked");?>>
                  <strong>Liverpool</strong><br />
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbT12" value=""<?php if($t12) htmlout(" checked");?>>
                  <strong>Manchester City</strong><br />
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbT13" value=""<?php if($t13) htmlout(" checked");?>>
                  <strong>Manchester United</strong><br />
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbT14" value=""<?php if($t14) htmlout(" checked");?>>
                  <strong>Newcastle United</strong><br />
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbT15" value=""<?php if($t15) htmlout(" checked");?>>
                  <strong>Sheffield United</strong><br />
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbT16" value=""<?php if($t16) htmlout(" checked");?>>
                  <strong>Southampton</strong><br />
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbT17" value=""<?php if($t17) htmlout(" checked");?>>
                  <strong>Tottenham Hotspur</strong><br />
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbT18" value=""<?php if($t18) htmlout(" checked");?>>
                  <strong>West Bromwich Albion</strong><br />
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbT19" value=""<?php if($t19) htmlout(" checked");?>>
                  <strong>West Ham United</strong><br />
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbT20" value=""<?php if($t20) htmlout(" checked");?>>
                  <strong>Wolverhampton Wanderers</strong><br />
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <hr>
        <h3>Select Game Week</h3>
        <div class="panel-group" id="accordionWeek">
          <div class="panel panel-default">
            <div class="panel-heading">
              <a data-toggle="collapse" data-parent="#accordionWeek" href="#collapseWeek">
                Hide / unhide
              </a>
            </div>
            <div id="collapseWeek" class="panel-collapse collapse">
              <div class="panel-body">
                <button class="btn btn-sm btn-primary" type="submit" id="btnSelectWeek" data-mode="unselect">Unselect all</button>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW1" value=""<?php if($gw1) htmlout(" checked");?>>
                  <strong>Game Week 1</strong><br />
                  12<sup>th</sup> September 2020 - 14<sup>th</sup> September 2020
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW2" value=""<?php if($gw2) htmlout(" checked");?>>
                  <strong>Game Week 2</strong><br />
                  19<sup>th</sup> September 2020 - 21<sup>st</sup> September 2020
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW3" value=""<?php if($gw3) htmlout(" checked");?>>
                  <strong>Game Week 3</strong><br />
                  26<sup>th</sup> September 2020 - 28<sup>th</sup> September 2020
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW4" value=""<?php if($gw4) htmlout(" checked");?>>
                  <strong>Game Week 4</strong><br />
                  3<sup>rd</sup> October 2020 - 4<sup>th</sup> October 2020
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW5" value=""<?php if($gw5) htmlout(" checked");?>>
                  <strong>Game Week 5</strong><br />
                  17<sup>th</sup> October 2020 - 17<sup>th</sup> October 2020
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW6" value=""<?php if($gw6) htmlout(" checked");?>>
                  <strong>Game Week 6</strong><br />
                  24<sup>th</sup> October 2020 - 24<sup>st</sup> October 2020
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW7" value=""<?php if($gw7) htmlout(" checked");?>>
                  <strong>Game Week 7</strong><br />
                  31<sup>st</sup> October 2020 - 31<sup>st</sup> October 2020
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW8" value=""<?php if($gw8) htmlout(" checked");?>>
                  <strong>Game Week 8</strong><br />
                  7<sup>th</sup> November 2020 - 7<sup>th</sup> November 2020
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW9" value=""<?php if($gw9) htmlout(" checked");?>>
                  <strong>Game Week 9</strong><br />
                  21<sup>st</sup> November 2020 - 21<sup>st</sup> November 2020
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW10" value=""<?php if($gw10) htmlout(" checked");?>>
                  <strong>Game Week 10</strong><br />
                  28<sup>th</sup> November 2020 - 28<sup>th</sup> November 2020
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW11" value=""<?php if($gw11) htmlout(" checked");?>>
                  <strong>Game Week 11</strong><br />
                  5<sup>th</sup> December 2020 - 5<sup>th</sup> December 2020
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW12" value=""<?php if($gw12) htmlout(" checked");?>>
                  <strong>Game Week 12</strong><br />
                  12<sup>th</sup> December 2020 - 13<sup>th</sup> December 2020
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW13" value=""<?php if($gw13) htmlout(" checked");?>>
                  <strong>Game Week 13</strong><br />
                  15<sup>th</sup> December 2020 - 16<sup>th</sup> December 2020
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW14" value=""<?php if($gw14) htmlout(" checked");?>>
                  <strong>Game Week 14</strong><br />
                  19<sup>th</sup> December 2020 - 19<sup>th</sup> December 2020
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW15" value=""<?php if($gw15) htmlout(" checked");?>>
                  <strong>Game Week 15</strong><br />
                  26<sup>th</sup> December 2020 - 26<sup>th</sup> December 2020
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW16" value=""<?php if($gw16) htmlout(" checked");?>>
                  <strong>Game Week 16</strong><br />
                  28<sup>th</sup> December 2020 - 28<sup>th</sup> December 2020
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW17" value=""<?php if($gw17) htmlout(" checked");?>>
                  <strong>Game Week 17</strong><br />
                  2<sup>nd</sup> January 2021 - 2<sup>nd</sup> January 2021
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW18" value=""<?php if($gw18) htmlout(" checked");?>>
                  <strong>Game Week 18</strong><br />
                  12<sup>th</sup> January 2021 - 13<sup>th</sup> January 2021
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW19" value=""<?php if($gw19) htmlout(" checked");?>>
                  <strong>Game Week 19</strong><br />
                  16<sup>th</sup> January 2021 - 16<sup>th</sup> January 2021
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW20" value=""<?php if($gw20) htmlout(" checked");?>>
                  <strong>Game Week 20</strong><br />
                  26<sup>th</sup> January 2021 - 27<sup>th</sup> January 2021
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW21" value=""<?php if($gw21) htmlout(" checked");?>>
                  <strong>Game Week 21</strong><br />
                  30<sup>th</sup> January 2021 - 30<sup>th</sup> January 2021
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW22" value=""<?php if($gw22) htmlout(" checked");?>>
                  <strong>Game Week 22</strong><br />
                  2<sup>nd</sup> February 2021 - 3<sup>rd</sup> February 2021
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW23" value=""<?php if($gw23) htmlout(" checked");?>>
                  <strong>Game Week 23</strong><br />
                  6<sup>th</sup> February 2021 - 6<sup>th</sup> February 2021
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW24" value=""<?php if($gw24) htmlout(" checked");?>>
                  <strong>Game Week 24</strong><br />
                  13<sup>th</sup> February 2021 - 13<sup>th</sup> February 2021
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW25" value=""<?php if($gw25) htmlout(" checked");?>>
                  <strong>Game Week 25</strong><br />
                  20<sup>th</sup> February 2021 - 20<sup>th</sup> February 2021
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW26" value=""<?php if($gw26) htmlout(" checked");?>>
                  <strong>Game Week 26</strong><br />
                  27<sup>th</sup> February 2021 - 27<sup>th</sup> February 2021
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW27" value=""<?php if($gw27) htmlout(" checked");?>>
                  <strong>Game Week 27</strong><br />
                  6<sup>th</sup> March 2021 - 6<sup>st</sup> March 2021
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW28" value=""<?php if($gw28) htmlout(" checked");?>>
                  <strong>Game Week 28</strong><br />
                  13<sup>th</sup> March 2021 - 13<sup>th</sup> March 2021
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW29" value=""<?php if($gw29) htmlout(" checked");?>>
                  <strong>Game Week 29</strong><br />
                  20<sup>th</sup> March 2021 - 20<sup>th</sup> March 2021
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW30" value=""<?php if($gw30) htmlout(" checked");?>>
                  <strong>Game Week 30</strong><br />
                  3<sup>rd</sup> April 2021 - 3<sup>rd</sup> April 2021
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW31" value=""<?php if($gw31) htmlout(" checked");?>>
                  <strong>Game Week 31</strong><br />
                  10<sup>th</sup> April 2021 - 10<sup>th</sup> April 2021
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW32" value=""<?php if($gw32) htmlout(" checked");?>>
                  <strong>Game Week 32</strong><br />
                  17<sup>th</sup> April 2021 - 17<sup>th</sup> April 2021
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW33" value=""<?php if($gw33) htmlout(" checked");?>>
                  <strong>Game Week 33</strong><br />
                  24<sup>th</sup> April 2021 - 24<sup>th</sup> April 2021
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW34" value=""<?php if($gw34) htmlout(" checked");?>>
                  <strong>Game Week 34</strong><br />
                  1<sup>st</sup> May 2021 - 1<sup>st</sup> May 2021
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW35" value=""<?php if($gw35) htmlout(" checked");?>>
                  <strong>Game Week 35</strong><br />
                  8<sup>th</sup> May 2021 - 8<sup>th</sup> May 2021
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW36" value=""<?php if($gw36) htmlout(" checked");?>>
                  <strong>Game Week 36</strong><br />
                  11<sup>th</sup> May 2021 - 12<sup>th</sup> May 2021
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW37" value=""<?php if($gw37) htmlout(" checked");?>>
                  <strong>Game Week 37</strong><br />
                  15<sup>th</sup> May 2021 - 15<sup>th</sup> May 2021
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGW38" value=""<?php if($gw38) htmlout(" checked");?>>
                  <strong>Game Week 38</strong><br />
                  23<sup>rd</sup> May 2021 - 23<sup>rd</sup> May 2021
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit" id="btnUpdateMatches">Update</button>
      </div>
    </div>
  </div>
</div>
<div id="matchesMessage"></div>
<div id="matches"></div>
