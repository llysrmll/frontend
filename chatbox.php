<?php
require_once __DIR__ . '/config.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chatbox - StyliCycle</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <nav class="top-nav">
    <div class="nav-links">
      <a href="home.php">Home</a>
      <a href="rental.php">Rentals</a>
      <a href="delivery.php">Delivery</a>
      <a href="chatbox.php" class="active">Messages</a>
      <a href="profile.php">Profile</a>
    </div>
    <div class="nav-actions">
      <div class="nav-chat-input">
        <input id="navChatInput" type="text" placeholder="Ask chat...">
        <button type="button" id="navChatButton">➤</button>
      </div>
      <button type="button" class="nav-button" id="navNotificationBtn">Notifications</button>
      <a class="nav-button" href="logout.php">Logout</a>
    </div>
  </nav>

  <main class="container chat-layout">
    <aside class="side-panel">
      <h3>Messages</h3>
      <div class="notification-list">
        <h4>Inbox updates</h4>
        <ul id="chatNotifications">
          <li>Website partnership update<span>Just now</span></li>
          <li>New rental request<span>2 min ago</span></li>
          <li>Message from admin<span>25 min ago</span></li>
        </ul>
      </div>
      <button type="button" id="chatViewAllBtn" class="secondary-button">View all</button>
      <button type="button" id="chatNewReqBtn" class="secondary-button">New request</button>
    </aside>

    <section class="chatbox">
      <div class="chat-header">
        <div class="chat-avatar">S</div>
        <div class="chat-info">
          <h2>StyliCycle Support</h2>
          <span>Online now</span>
        </div>
        <div class="chat-user-actions">
          <span class="chat-user-name">You</span>
          <button type="button" class="chat-action-button" id="chatPostItemBtn">Post Item</button>
        </div>
      </div>

      <div class="chat-window">
        <div class="message bot">
          <div class="message-text">Hi! Welcome back. Need help with a rental or delivery?</div>
        </div>
      </div>

      <form id="chatForm" class="chat-form">
        <input type="text" placeholder="Type a message..." aria-label="Type your message" required>
        <button type="submit">→</button>
      </form>
    </section>
  </main>

  <script src="script.js"></script>
</body>
</html>
