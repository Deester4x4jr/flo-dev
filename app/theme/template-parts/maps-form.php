<div id="map-form" class="simple-locator-form hide">
    <form id="locator-form" class="allow-empty">
      <div class="wpsl-error alert alert-error" style="display:none;"></div>
      <div class="address-input form-field">
        <input type="text" name="address" class="address wpsl-search-form" placeholder="Enter a search location" />
        <button type="submit" class="wpslsubmit"><i class="fa fa-search"></i></i></button>
      </div>
      <div class="distance form-field">
        <select name="distance" class="distanceselect">
          <option value="5">5 Miles</option>
          <option value="8">8 Miles</option>
          <option value="10" selected="selected">10 Miles</option>
          <option value="15">15 Miles</option>
          <option value="20">20 Miles</option>
          <option value="25">25 Miles</option>
          <option value="50">50 Miles</option>
          <option value="100">100 Miles</option>
        </select>
      </div>

      <div class="submit">
        <input type="hidden" name="latitude" class="latitude" />
        <input type="hidden" name="longitude" class="longitude" />
        <input type="hidden" name="unit" value="miles" class="unit" />
      </div>
    </form>
</div><!-- .simple-locator-form -->
