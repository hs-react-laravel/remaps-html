<div class="card">
  <div class="card-header">
    <h4 class="card-title">Contact Us</h4>
  </div>
  <div class="card-body">

    <div class="row mb-1">
      <div class="col-12">
        <label class="form-label" for="note_to_engineer">Message</label>
        <textarea
          class="form-control"
          id="message"
          rows="5"
          name="message"
        ></textarea>
      </div>
    </div>

    <div class="row mb-1">
      <div class="col-12">
        <div style="margin-bottom: 2px; cursor: pointer">
          <label for="document" class="form-label">File</label>
          <div class="input-group" onclick="onUpload()">
            <span class="input-group-text">Choose File</span>
            <input
              type="text"
              class="form-control"
              id="file_name"
              name="file_name"
              readonly />
            <input
              type="hidden"
              class="form-control"
              id="document"
              name="document"
              readonly />
            <input
              type="hidden"
              class="form-control"
              id="remain_file"
              name="remain_file"
              readonly />
          </div>
        </div>
        <div class="progress progress-bar-{{ substr($styling['navbarColor'], 3) }}" style="display: none">
          <div
            class="progress-bar progress-bar-striped progress-bar-animated"
            role="progressbar"
            aria-valuenow="0"
            aria-valuemin="0"
            aria-valuemax="100"
          ></div>
        </div>
      </div>
    </div>

    <div class="col-12">
      <button type="submit" class="btn btn-primary me-1">Send</button>
    </div>
  </div>
</div>
