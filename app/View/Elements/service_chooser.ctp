          <div id="service_chooser" class="modal hide fade">
            <div class="modal-header">
              <button class="close" data-dismiss="modal">&times;</button>
              <h3>Choose Cable/Satelite Service</h3>
            </div>
            <div class="modal-body">
    <input type="text" id="search_zip" />
    <input type="button" id="search_button" value="Search" onclick="ServiceChooser.submitZip();" />
    <div id="zip_results"></div>
            </div>
            <div class="modal-footer">
              <a href="#" class="btn" data-dismiss="modal" >Close</a>
              <a href="#" class="btn btn-primary">Save changes</a>
            </div>
          </div>
