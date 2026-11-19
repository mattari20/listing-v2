# M3-11-05J — Hostinger account-home and empty staging target evidence (2026-11-19)

## Owner-supplied screenshots

The owner supplied two Hostinger File Manager screenshots on 2026-11-19.

### Account Home view

The visible top-level entries are:
- `.builds`
- `.trash`
- `public_html`
- `DO_NOT_UPLOAD_HERE` (0 B)

No clearly designated private application directory outside `public_html` is visible in this screenshot. The marker file name explicitly warns against uploading at this level. Do not create or deploy application files at this level unless Hostinger support/documentation confirms an approved private path.

### New V2 target view

The breadcrumb shows `public_html/institutes-v2`. The file manager displays an empty-folder message ("It feels lonely here..."). This is evidence that the new target was empty at the time of the screenshot.

## Deployment configuration carried forward

The prior owner-supplied Git settings screenshot showed:
- Repository: `listing-v2`
- Branch: `main`
- Deployment root: `public_html/institutes-v2`
- Auto-deployment disabled
- Last deployment: prior manual deployment at 2026-11-19 10:25

No new deployment was shown after the directory was recreated.

## Decision

Do not upload or deploy the full Laravel repository into the empty public target. That would expose application source directories beneath the public document root and repeat the earlier layout problem.

Do not upload application source to the account Home level because the owner screenshot contains a `DO_NOT_UPLOAD_HERE` marker and no approved private directory is identified.

The clean staging deployment remains blocked pending a Hostinger-supported mechanism for keeping Laravel source, vendor, configuration, storage and secrets outside the public web root while exposing only the Laravel `public/` output.

## Next supported investigation

Use the existing SSH access, if available, only for read-only inspection to establish:
- the exact current working directory (`pwd`);
- the actual account home path;
- the documented/approved private application path, if one exists;
- whether a private directory outside `public_html` is writable and executable by the website's PHP process;
- whether the Hostinger account supports a separate public-output publishing mechanism without symlinks or additional spend.

Do not create directories, copy files, change permissions, alter PHP settings, run Composer/Artisan, or deploy as part of this read-only investigation.

## Safety state

- Option A preparation authorized.
- New `public_html/institutes-v2` shown empty.
- Previous deployment remains preserved in the renamed backup folder.
- Account Home contains `DO_NOT_UPLOAD_HERE`; no private source location has been approved.
- Git auto-deployment remains OFF.
- No deployment, file creation on Hostinger, deletion, migration, DB operation, DNS change, V1 change, credential access or additional spend occurred.
