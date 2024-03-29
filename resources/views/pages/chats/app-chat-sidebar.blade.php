<!-- Admin user profile area -->
<div class="chat-profile-sidebar">
  <header class="chat-profile-header">
    <span class="close-icon">
      <i data-feather="x"></i>
    </span>
    <!-- User Information -->
    <div class="header-profile-sidebar">
      <div class="avatar box-shadow-1 avatar-xl avatar-border">
        <img src="{{asset('images/portrait/small/avatar-s-11.jpg')}}" alt="user_avatar" />
        <span class="avatar-status-online avatar-status-xl"></span>
      </div>
      <h4 class="chat-user-name">John Doe</h4>
      <span class="user-post">Admin</span>
    </div>
    <!--/ User Information -->
  </header>
  <!-- User Details start -->
  <div class="profile-sidebar-area">
    <h6 class="section-label mb-1">About</h6>
    <div class="about-user">
      <textarea
        data-length="120"
        class="form-control char-textarea"
        id="textarea-counter"
        rows="5"
        placeholder="About User"
      >Dessert chocolate cake lemon drops jujubes. Biscuit cupcake ice cream bear claw brownie brownie marshmallow.</textarea>
      <small class="counter-value float-end"><span class="char-count">108</span> / 120 </small>
    </div>
    <!-- To set user status -->
    <h6 class="section-label mb-1 mt-3">Status</h6>
    <ul class="list-unstyled user-status">
      <li class="pb-1">
        <div class="form-check form-check-success">
          <input
            type="radio"
            id="activeStatusRadio"
            name="userStatus"
            class="form-check-input"
            value="online"
            checked
          />
          <label class="form-check-label ms-25" for="activeStatusRadio">Active</label>
        </div>
      </li>
      <li class="pb-1">
        <div class="form-check form-check-danger">
          <input type="radio" id="dndStatusRadio" name="userStatus" class="form-check-input" value="busy" />
          <label class="form-check-label ms-25" for="dndStatusRadio">Do Not Disturb</label>
        </div>
      </li>
      <li class="pb-1">
        <div class="form-check form-check-warning">
          <input type="radio" id="awayStatusRadio" name="userStatus" class="form-check-input" value="away" />
          <label class="form-check-label ms-25" for="awayStatusRadio">Away</label>
        </div>
      </li>
      <li class="pb-1">
        <div class="form-check form-check-secondary">
          <input type="radio" id="offlineStatusRadio" name="userStatus" class="form-check-input" value="offline" />
          <label class="form-check-label ms-25" for="offlineStatusRadio">Offline</label>
        </div>
      </li>
    </ul>
    <!--/ To set user status -->

    <!-- User settings -->
    <h6 class="section-label mb-1 mt-2">Settings</h6>
    <ul class="list-unstyled">
      <li class="d-flex justify-content-between align-items-center mb-1">
        <div class="d-flex align-items-center">
          <i data-feather="check-square" class="me-75 font-medium-3"></i>
          <span class="align-middle">Two-step Verification</span>
        </div>
        <div class="form-check form-switch me-0">
          <input type="checkbox" class="form-check-input" id="customSwitch1" checked />
          <label class="form-check-label" for="customSwitch1"></label>
        </div>
      </li>
      <li class="d-flex justify-content-between align-items-center mb-1">
        <div class="d-flex align-items-center">
          <i data-feather="bell" class="me-75 font-medium-3"></i>
          <span class="align-middle">Notification</span>
        </div>
        <div class="form-check form-switch me-0">
          <input type="checkbox" class="form-check-input" id="customSwitch2" />
          <label class="form-check-label" for="customSwitch2"></label>
        </div>
      </li>
      <li class="mb-1 d-flex align-items-center cursor-pointer">
        <i data-feather="user" class="me-75 font-medium-3"></i>
        <span class="align-middle">Invite Friends</span>
      </li>
      <li class="d-flex align-items-center cursor-pointer">
        <i data-feather="trash" class="me-75 font-medium-3"></i>
        <span class="align-middle">Delete Account</span>
      </li>
    </ul>
    <!--/ User settings -->

    <!-- Logout Button -->
    <div class="mt-3">
      <button class="btn btn-primary">
        <span>Logout</span>
      </button>
    </div>
    <!--/ Logout Button -->
  </div>
  <!-- User Details end -->
</div>
<!--/ Admin user profile area -->

<!-- Chat Sidebar area -->
<div class="sidebar-content">
  <span class="sidebar-close-icon">
    <i data-feather="x"></i>
  </span>
  <!-- Sidebar header start -->
  <div class="chat-fixed-search">
    <div class="d-flex align-items-center w-100">
      <div class="sidebar-profile-toggle">
        <div class="avatar avatar-border">
          <div class="avatar" style="background-color: #{{ \App\Helpers\Helper::generateAvatarColor($company->owner->id) }}">
            <div class="avatar-content">{{ \App\Helpers\Helper::getInitialName($company->owner->id) }}</div>
          </div>
        </div>
      </div>
      <div class="input-group input-group-merge ms-1 w-100">
        <span class="input-group-text round"><i data-feather="search" class="text-muted"></i></span>
        <input
          type="text"
          class="form-control round"
          id="chat-search"
          placeholder="Search or start a new chat"
          aria-label="Search..."
          aria-describedby="chat-search"
        />
      </div>
    </div>
  </div>
  <!-- Sidebar header end -->

  <!-- Sidebar Users start -->
  <div id="users-list" class="chat-user-list-wrapper list-group">
    <h4 class="chat-list-title">Chats</h4>
    <ul class="chat-users-list chat-list media-list">
      <li class="no-results">
        <h6 class="mb-0">No Chats Found</h6>
      </li>
    </ul>
    <h4 class="chat-list-title">Contacts</h4>
    <ul class="chat-users-list contact-list media-list">
      <li class="no-results">
        <h6 class="mb-0">No Contacts Found</h6>
      </li>
    </ul>
  </div>
  <!-- Sidebar Users end -->
</div>
<!--/ Chat Sidebar area -->
