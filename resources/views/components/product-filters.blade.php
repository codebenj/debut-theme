<div class="Polaris-FormLayout layout-item mb">
  <div role="group" class="Polaris-FormLayout--condensed">
    <div class="Polaris-FormLayout__Items">

      <!-- search -->
      <div class="Polaris-FormLayout__Item flex-fill w-100">
        <div class="">
          <!-- <div class="Polaris-Labelled__LabelWrapper">
            <div class="Polaris-Label"><label id="searchLabel" for="search" class="Polaris-Label__Text">Search</label></div>
          </div> -->
          <div class="Polaris-Connected">
            <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
              <div class="Polaris-TextField">
                <div class="Polaris-TextField__Prefix" id="PolarisTextField2Prefix">
                  <span class="Polaris-Filters__SearchIcon">
                    <span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                        <path d="M8 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8m9.707 4.293l-4.82-4.82A5.968 5.968 0 0 0 14 8 6 6 0 0 0 2 8a6 6 0 0 0 6 6 5.968 5.968 0 0 0 3.473-1.113l4.82 4.82a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414" fill-rule="evenodd"></path>
                      </svg>
                    </span>
                  </span>
                </div>
                <input id="search" name="q" placeholder="Search products" class="Polaris-TextField__Input Polaris-TextField__Input--hasClearButton" aria-labelledby="PolarisTextField2Label PolarisTextField2Prefix" aria-invalid="false" aria-multiline="false" value="">
                <div class="Polaris-TextField__Backdrop"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{--<!-- profit margin -->
      <div class="Polaris-FormLayout__Item flex-fill w-100">
        <div class="">
          <div class="Polaris-Labelled__LabelWrapper">
            <div class="Polaris-Label"><label id="PolarisRangeSlider2Label" for="PolarisRangeSlider2" class="Polaris-Label__Text">Profit margin</label></div>
          </div>
          <div class="Polaris-RangeSlider-SingleThumb" style="--Polaris-RangeSlider-min:0; --Polaris-RangeSlider-max:100; --Polaris-RangeSlider-current:32; --Polaris-RangeSlider-progress:32%; --Polaris-RangeSlider-output-factor:0.18;">
            <div class="Polaris-RangeSlider-SingleThumb__InputWrapper">
              <input type="range" class="Polaris-RangeSlider-SingleThumb__Input" id="PolarisRangeSlider2" name="PolarisRangeSlider2" min="0" max="100" step="1" aria-valuemin="0" aria-valuemax="100" aria-valuenow="32" aria-invalid="false" value="32"><output for="PolarisRangeSlider2" class="Polaris-RangeSlider-SingleThumb__Output">
                <div class="Polaris-RangeSlider-SingleThumb__OutputBubble">
                  <span class="Polaris-RangeSlider-SingleThumb__OutputText">32</span>
                </div>
              </output>
            </div>
          </div>
        </div>
      </div>--}}

      <!-- category -->
      <div class="Polaris-FormLayout__Item">
        <div class="">
          <div class="Polaris-Labelled__LabelWrapper">
            <div class="Polaris-Label"><label id="SelectCategoryLabel" for="SelectCategory" class="Polaris-Label__Text">Category</label></div>
          </div>
          <div class="Polaris-Select">
            <select id="SelectCategory" class="Polaris-Select__Input filter-change" aria-invalid="false">
              <option value="">All</option>
              <option value="fashion">Fashion</option>
              <option value="health-beauty">Health & Beauty</option>
              <option value="home-garden">Home & Garden</option>
              <option value="pet-accessories">Pet Accessories</option>
              <option value="electronics">Electronics</option>
              <option value="baby-kids">Baby & Kids</option>
              <option value="kitchen-household">Kitchen & Household</option>
            </select>
            <div class="Polaris-Select__Content" aria-hidden="true">
              <span class="Polaris-Select__SelectedOption"></span>
              <span class="Polaris-Select__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true"><path d="M13 8l-3-3-3 3h6zm-.1 4L10 14.9 7.1 12h5.8z" fill-rule="evenodd"></path></svg></span></span>
            </div>
            <div class="Polaris-Select__Backdrop"></div>
          </div>
        </div>
      </div>

      <!-- price margin -->
      <div class="Polaris-FormLayout__Item">
        <div class="">
          <div class="Polaris-Labelled__LabelWrapper">
            <div class="Polaris-Label"><label id="SelectProfitLabel" for="SelectProfit" class="Polaris-Label__Text">Profit margin</label></div>
          </div>
          <div class="Polaris-Select">
            <select id="SelectProfit" class="Polaris-Select__Input filter-change" aria-invalid="false">
              <option value="">All</option>
              <option value="0-10">$0-$10</option>
              <option value="10-20">$10-$20</option>
              <option value="20-30">$20-$30</option>
              <option value="30">$30+</option>
            </select>
            <div class="Polaris-Select__Content" aria-hidden="true">
              <span class="Polaris-Select__SelectedOption"></span>
              <span class="Polaris-Select__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true"><path d="M13 8l-3-3-3 3h6zm-.1 4L10 14.9 7.1 12h5.8z" fill-rule="evenodd"></path></svg></span></span>
            </div>
            <div class="Polaris-Select__Backdrop"></div>
          </div>
        </div>
      </div>

      <!-- oportunity level -->
      <div class="Polaris-FormLayout__Item">
        <div class="">
          <div class="Polaris-Labelled__LabelWrapper">
            <div class="Polaris-Label"><label id="SelectSaturationLabel" for="SelectSaturation" class="Polaris-Label__Text">Oportunity level</label></div>
          </div>
          <div class="Polaris-Select">
            <select id="SelectSaturation" class="Polaris-Select__Input filter-change" aria-invalid="false">
              <!-- <option value="">All</option> -->
              <option value="bronze" @if($alladdons_plan == $starter) selected @endif>Bronze</option>
              <option value="silver" @if($alladdons_plan == $hustler) selected @endif @if($alladdons_plan == $starter) disabled="" @endif>Silver</option>
              <option value="gold" @if($alladdons_plan == $guru) selected @endif @if($alladdons_plan == $hustler || $alladdons_plan == $starter) disabled="" @endif>Gold</option>
            </select>
            <div class="Polaris-Select__Content" aria-hidden="true">
              <span class="Polaris-Select__SelectedOption"></span>
              <span class="Polaris-Select__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true"><path d="M13 8l-3-3-3 3h6zm-.1 4L10 14.9 7.1 12h5.8z" fill-rule="evenodd"></path></svg></span></span>
            </div>
            <div class="Polaris-Select__Backdrop"></div>
          </div>
        </div>
      </div>


      {{--<!-- sort by -->
      <div class="Polaris-FormLayout__Item">
        <div class="">
          <div class="Polaris-Labelled__LabelWrapper">
            <div class="Polaris-Label"><label id="SelectSortByLabel" for="SelectSortBy" class="Polaris-Label__Text">Product date</label></div>
          </div>
          <div class="Polaris-Select">
            <select id="SelectSortBy" class="Polaris-Select__Input" aria-invalid="false">
              <option value="DATE_MODIFIED_DESC">Newest</option>
              <option value="DATE_MODIFIED_ASC">Oldest</option>
            </select>
            <div class="Polaris-Select__Content" aria-hidden="true">
              <span class="Polaris-Select__SelectedOption"></span>
              <span class="Polaris-Select__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true"><path d="M13 8l-3-3-3 3h6zm-.1 4L10 14.9 7.1 12h5.8z" fill-rule="evenodd"></path></svg></span></span>
            </div>
            <div class="Polaris-Select__Backdrop"></div>
          </div>
        </div>
      </div>--}}

    </div>
  </div>
</div>
