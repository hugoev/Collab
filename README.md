# Collab - Real-time Collaborative Document Editor

A minimal real-time collaborative document editor built with Laravel, WebSockets (Pusher), and pure CSS.

## Features

- ✅ User authentication (email + password)
- ✅ Dashboard to list user-owned documents
- ✅ Create and edit documents
- ✅ Real-time collaborative editing
- ✅ Autosave on edit
- ✅ Clean UI with custom pure CSS design system

## Requirements

- PHP 8.2+
- Composer
- MySQL or PostgreSQL
- Pusher account (for real-time features) or Laravel WebSockets

## Installation

1. **Clone the repository and install dependencies:**

```bash
composer install
```

2. **Set up environment variables:**

Copy `.env.example` to `.env` and configure:

```bash
cp .env.example .env
php artisan key:generate
```

3. **Configure database:**

Update your `.env` file with database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=collab
DB_USERNAME=root
DB_PASSWORD=
```

4. **Configure Pusher (for real-time features):**

Get your Pusher credentials from [pusher.com](https://pusher.com) and add to `.env`:

```env
BROADCAST_CONNECTION=pusher

PUSHER_APP_ID=your-app-id
PUSHER_APP_KEY=your-app-key
PUSHER_APP_SECRET=your-app-secret
PUSHER_APP_CLUSTER=your-cluster
```

5. **Run migrations:**

```bash
php artisan migrate
```

6. **Start the development server:**

```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## Usage

1. **Register a new account** at `/register`
2. **Login** at `/login`
3. **Create a document** from the dashboard
4. **Edit documents** - changes are saved automatically and broadcast to all connected users viewing the same document

## Architecture

- **Backend:** Laravel 12
- **Realtime:** Pusher WebSockets
- **Frontend:** Blade templates + Vanilla JavaScript
- **Styling:** Pure CSS (no frameworks)
- **Database:** MySQL/PostgreSQL

## Routes

- `GET /` - Redirects to login
- `GET /login` - Login page
- `POST /login` - Login handler
- `GET /register` - Registration page
- `POST /register` - Registration handler
- `GET /dashboard` - User documents list (auth required)
- `GET /documents/{id}` - Document editor (auth required)
- `POST /documents` - Create document (auth required)
- `PUT /documents/{id}` - Update document (auth required)

## Real-time Editing

The editor uses Pusher WebSockets to broadcast document updates in real-time. When a user types:

1. Changes are debounced (1 second delay)
2. Content is saved to the database via AJAX
3. Update is broadcast to all other users viewing the same document
4. Other users' editors update instantly

## Development

The project follows Laravel conventions. Key files:

- `app/Models/Document.php` - Document model
- `app/Http/Controllers/DocumentController.php` - Document CRUD
- `app/Events/DocumentUpdated.php` - Broadcasting event
- `resources/views/editor.blade.php` - Editor view with real-time JS
- `public/css/ui.css` - Custom CSS design system

## Notes

- Documents are owned by users (one-to-many relationship)
- Only document owners can view/edit their documents
- Conflict resolution: Last update wins (simple MVP approach)
- Plain text only (no rich text editing)

## License

MIT
