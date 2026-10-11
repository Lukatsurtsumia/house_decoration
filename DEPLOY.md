# Deploying Plafondi with Coolify

Production runs from the **Dockerfile** in this repo (nginx + php-fpm on port **8080**).
Local development still uses Laravel Sail (`compose.yaml`) and is not affected.

No database is needed: prices and texts live in `config/homepage.php`, and sessions,
cache and the PDF rate limit are stored as files inside the container.

The site lives at **https://plafondi.com**. The first address,
`plafond.arte-company.com`, forwards there (see *Moving to a new domain* below).

## 1. Push the code

Coolify deploys from GitHub, so push first:

```bash
git push origin main
```

## 2. DNS

In the domain's Cloudflare zone, point **A records** for `plafondi.com` and `www.plafondi.com`
to the Coolify server's IP. Keep them **DNS only (grey cloud)** for the first deploy so Coolify
can issue its Let's Encrypt certificates.

## 3. Create the application in Coolify

1. **+ New → Application → Public Repository** → `https://github.com/Lukatsurtsumia/house_decoration`, branch `main`.
2. **Build Pack: Dockerfile.** Do not use Nixpacks.
3. **Ports Exposes:** `8080`.
4. **Domains:** `https://plafondi.com,https://www.plafondi.com,https://plafond.arte-company.com`
   (every address the site should answer on; the extra ones forward to `APP_URL`).
5. **Health check** (optional): path `/up`, port `8080`.

## 4. Environment variables

Paste these into the app's environment variables, click **Save**, then deploy.
The container has no `.env` file, so these are the only settings it gets.

```
APP_NAME=Plafondi
APP_ENV=production
APP_DEBUG=false
APP_KEY=                  # run `php artisan key:generate --show` locally and paste the base64:... value
APP_URL=https://plafondi.com
ASSET_URL=https://plafondi.com
SESSION_SECURE_COOKIE=true
REDIRECT_HOSTS=www.plafondi.com,plafond.arte-company.com
```

`ASSET_URL` must equal `APP_URL`. Behind the proxy the container only sees HTTP, and
without it the CSS/JS links can come out as `http://` and be blocked on the `https://` page.

`REDIRECT_HOSTS` lists addresses that should send visitors to the same page on `APP_URL`
(301, or 308 for form posts). Each of them must also be in the Coolify **Domains** field.

## 5. Deploy

Click **Deploy**. On start the container caches config, routes and views automatically.
Check `https://plafondi.com/up`, the home page, and the calculator's **PDF-ის ჩამოტვირთვა** button.

## Moving to a new domain

1. Add the new domain's DNS records (step 2) and wait until they resolve to the server.
2. In Coolify, put the new domain **first** in **Domains** and keep the old ones after it.
3. Set `APP_URL` and `ASSET_URL` to the new domain, and list the old domains in `REDIRECT_HOSTS`.
4. Save and redeploy, then open an old address and check that it lands on the new one.

## Notes

- **After changing prices or texts** in `config/homepage.php`: commit, push, then redeploy.
  Coolify skips the build when the commit hasn't changed, so always push a new commit.
- **No persistent volume is needed.** Nothing is uploaded; the PDF font cache in
  `storage/fonts` is rebuilt automatically after each deploy.
- **Photos:** the hero slideshow still uses Pexels photos. Our own work photos live in
  `public/images/projects` and are listed under `photos` in `config/homepage.php`.
