# 📚 Online Bookstore Project

An end-to-end Online Bookstore web application built using **HTML**, **CSS**, **PHP**, and **MySQL**. This platform allows users to browse, purchase, and review books — while enabling the admin to manage reviews and user feedback efficiently.

---

## 🔧 Tech Stack

- **Frontend**: HTML5, CSS3  
- **Backend**: PHP  
- **Database**: MySQL (with PL/SQL components)  
- **Tools**: XAMPP / WAMP / Localhost for development

---

## 🌟 Features

### 👤 User Side
- User Registration and Login
- Browse books by categories
- Add books to cart and purchase
- View and manage orders
- **Post-purchase reviews** through *My Orders* (only after delivery)
- Seamless UI/UX for navigation and review writing

### 🛠️ Admin Side
- Admin Login Panel
- View customer reviews per book
- View list of customers who wrote reviews
- Backend management of reviews

---

## 💡 Special Implementation

- ✅ **3NF-Compliant Database** structure
- ✅ **PL/SQL Integration**: 
  - **Stored Procedures** for order processing
  - **Triggers** for review validation
  - **Functions** for generating book statistics
  - **Cursors** for admin-side reporting
- ✅ **Secure Review Flow**:
  - Reviews can only be submitted from purchased order history
  - No dropdown — auto-redirects to the specific review page
  - Post-review, redirects user back to dashboard or order page

---

## 🛠️ Setup Instructions

1. Clone this repository:
   ```bash
   git clone https://github.com/omdeshpande09012005/Online_BookStore.git
Import the database:

Open phpMyAdmin

Create a new database (e.g., bookstore)

Import schema.sql and insert.sql from /sql/ folder

Configure database credentials in your .php files

Start your local server using XAMPP/WAMP

Run index.html in browser

📜 Future Improvements
Add search and filter functionality

Add book image previews

Include payment gateway simulation

Improve mobile responsiveness

👨‍💻 Developer
Om Deshpande

Languages: English, Hindi, Marathi

Hackerrank: ★★★★★ in SQL and C++

Interests: PC building, performance benchmarking, gaming

🙌 Motivation
This project reflects my passion for full-stack development, structured database design, and creating smooth, realistic user flows — with a special focus on post-purchase engagement through meaningful features like review control and admin feedback.

📩 Contact
Feel free to reach out for collaborations, suggestions, or feedback!
