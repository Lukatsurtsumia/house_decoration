# Deploying Plafond with Coolify

Production runs from the **Dockerfile** in this repo (nginx + php-fpm on port **8080**).
Local development still uses Laravel Sail (`compose.yaml`) and is not affected.

No database is needed: prices and texts live in `config/homepage.php`, and sessions,
cache and the PDF rate limit are stored as files inside the container.

## 1. Push the code

Coolify deploys from GitHub, so push first:

```bash
git push origin main
```

## 2. DNS

Point an **A record** for `plafond.arte-company.com` to the Coolify
server's IP. If the zone is on Cloudflare, keep it **DNS only (grey cloud)** for the first
deploy so Coolify can issue its Let's Encrypt certificate.

## 3. Create the application in Coolify

1. **+ New → Application → Private Repository (GitHub App)** → `Lukatsurtsumia/house_decoration`, branch `main`.
2. **Build Pack: Dockerfile.** Do not use Nixpacks.
3. **Ports Exposes:** `8080`.
4. **Domains:** `https://plafond.arte-company.com`.
5. **Health check** (optional): path `/up`, port `8080`.

## 4. Environment variables

Paste these into the app's environment variables, click **Save**, then deploy.
The container has no `.env` file, so these are the only settings it gets.

```
APP_NAME=Plafond
APP_ENV=production
APP_DEBUG=false
APP_KEY=                  # run `php artisan key:generate --show` locally and paste the base64:... value
APP_URL=https://plafond.arte-company.com
ASSET_URL=https://plafond.arte-company.com
SESSION_SECURE_COOKIE=true
```

`ASSET_URL` must equal `APP_URL`. Behind the proxy the container only sees HTTP, and
without it the CSS/JS links can come out as `http://` and be blocked on the `https://` page.

## 5. Deploy

Click **Deploy**. On start the container caches config, routes and views automatically.
Check `https://plafond.arte-company.com/up`, the home page, and the calculator's **PDF-ის ჩამოტვირთვა** button.

## Notes

- **After changing prices or texts** in `config/homepage.php`: commit, push, then redeploy.
  Coolify skips the build when the commit hasn't changed, so always push a new commit.
- **No persistent volume is needed.** Nothing is uploaded; the PDF font cache in
  `storage/fonts` is rebuilt automatically after each deploy.
- **Photos** are loaded from Pexels. Replace them with your own work photos when you have them.
