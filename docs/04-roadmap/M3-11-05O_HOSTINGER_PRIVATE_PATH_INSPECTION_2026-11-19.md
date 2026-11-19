# M3-11-05O — Domain directory private-path inspection result (2026-11-19)

## Owner-provided SSH output

The owner ran read-only commands against `$HOME/domains/estudent.pk`.

Observed listing:
- `.builds/`
- `DO_NOT_UPLOAD_HERE` (zero-byte marker file)
- `public_html/`
- `.trash/`

The subsequent `find "$HOME/domains/estudent.pk" -mindepth 1 -maxdepth 1 -type d -print` command was entered, but its output was not included in the pasted transcript. The `ls -la` output above establishes the visible top-level entries.

The owner also re-confirmed:
- New V2 directory `$HOME/domains/estudent.pk/public_html/institutes-v2` exists and is empty.
- Backup directory candidate `$HOME/domains/estudent.pk/public_html/institutes-v2.000000` exists.

## Interpretation

No designated private application directory is visible directly under `$HOME/domains/estudent.pk`. The `DO_NOT_UPLOAD_HERE` marker explicitly warns against uploading at that level. Do not create application files or a private source folder there without Hostinger confirmation.

The current evidence does not prove that the account has no usable private directory elsewhere. The account home previously showed `/home/u537436044` and a `.private-backups` folder, but that folder is a backup location and must not be repurposed.

## Next decision

Do not deploy the full Laravel repository into the public V2 folder. Do not place source files in the domain root beside `DO_NOT_UPLOAD_HERE`. Request Hostinger confirmation of the supported private application path and supported method for serving only Laravel's `public/` directory.

The owner can ask Hostinger support:
"On my Web Hosting account, what is the approved writable directory outside the website document root for Laravel application source, Composer vendor, storage and .env, and what supported method do you recommend to expose only the Laravel public directory at /institutes-v2/ without symlinks? My account home is /home/u537436044 and domain is estudent.pk. Please confirm whether SSH-based deployment to a private directory and a separate public-file publish step are supported on my plan."

## Safety

- Git auto-deployment remains OFF.
- New public V2 target remains empty.
- Previous deployment folder remains preserved.
- No directory creation, file transfer, permission change, deployment, deletion, migration, DB/DNS/V1 change, secret access or extra spend occurred.
