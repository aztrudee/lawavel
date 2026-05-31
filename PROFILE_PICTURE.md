# Profile Picture – Base64 Database Storage

## Why Base64 in the Database?

Platforms like **Railway, Render, Heroku, and Fly.io** use ephemeral (temporary) container
storage. Any file written to disk (e.g. `storage/app/public/profiles/`) is **deleted on every
redeploy or container restart**. Storing the image as a base64 string in the database solves
this because the database persists across deployments.

---

## How It Works

1. User uploads an image via the Profile page (max 2MB, jpeg/jpg/png only).
2. `ProfileController::update()` reads the raw binary of the file and encodes it:
   ```php
   $binary = file_get_contents($file->getRealPath());
   $base64 = base64_encode($binary);
   $data['profile_picture_base64'] = 'data:' . $mime . ';base64,' . $base64;
   ```
3. The full **data URI** string (e.g. `data:image/jpeg;base64,/9j/4AAQ...`) is saved to the
   `profile_picture_base64` column (`LONGTEXT`) in the `users` table.
4. Views render the image directly in an `<img>` tag:
   ```html
   <img src="{{ $user->profile_picture_base64 }}">
   ```
   No file system, no `Storage::url()`, no symlinks needed.

---

## Database Column

| Column | Type | Notes |
|---|---|---|
| `profile_picture` | VARCHAR(255) | Legacy file path – kept for backward compatibility |
| `profile_picture_base64` | LONGTEXT | Full data URI string – used for display |

---

## Deployment Steps

### Fresh install (new database)
Run `gonzales_db.sql` in phpMyAdmin – the `profile_picture_base64` column is already included.

### Existing database (add the column)
Run this single SQL statement:
```sql
ALTER TABLE users ADD COLUMN profile_picture_base64 LONGTEXT NULL AFTER profile_picture;
```

### Laravel migration (if using Artisan)
```bash
php artisan migrate
```
The migration file `2024_01_02_000001_add_profile_picture_base64_to_users_table.php` handles it.

---

## Validation Rules

```php
'profile_picture' => 'nullable|image|mimes:jpeg,jpg,png|max:2048'
```

- Allowed types: `jpeg`, `jpg`, `png`
- Max size: **2MB** (2048 KB)
- Field is optional – existing picture is kept if no new file is uploaded

---

## Size Consideration

A 2MB image becomes roughly **2.7MB** as a base64 string (base64 adds ~33% overhead).
`LONGTEXT` supports up to **4GB**, so this is not a concern for profile pictures.

For very high-traffic apps with many users, consider using an object storage service
(AWS S3, Cloudflare R2, Backblaze B2) instead. For a school/portfolio project, base64
in the database is perfectly fine.

---

## Files Changed

| File | Change |
|---|---|
| `database/migrations/2024_01_02_000001_add_profile_picture_base64_to_users_table.php` | New migration |
| `app/Models/User.php` | Added `profile_picture_base64` to `$fillable` |
| `app/Http/Controllers/ProfileController.php` | Converts upload to base64 data URI |
| `resources/views/layouts/app.blade.php` | Sidebar avatar uses base64 |
| `resources/views/profile/show.blade.php` | Profile card uses base64 |
| `resources/views/users/index.blade.php` | Users table avatar uses base64 |
| `gonzales_db.sql` | Includes new column + migration record |
